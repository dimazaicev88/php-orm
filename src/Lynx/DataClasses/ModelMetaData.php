<?php

namespace Lynx\DataClasses;

class ModelMetaData
{
    /**
     * @param string $clasName
     * @param string $tableName
     * @param array<ClassField> $classFields
     */
    public function __construct(
        public string $clasName,
        public string $tableName,
        public array  $classFields,
    )
    {

    }

}