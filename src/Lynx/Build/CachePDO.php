<?php

namespace Lynx\Build;

class CachePDO
{
    function genCachePDOCode(string $namespace): string
    {

        return <<<PHP
        <?php
        
        namespace $namespace\Cache;
        
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
                if (isset(self::\$cachePDO[\$key])) {
                    return self::\$cachePDO[\$key];
                }
                
                return null;
            }
        }

        PHP;
    }
}