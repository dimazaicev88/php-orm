<?php

namespace Lynx\Generator;

use Lynx\DataClasses\DataForSaveFile;
use Lynx\DataClasses\TemplateData;

interface IGenerator
{
    function generate(TemplateData $templateData): string;

    /**
     * Получить данные для сохранения файла.
     *
     * @param TemplateData $templateData
     * @return DataForSaveFile
     */
    function dataForSaveFile(TemplateData $templateData): DataForSaveFile;
}