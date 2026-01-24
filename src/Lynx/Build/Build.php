<?php

namespace Lynx\Build;

use Lynx\DataClasses\ModelMetaData;
use Lynx\Parser\Parser;
use ReflectionException;

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
            $genProviderCode = $this->genProviderCode($modelMetaData);
            $genCreateEntity = $createEntity->genCreateEntityCode($modelMetaData);
            $this->saveCode($modelMetaData->clasName, $genProviderCode);
            $this->saveCode($modelMetaData->clasName."Create", $genCreateEntity);
        }
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
        
        namespace Repository;
        
        class User
        {
            private static ?{$modelMetaData->clasName}Creat \$create = null;
          
            static function create(): {$modelMetaData->clasName}Creat
            {
                if (self::\$create === null) {
                    self::\$create = new {$modelMetaData->clasName}Creat();
                }
        
                return self::\$create;
            }
        }

        PHP;
    }

    private function saveCode(string $clasName, string $code): void
    {
        if (!is_dir($this->outputDir)) {
            mkdir($this->outputDir, 0755, true);
        }

        file_put_contents($this->outputDir . $clasName . '.php', $code);
    }
}