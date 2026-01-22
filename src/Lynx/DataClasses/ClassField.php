<?php

namespace Lynx\DataClasses;

readonly class ClassField
{

    function __construct(
        public string    $fieldType = "string",
        public string    $fieldName = "string",
        public ?DBColumn $column = null,
    )
    {
    }
}