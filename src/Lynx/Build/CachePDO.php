<?php

namespace Lynx\Build;

use Lynx\DataClasses\TemplateData;

class CachePDO implements IGenerator
{

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
}