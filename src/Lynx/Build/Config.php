<?php

namespace Lynx\Build;

class Config
{
    /**
     * @var array<string>
     */
    private array $classes;

    /**
     * @param array<string> $array
     * @return void
     */
    public function setClasses(array $array): void
    {
        $this->classes = $array;
    }

    public function outDir(string $string)
    {

    }

    public function nameSpace(string $string)
    {

    }

    /**
     * @return array<string>
     */
    public function getClasses(): array
    {
        return $this->classes;
    }
}