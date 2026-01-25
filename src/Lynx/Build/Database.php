<?php

namespace Lynx\Build;

class Database
{

    /**
     * @param string $namespace
     * @param Config $config
     * @return string
     */
    function genDatabaseProvider(string $namespace,Config $config): string
    {
        return <<<PHP
        <?php
        
        namespace $namespace\Database;
        
        use PDO;
        
        class Database
        {
            private static ?Database \$instance = null;
            private PDO \$pdo;
        
            private function __construct()
            {
                \$dsn = "mysql:host={$config->getDbHost()};dbname={$config->getDbName()};charset={$config->getCharset()}";
        
                \$options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
        
                \$this->pdo = new PDO(\$dsn, "{$config->getDbUser()}", "{$config->getDbPassword()}", \$options);
        
            }
        
            public static function connection(): PDO
            {
                if (self::\$instance === null) {
                    self::\$instance = new self();
                }
                return self::\$instance->pdo;
            }
        }
        
        PHP;
    }

}