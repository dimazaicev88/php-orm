<?php

namespace Lynx\Scanner;

/**
 * Поиск классов шаблонов DB
 */
class Scanner
{

    /**
     * Сканирование директории и поиск классов
     * @param string $dir Директория со списком классов
     * @return array<string>
     */
    function fromDir(string $dir): array
    {
        return scandir($dir);
    }


    /**
     * Сканирование классов и получение мета информации для генерации шаблонов
     * @param array<string> $classes Список классов
     * @return void
     */
    function fromArray(array $classes)
    {

    }
}