<?php

namespace Lynx\Parser;

use Exception;
use Lynx\Build\Config;
use Lynx\DataClasses\ClassField;
use Lynx\DataClasses\DBColumn;
use Lynx\DataClasses\ModelMetaData;
use ReflectionClass;
use ReflectionException;

class Parser
{
    private const attrColumn = "Lynx\Attributes\Column";
    private const attrTable = "Lynx\Attributes\Table";

    /**
     * @param Config $config
     * @return array<ModelMetaData>
     * @throws ReflectionException
     */
    public function parse(Config $config): array
    {
        /**
         * @var $models array<ModelMetaData>
         */
        $models = [];
        foreach ($config->getClasses() as $modelClass) {
            $reflection = new ReflectionClass($modelClass);
            $className = $reflection->getShortName();
            $properties = $this->extractProperties($reflection);
            $tableName = $this->getTableName($reflection);
            $models[] = new ModelMetaData(
                tableName: $tableName,
                classFields: $properties,
            );
        }

        return $models;
    }

    /**
     * @return array<ClassField>
     * @throws Exception
     */
    private function extractProperties(ReflectionClass $reflection): array
    {
        /**
         * @var $properties array<ClassField>
         */
        $properties = [];

        foreach ($reflection->getProperties() as $property) {
            $attributes = $property->getAttributes();


            foreach ($attributes as $attribute) {
                $attrName = $attribute->getName();

                if ($attrName === self::attrColumn) {
                    $properties[] = new ClassField(
                        fieldType: $property->getType()->getName(),
                        fieldName: $property->getName(),
                        column: DBColumn::fromArray(column: $attribute->getArguments())
                    );
                }
            }
        }

        return $properties;
    }

    /**
     * @throws Exception
     */
    private
    function getTableName(ReflectionClass $reflection): string
    {
        $tableName = "";
        $attributes = $reflection->getAttributes();

        foreach ($attributes as $attribute) {
            if ($attribute->getName() === self::attrTable) {
                $args = $attribute->getArguments();
                $tableName = $args['table'] ?? strtolower($reflection->getShortName());
                break;
            }
        }

        if (empty($tableName)) {
            throw new Exception('Table name cannot be empty');
        }
        return $tableName;
    }
}