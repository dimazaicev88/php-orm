<?php

namespace Lynx\DataClasses;

readonly class ListModels
{
    /**
     * @param array<ModelMetaData> $models
     */
    public function __construct(public array $models)
    {
    }
}