<?php

namespace Lynx\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Ignore
{

    public function __construct(bool $delete = false)
    {
    }

}