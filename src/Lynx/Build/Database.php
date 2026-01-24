<?php

namespace Lynx\Build;

use Lynx\DataClasses\ModelMetaData;

class Database
{

    /**
     * @param Config $config
     * @return string
     */
    function genDatabaseProvider(Config $config): string
    {
        return <<<PHP
        <?php
        
        use PDO;
        use PDOException;
            
       class Database
        {
            private static ?Database \$instance = null;
            private PDO \$pdo;
        
            private function __construct()
            {
                \$config = [
                    'host' => '127.0.0.1',
                    'dbname' => 'test_db',
                    'username' => 'root',
                    'password' => 'root',
                    'charset' => 'utf8mb4'
                ];
        
                \$dsn = "mysql:host={$config->getDbHost()};dbname={$config->getDbName()};charset={$config->getCharset()}";
        
                \$options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
        
                try {
                    \$this->pdo = new PDO(\$dsn,$config->getDbUser(),$config->getDbPassword(), \$options);
                } catch (PDOException \$e) {
                    die("Database connection failed: " . \$e->getMessage());
                }
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