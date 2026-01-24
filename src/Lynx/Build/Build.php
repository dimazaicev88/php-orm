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
            private static ?{$modelMetaData->clasName}Creat \$userCreat = null;
            private static ?{$modelMetaData->clasName}Delete \$userDelete = null;
            private static ?{$modelMetaData->clasName}Update \$userUpdate = null;
            private static ?{$modelMetaData->clasName}UpdateBulk \$userUpdateBulk = null;
         
            static function create(): {$modelMetaData->clasName}Creat
            {
                if (self::\$userCreat === null) {
                    self::\$userCreat = new {$modelMetaData->clasName}Creat();
                }
        
                return self::\$userCreat;
            }
            
            static function delete(): {$modelMetaData->clasName}Delete
            {
                if (self::\$userDelete === null) {
                    self::\$userDelete = new {$modelMetaData->clasName}Delete();
                }
        
                return self::\$userDelete;
            }
            
            static function update(): {$modelMetaData->clasName}Update
            {
                if (self::\$userUpdate === null) {
                    self::\$userUpdate = new {$modelMetaData->clasName}Update();
                }
        
                return self::\$userUpdate;
            }
            
            static function updateBulk(): {$modelMetaData->clasName}UpdateBulk
            {
                if (self::\$userUpdateBulk === null) {
                    self::\$userUpdateBulk = new {$modelMetaData->clasName}UpdateBulk();
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
        
        class {$modelMetaData->clasName}Creat 
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
    function saveCode(string $clasName, string $code): void
    {
        if (!is_dir($this->outputDir)) {
            mkdir($this->outputDir, 0755, true);
        }

        file_put_contents(
            $this->outputDir . $clasName . '.php',
            $code
        );
    }
}