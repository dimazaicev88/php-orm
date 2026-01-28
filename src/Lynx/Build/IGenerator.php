<?php

namespace Lynx\Build;

use Lynx\DataClasses\TemplateData;

interface IGenerator
{
    function generate(TemplateData $templateData): string;

}