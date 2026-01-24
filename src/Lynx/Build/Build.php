<?php

namespace Lynx\Build;

use Lynx\DataClasses\ModelMetaData;
use Lynx\Parser\Parser;
use ReflectionException;
use PhpParser\{ParserFactory, PrettyPrinter};

class Build
{

    private string $outputDir;

    public function __construct(string $outputDir = 'generated/')
    {
        $this->outputDir = $outputDir;
    }

    /**
     * @throws ReflectionException
     */
    public function generate(Config $config): void
    {
        $parser = new Parser();
        $createEntity = new CreateEntity();
        $listModelsMetaData = $parser->parse($config->getClasses());
        foreach ($listModelsMetaData as $modelMetaData) {
            $providerCode = $this->genProviderCode($modelMetaData);
            $createEntityCode = $createEntity->genCreateEntityCode($modelMetaData);
            $this->saveCode(
                outputDir: $this->outputDir . "Repository/" . ucfirst($modelMetaData->className . "/"),
                clasName: $modelMetaData->className,
                code: $providerCode
            );
            $this->saveCode(
                outputDir: $this->outputDir . "Repository/" . ucfirst($modelMetaData->className . "/"),
                clasName: $modelMetaData->className . "Create",
                code: $createEntityCode
            );
        }

        $databaseCode = (new Database())->genDatabaseProvider($config);
        $this->saveCode(
            outputDir: $this->outputDir . "/Database/",
            clasName: "Database",
            code: $databaseCode
        );
    }

//    private static ?{$modelMetaData->clasName}Delete \$userDelete = null;
//            private static ?{$modelMetaData->clasName}Update \$userUpdate = null;
//            private static ?{$modelMetaData->clasName}UpdateBulk \$userUpdateBulk = null;

//    static function delete(): {$modelMetaData->clasName}Delete
//{
//if (self::\$userDelete === null) {
//self::\$userDelete = new {$modelMetaData->clasName}Delete();
//}
//
//return self::\$userDelete;
//            }
//
//            static function update(): {$modelMetaData->clasName}Update
//            {
//                if (self::\$userUpdate === null) {
//                self::\$userUpdate = new {$modelMetaData->clasName}Update();
//                }
//
//                return self::\$userUpdate;
//            }
//
//            static function updateBulk(): {$modelMetaData->clasName}UpdateBulk
//            {
//                if (self::\$userUpdateBulk === null) {
//                self::\$userUpdateBulk = new {$modelMetaData->clasName}UpdateBulk();
//                }
//
//                return self::\$userUpdateBulk;
//            }

    private function genProviderCode(ModelMetaData $modelMetaData): string
    {
        return <<<PHP
        <?php
        
        namespace Repository\\{$modelMetaData->className};
        
        class $modelMetaData->className
        {
            private static ?{$modelMetaData->className}Create \$create = null;
          
            static function create(): {$modelMetaData->className}Create
            {
                if (self::\$create === null) {
                    self::\$create = new {$modelMetaData->className}Create();
                }
        
                return self::\$create;
            }
        }

        PHP;
    }

    private function saveCode(string $outputDir, string $clasName, string $code): void
    {
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0755, true);
        }


        $parser = (new ParserFactory())->createForNewestSupportedVersion();
        $ast = $parser->parse($code);
        $prettyPrinter = new PrettyPrinter\Standard();
        $prettyPrintFile = $prettyPrinter->prettyPrintFile($ast);

        file_put_contents($outputDir . $clasName . '.php', $prettyPrintFile);
    }
}