<?php

namespace Lynx\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Column
{
    public function __construct(
        string $name,
        bool   $notNull = false,
        bool   $autoIncrement = false
    )
    {
    }
}