<?php

namespace Lynx\Build;

use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

class Generator
{
    private string $outputDir;

    public function __construct(string $outputDir = 'generated/')
    {
        $this->outputDir = $outputDir;
    }

    /**
     * @param GeneratorConfig $config
     * @throws ReflectionException
     */
    public function generate(GeneratorConfig $config): void
    {
        foreach ($config->getClasses() as $modelClass) {
            $reflection = new ReflectionClass($modelClass);
            $className = $reflection->getShortName();
            $generatedClass = $className;
            $properties = $this->extractProperties($reflection);
            $tableName = $this->getTableName($reflection);

            $code = $this->generateEntityCode($generatedClass, $properties, $tableName);
            $this->saveCode($generatedClass, $code);
        }
    }

    private function extractProperties(ReflectionClass $reflection): array
    {
        $properties = [];

        foreach ($reflection->getProperties() as $property) {
            $attributes = $property->getAttributes();

            $column = [];
            foreach ($attributes as $attribute) {
                $attrName = $attribute->getName();

                if (str_contains($attrName, 'Column')) {
                    $column = $attribute->getArguments();
                    $column['name'] = $property->getName();
                    $column['type'] = $property->getType()->getName();
                }

                if (str_contains($attrName, 'PrimaryKey')) {
                    $column['primary'] = true;
                }
            }

            if (!empty($column)) {
                $properties[] = $column;
            }
        }

        return $properties;
    }

    private function getTableName(ReflectionClass $reflection): string
    {
        $attributes = $reflection->getAttributes();

        foreach ($attributes as $attribute) {
            if (str_contains($attribute->getName(), 'Entity')) {
                $args = $attribute->getArguments();
                return $args['table'] ?? strtolower($reflection->getShortName());
            }
        }

        return strtolower($reflection->getShortName());
    }

    private function generateEntityCode(string $className, array $properties, string $tableName): string
    {
        $propertiesCode = '';
        $methodsCode = '';

        foreach ($properties as $prop) {
            $propertiesCode .= $this->generatePropertyCode($prop);
            $methodsCode .= $this->generateGetterSetterCode($prop);
        }

        return <<<PHP
        <?php
        
        namespace Generated;
        
        use Database\BaseEntity;
        
        class $className extends BaseEntity
        {
            protected static string \$table = '$tableName';
            
        {$propertiesCode}
            
        {$methodsCode}
            
            public static function getColumns(): array
            {
                return [
                    {$this->generateColumnsArray($properties)}
                ];
            }
        }
        PHP;
    }

    private function generatePropertyCode(array $prop): string
    {
        $nullable = str_contains($prop['type'] ?? '', '?') ? 'null' : '';
        $default = $prop['default'] ?? $nullable;

        return sprintf(
            "    public %s \$%s = %s;\n",
            $prop['type'] ?? 'mixed',
            $prop['name'],
            var_export($default, true)
        );
    }

    private function generateGetterSetterCode(array $prop): string
    {
        $name = ucfirst($prop['name']);

        return <<<PHP
        
            public function get{$name}()
            {
                return \$this->{$prop['name']};
            }
            
            public function set{$name}(\$value): self
            {
                \$this->{$prop['name']} = \$value;
                return \$this;
            }
        PHP;
    }

    private function generateColumnsArray(array $properties): string
    {
        $columns = [];
        foreach ($properties as $prop) {
            $columns[] = "'{$prop['name']}' => " . var_export($prop, true);
        }

        return implode(",\n            ", $columns);
    }

    private function saveCode(string $className, string $code): void
    {
        if (!is_dir($this->outputDir)) {
            mkdir($this->outputDir, 0755, true);
        }

        file_put_contents(
            $this->outputDir . $className . '.php',
            $code
        );
    }
}