<?php

namespace Lynx\Build;

use Lynx\DataClasses\ModelMetaData;
use Lynx\Parser\Parser;
use ReflectionException;
use PhpParser\{ParserFactory, PrettyPrinter};

class Build
{

    /**
     * @throws ReflectionException
     */
    public function generate(Config $config): void
    {
        $parser = new Parser();
        $createEntity = new CreateEntity();
        $listModelsMetaData = $parser->parse($config->getClasses());
        foreach ($listModelsMetaData as $modelMetaData) {
            $providerCode = $this->generateProviderCode($config->getNamespace(), $modelMetaData);
            $createEntityCode = $createEntity->genCreateEntityCode($config->getNamespace(), $modelMetaData);
            $path = join("/", [$config->getOutputDir(), "Repository", ucfirst($modelMetaData->className)]);
            $this->saveCode(
                outputDir: $path,
                clasName: $modelMetaData->className,
                code: $providerCode
            );
            $this->saveCode(
                outputDir: $path,
                clasName: $modelMetaData->className . "Create",
                code: $createEntityCode
            );
        }

        $this->generateDatabase($config);
        $this->generateCache($config);
    }

    function generateDatabase(Config $config): void
    {
        $databaseCode = (new Database())->genDatabaseProvider($config->getNamespace(), $config);
        $path = join("/", [$config->getOutputDir(), "Database"]);
        $this->saveCode(
            outputDir: $path,
            clasName: "Database",
            code: $databaseCode
        );
    }

    function generateCache(Config $config): void
    {
        $cachePDOCode = (new CachePDO())->genCachePDOCode($config->getNamespace());
        $path = join("/", [$config->getOutputDir(), "Cache"]);
        $this->saveCode(
            outputDir: $path,
            clasName: "CachePDO",
            code: $cachePDOCode
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

    private function generateProviderCode(string $namespace, ModelMetaData $modelMetaData): string
    {
        return <<<PHP
        <?php
        
        namespace $namespace\Repository\\{$modelMetaData->className};
        
        class $modelMetaData->className
        {
            private static ?{$modelMetaData->className}Create \$create = null;
          
            static function create(): {$modelMetaData->className}Create
            {
                 return self::\$create ??= new {$modelMetaData->className}Create();
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

        $path = join("/", [$outputDir, $clasName]);
        file_put_contents($path . '.php', $prettyPrintFile);
    }
}