<?php

namespace Lynx\Generator;

use Lynx\Config\Config;
use Lynx\DataClasses\DataForSaveFile;
use Lynx\DataClasses\TemplateData;

class Provider implements IGenerator
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }


    //
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


    function generate(TemplateData $templateData): string
    {
        return <<<PHP
        <?php
        
        namespace $templateData->namespace\Repository\\{$templateData->modelMetaData->className};
        
        class {$templateData->modelMetaData->className}
        {
            private static ?{$templateData->modelMetaData->className}Create \$create = null;
            private static ?{$templateData->modelMetaData->className}Delete \$delete = null;
            
            static function create(): {$templateData->modelMetaData->className}Create
            {
                 return self::\$create ??= new {$templateData->modelMetaData->className}Create();
            }
            
            static function delete(): {$templateData->modelMetaData->className}Delete
            {
                 return self::\$delete ??= new {$templateData->modelMetaData->className}Delete();
            }
        }

        PHP;
    }

    function dataForSaveFile(TemplateData $templateData): DataForSaveFile
    {
        $databaseCode = $this->generate($templateData);
        return new DataForSaveFile(
            path: join("/", [
                $this->config->getOutputDir(),
                "Repository",
                ucfirst($templateData->modelMetaData->className)
            ]),
            className: Database::class,
            code: $databaseCode,
        );
    }
}