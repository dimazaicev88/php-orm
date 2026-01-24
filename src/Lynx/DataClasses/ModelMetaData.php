<?php

namespace Lynx\DataClasses;

class ModelMetaData
{
    /**
     * @param string $className
     * @param string $tableName
     * @param array<ClassField> $classFields
     */
    public function __construct(
        public string $className,
        public string $tableName,
        public array  $classFields,
    )
    {

    }

}