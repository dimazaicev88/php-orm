<?php

namespace Lynx\Parser;

use Exception;
use Lynx\DataClasses\ClassField;
use Lynx\DataClasses\DBColumn;
use Lynx\DataClasses\ModelMetaData;
use ReflectionClass;
use ReflectionException;

class Parser
{
    private const string attrColumn = "Lynx\Attributes\Column";
    private const string attrTable = "Lynx\Attributes\Table";

    /**
     * @param array $classes
     * @return array<ModelMetaData>
     * @throws ReflectionException
     * @throws Exception
     */
    public function parse(array $classes): array
    {
        /**
         * @var $models array<ModelMetaData>
         */
        $models = [];
        foreach ($classes as $modelClass) {
            $reflection = new ReflectionClass($modelClass);
            $className = $reflection->getShortName();
            $properties = $this->extractProperties($reflection);
            $tableName = $this->getTableName($reflection);
            $models[] = new ModelMetaData(
                className: ucfirst($className),
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
                        type: $property->getType()->getName(),
                        name: $property->getName(),
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
                $tableName = $args['name'] ?? strtolower($reflection->getShortName());
                break;
            }
        }

        if (empty($tableName)) {
            throw new Exception('Table name cannot be empty');
        }

        return $tableName;
    }
}