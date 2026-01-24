<?php

namespace Lynx\Build;

use Lynx\Creator\UserCreator;
use Lynx\DataClasses\ModelMetaData;

class Build
{

    private string $outputDir;

    public function __construct(string $outputDir = 'generated/')
    {
        $this->outputDir = $outputDir;
    }

    public function generate(): void
    {
//        $code = $this->generateEntityCode($generatedClass, $properties, $tableName);
//        $this->saveCode($generatedClass, $code);
    }


    private function genRepositoryCode(ModelMetaData $modelMetaData): string
    {
        $propertiesCode = '';
        $methodsCode = '';

//        foreach ($properties as $prop) {
//            $propertiesCode .= $this->generatePropertyCode($prop);
//            $methodsCode .= $this->generateGetterSetterCode($prop);
//        }

        return <<<PHP
        
        class User
        {
            private static ?{$modelMetaData->className}Creat \$userCreat = null;
            private static ?{$modelMetaData->className}Delete \$userDelete = null;
            private static ?{$modelMetaData->className}Update \$userUpdate = null;
            private static ?{$modelMetaData->className}UpdateBulk \$userUpdateBulk = null;
         
            static function create(): {$modelMetaData->className}Creat
            {
                if (self::\$userCreat === null) {
                    self::\$userCreat = new {$modelMetaData->className}Creat();
                }
        
                return self::\$userCreat;
            }
            
            static function delete(): {$modelMetaData->className}Delete
            {
                if (self::\$userDelete === null) {
                    self::\$userDelete = new {$modelMetaData->className}Delete();
                }
        
                return self::\$userDelete;
            }
            
            static function update(): {$modelMetaData->className}Update
            {
                if (self::\$userUpdate === null) {
                    self::\$userUpdate = new {$modelMetaData->className}Update();
                }
        
                return self::\$userUpdate;
            }
            
            static function updateBulk(): {$modelMetaData->className}UpdateBulk
            {
                if (self::\$userUpdateBulk === null) {
                    self::\$userUpdateBulk = new {$modelMetaData->className}UpdateBulk();
                }
        
                return self::\$userUpdateBulk;
            }
        }       

        PHP;
    }

    function genCreateEntityCode(ModelMetaData $modelMetaData): string
    {
        return <<<PHP
        <?php
        
        namespace Generated;
        
        use Database\BaseEntity;
        
        class {$modelMetaData->className}Creat 
        {
            protected static string \$table = '$modelMetaData->tableName';
            private array \$fields;
            
        {$propertiesCode}
            
        {$methodsCode}
            
        }
        PHP;
    }




    private
    function generatePropertyCode(array $prop): string
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

    private
    function generateGetterSetterCode(array $prop): string
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

    private
    function generateColumnsArray(array $properties): string
    {
        $columns = [];
        foreach ($properties as $prop) {
            $columns[] = "'{$prop['name']}' => " . var_export($prop, true);
        }

        return implode(",\n            ", $columns);
    }

    private
    function saveCode(string $className, string $code): void
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