<?php

namespace Lynx\Build;

use Lynx\DataClasses\TemplateData;

class DeleteEntity implements IGenerator
{
    function generate(TemplateData $templateData): string
    {
        return <<<PHP
         <?php
                
                namespace $templateData->namespace\Repository\\{$templateData->modelMetaData->className};
        
                use $templateData->namespace\Cache\CachePDO;
                use $templateData->namespace\Database\Database;
                
                class {$templateData->modelMetaData->className}Create
                {
                   
                }
        
        PHP;
    }

    private function generateEq(string $fieldName, string $fieldType, string $columnName): string
    {
        return <<<PHP
            function {$fieldName}Eq($fieldType \$value) {
                \$this->fields[] = ['field' => '$columnName', 'value' => \$value, 'operator' => '='];
                return \$this;
            }

        PHP;
    }

    private function generateNotEq(string $fieldName, string $fieldType, string $columnName): string
    {
        return <<<PHP
            function {$fieldName}NotEq($fieldType \$value) {
                \$this->fields[] = ['field' => '$columnName', 'value' => \$value, 'operator' => '<>'];
                return \$this;
            }
        PHP;
    }


    private function generateGt(string $fieldName, string $fieldType, string $columnName): string
    {
        return <<<PHP
            function {$fieldName}Gt($fieldType \$value) {
                \$this->fields[] = ['field' => '$columnName', 'value' => \$value, 'operator' => '>'];
                return \$this;
            }
        PHP;
    }


    private function generateGtEq(string $fieldName, string $fieldType, string $columnName): string
    {
        return <<<PHP
            function {$fieldName}LtEq($fieldType \$value) {
                \$this->fields[] = ['field' => '$columnName', 'value' => \$value, 'operator' => '>='];
                return \$this;
            }
        PHP;
    }

    private function generateLt(string $fieldName, string $fieldType, string $columnName): string
    {
        return <<<PHP
            function {$fieldName}Lt($fieldType \$value) {
                \$this->fields[] = ['field' => '$columnName', 'value' => \$value, 'operator' => '<'];
                return \$this;
            }
        PHP;
    }


    private function generateLtEq(string $fieldName, string $fieldType, string $columnName): string
    {
        return <<<PHP
            function {$fieldName}LtEq($fieldType \$value) {
                \$this->fields[] = ['field' => '$columnName', 'value' => \$value, 'operator' => '<='];
                return \$this;
            }
        PHP;
    }

    private function generateIn(string $fieldName, string $fieldType, string $columnName): string
    {
        return <<<PHP
            function {$fieldName}In($fieldType \$value) {
                \$this->fields[] = ['field' => '$columnName', 'value' => \$value, 'operator' => 'IN'];
                return \$this;
            }
        PHP;
    }


    private function generateNotIn(string $fieldName, string $fieldType, string $columnName): string
    {
        return <<<PHP
            function {$fieldName}NotIn($fieldType \$value) {
                \$this->fields[] = ['field' => '$columnName', 'value' => \$value, 'operator' => 'NOT IN'];
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
}