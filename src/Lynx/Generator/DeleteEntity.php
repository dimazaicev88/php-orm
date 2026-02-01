<?php

namespace Lynx\Generator;

use Lynx\Config\Config;
use Lynx\DataClasses\DataForSaveFile;
use Lynx\DataClasses\TemplateData;

class DeleteEntity implements IGenerator
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    function generate(TemplateData $templateData): string
    {
        $methodsCode = '';
        foreach ($templateData->modelMetaData->classFields as $item) {
            $operators = [
                ['operator' => '=', 'text' => 'Eq'],
                ['operator' => '<>', 'text' => 'NotEq'],
                ['operator' => '>', 'text' => 'Gt'],
                ['operator' => '>=', 'text' => 'GtEq'],
                ['operator' => '<', 'text' => 'Lt'],
                ['operator' => '=<', 'text' => 'LtEq'],
                ['operator' => 'IN', 'text' => 'In'],
                ['operator' => 'NOT IN', 'text' => 'NotIn'],
            ];

            foreach ($operators as $operator) {
                $methodsCode .= $this->generateMethod(
                    fieldName: $item->name,
                    fieldType: $item->type,
                    columnName: $item->column->name,
                    operator: '"' . $operator['operator'] . '"',
                    operatorName: $operator['text'],
                    className: $templateData->modelMetaData->className,
                );
            }
        }

        return <<<PHP
         <?php             
            
         namespace $templateData->namespace\Repository\\{$templateData->modelMetaData->className};

         use $templateData->namespace\Cache\CachePDO;
         use $templateData->namespace\Database\Database;
        
         class {$templateData->modelMetaData->className}Delete
         {
            private array \$fields = [];
            
            $methodsCode
         }
        
        PHP;
    }

    private function generateMethod(
        string $fieldName,
        string $fieldType,
        string $columnName,
        string $operator,
        string $operatorName,
        string $className
    ): string
    {
        return <<<PHP
            function $fieldName$operatorName($fieldType \$value): {$className}Delete  {
                \$this->fields[] = ['field' => '$columnName', 'value' => \$value, 'operator' => $operator];
                return \$this;
            }
        PHP;
    }

    private function generateBetween(string $fieldName, string $fieldType, string $columnName): string
    {
        return <<<PHP
            function {$fieldName}Between($fieldType \$start, {$fieldType} \$end) {
                \$this->fields[] = ['field' => '$columnName', 'start' => \$start, 'end' => \$end, 'operator' => 'BETWEEN'];
                return \$this;
            }
        PHP;
    }

    private function generateOr(string $fieldName, string $fieldType, string $columnName): string
    {
        return <<<PHP
            function {$fieldName}Or($fieldType \$start, {$fieldType} \$end) {
                \$this->fields[] = ['type' => 'separator', 'operator' => 'OR'];
                return \$this;
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
            className: $templateData->modelMetaData->className,
            code: $createEntityCode,
        );
    }
}