<?php

namespace Lynx\Generator;

use Lynx\Config\Config;
use Lynx\DataClasses\DataForSaveFile;
use Lynx\DataClasses\TemplateData;

class CachePDO implements IGenerator
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    function generate(TemplateData $templateData): string
    {
        return <<<PHP
        <?php
        
        namespace $templateData->namespace\Cache;
        
        use PDO;
        use PDOStatement;
        
        class CachePDO
        {
            /**
             * @var array<string,PDOStatement>
             */
            private static array \$cachePDO;
            
            static function set(string \$key, PDOStatement \$pdoStatement): void
            {
                self::\$cachePDO[\$key] = \$pdoStatement;
            }
            
            static function get(string \$key): ?PDOStatement
            {
                return self::\$cachePDO[\$key] ?? null;
            }
        }

        PHP;
    }

    function dataForSaveFile(TemplateData $templateData): DataForSaveFile
    {
        $cachePDOCode = $this->generate($templateData);
        return new DataForSaveFile(
            path: join("/", [$this->config->getOutputDir(), "Cache"]),
            className: "CachePDO",
            code: $cachePDOCode,
        );
    }
}