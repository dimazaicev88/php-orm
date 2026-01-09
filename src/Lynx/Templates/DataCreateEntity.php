<?php

namespace Lynx\Templates;

readonly class DataCreateEntity
{
    function __construct(
        public string $className,
        public string $tableName,
        public string $propertiesCode,
    )
    {
    }
}