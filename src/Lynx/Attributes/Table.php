<?php

namespace Lynx\Attributes;

use Attribute;



#[Attribute(Attribute::TARGET_CLASS)]
class Table
{
    public function __construct(string $name)
    {
    }

}