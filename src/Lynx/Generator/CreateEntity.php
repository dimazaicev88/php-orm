<?php

namespace Lynx\Generator;

use Lynx\Config\Config;
use Lynx\DataClasses\ClassField;
use Lynx\DataClasses\DataForSaveFile;
use Lynx\DataClasses\TemplateData;


class CreateEntity implements IGenerator
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }


//    function genCreateEntityCode(string $namespace, ModelMetaData $modelMetaData): string
//    {
//        $setterCode = $this->genSetterCode($modelMetaData->classFields);
//
//        return <<<PHP
//        <?php
//
//        namespace $namespace\Repository\\{$modelMetaData->className};
//
//        use $namespace\Cache\CachePDO;
//        use $namespace\Database\Database;
//
//        class {$modelMetaData->className}Create
//        {
//            protected static string \$table = '$modelMetaData->tableName';
//            private array \$fields;
//
//            {$setterCode}
//
//            function save(): void
//            {
//                \$pdo = Database::connection();
//                \$tableFields = implode(', ', array_keys(\$this->fields));
//                \$cleanTableFields = str_replace(':', '', \$tableFields);
//                \$sql = "INSERT INTO $modelMetaData->tableName (\$cleanTableFields) VALUES (\$tableFields)";
//                \$key = md5(\$sql);
//                \$stmt = CachePDO::get(\$key);
//                if (!\$stmt) {
//                    \$stmt = \$pdo->prepare(\$sql);
//                    CachePDO::set(\$key, \$stmt);
//                }
//                \$stmt->execute(\$this->fields);
//            }
//        }
//        PHP;
//    }

    /**
     * @param array<ClassField> $fields
     * @return string
     */
    private function genSetterCode(array $fields): string
    {
        $resultCode = "";
        foreach ($fields as $field) {
            if ($field->column !== null) {
                $name = ucfirst($field->name);
                $type = $field->column->notNull ? "$field->type" : "?$field->type";
                $resultCode .= <<<PHP
                public function set{$name}($type \$value): self
                {
                    \$this->fields[':{$field->column->name}'] = \$value;
                    return \$this;                
                }
                PHP;
            }
        }

        return $resultCode;
    }

    function generate(TemplateData $templateData): string
    {
        $setterCode = $this->genSetterCode($templateData->modelMetaData->classFields);

        return <<<PHP
        <?php
        
        namespace $templateData->namespace\Repository\\{$templateData->modelMetaData->className};

        use $templateData->namespace\Cache\CachePDO;
        use $templateData->namespace\Database\Database;
        
        class {$templateData->modelMetaData->className}Create
        {
            protected static string \$table = '{$templateData->modelMetaData->tableName}';
            private array \$fields;
            
            {$setterCode}
                
            function save(): void
            {
                \$pdo = Database::connection();
                \$tableFields = implode(', ', array_keys(\$this->fields));
                \$cleanTableFields = str_replace(':', '', \$tableFields);
                \$sql = "INSERT INTO {$templateData->modelMetaData->tableName} (\$cleanTableFields) VALUES (\$tableFields)";
                \$key = md5(\$sql);
                \$stmt = CachePDO::get(\$key);
                if (!\$stmt) {
                    \$stmt = \$pdo->prepare(\$sql);
                    CachePDO::set(\$key, \$stmt);
                }
                \$stmt->execute(\$this->fields);
            }            
        }
        PHP;
    }

    function dataForSaveFile(TemplateData $templateData): DataForSaveFile
    {
        $createEntityCode = $this->generate($templateData);
        return new DataForSaveFile(
            path: join("/", [
                $this->config->getOutputDir(),
                "Repository",
                ucfirst($templateData->modelMetaData->className)
            ]),
            className: $templateData->modelMetaData->className . "Create",
            code: $createEntityCode,
        );
    }
}