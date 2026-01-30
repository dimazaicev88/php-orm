<?php

namespace Lynx\Build;

use Lynx\Config\Config;
use Lynx\DataClasses\TemplateData;
use Lynx\Generator\CachePDO;
use Lynx\Generator\CreateEntity;
use Lynx\Generator\Database;
use Lynx\Generator\DeleteEntity;
use Lynx\Generator\Provider;
use Lynx\IO\File;
use Lynx\Parser\Parser;
use ReflectionException;

class Build
{

    /**
     * @throws ReflectionException
     */
    public function buildCode(Config $config): void
    {
        $parser = new Parser();
        $listModelsMetaData = $parser->parse($config->getClasses());
        foreach ($listModelsMetaData as $modelMetaData) {
            //Provider
            File::saveCode(
                (new Provider($config))->dataForSaveFile(
                    new TemplateData(namespace: $config->getNamespace(), modelMetaData: $modelMetaData)
                )
            );

            //Create
            File::saveCode(
                (new CreateEntity($config))->dataForSaveFile(
                    new TemplateData(namespace: $config->getNamespace(), modelMetaData: $modelMetaData)
                )
            );

            //Delete
            File::saveCode(
                (new DeleteEntity($config))->dataForSaveFile(
                    new TemplateData(namespace: $config->getNamespace(), modelMetaData: $modelMetaData)
                )
            );
        }

        //Database
        File::saveCode(
            (new Database($config))->dataForSaveFile(
                new TemplateData(namespace: $config->getNamespace())
            )
        );

        //Cache
        File::saveCode(
            (new CachePDO($config))->dataForSaveFile(
                new TemplateData(namespace: $config->getNamespace())
            )
        );
    }
}