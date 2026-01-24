<?php

namespace Lynx\DataClasses;

readonly class ClassField
{

    function __construct(
        public string    $type,
        public string    $name,
        public ?DBColumn $column = null,
    )
    {
    }
}