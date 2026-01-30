<?php

namespace Lynx\DataClasses;

readonly class DataForSaveFile
{
    public function __construct(
        public string $path,
        public string $className,
        public string $code,
    )
    {

    }
}