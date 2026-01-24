<?php

namespace Lynx\DataClasses;

class ModelMetaData
{
    /**
     * @param string $className
     * @param string $tableName
     * @param array<ClasField> $clasFields
     */
    public function __construct(
        public string $className,
        public string $tableName,
        public array  $clasFields,
    )
    {

    }

}