<?php

namespace Lynx\DataClasses;

readonly class ClasField
{

    function __construct(
        public string    $fieldType = "string",
        public string    $fieldName = "string",
        public ?DBColumn $column = null,
    )
    {
    }
}