<?php

namespace Lynx\Generator;

use Lynx\Config\Config;
use Lynx\DataClasses\DataForSaveFile;
use Lynx\DataClasses\TemplateData;

class Database implements IGenerator
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
        
        namespace $templateData->namespace\Database;
        
        use PDO;
        
        class Database
        {
            private static ?Database \$instance = null;
            private PDO \$pdo;
        
            private function __construct()
            {
                \$dsn = "mysql:host={$this->config->getDbHost()};dbname={$this->config->getDbName()};charset={$this->config->getCharset()}";
        
                \$options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
        
                \$this->pdo = new PDO(\$dsn, "{$this->config->getDbUser()}", "{$this->config->getDbPassword()}", \$options);
        
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

    function dataForSaveFile(TemplateData $templateData): DataForSaveFile
    {
        $databaseCode = $this->generate($templateData);
        return new DataForSaveFile(
            path: join("/", [$this->config->getOutputDir(), "Database"]),
            className: "Database",
            code: $databaseCode,
        );
    }
}