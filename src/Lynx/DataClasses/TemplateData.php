<?php

namespace Lynx\DataClasses;

readonly class TemplateData
{
    public function __construct(
        public string         $namespace = "",
        public ?ModelMetaData $modelMetaData = null
    )
    {
    }
}