<?php

namespace Lynx\IO;

use Lynx\DataClasses\DataForSaveFile;
use PhpParser\{ParserFactory, PrettyPrinter};

class File
{
    static function saveCode(DataForSaveFile $dataForSaveFile): void
    {
        if (!is_dir($dataForSaveFile->path)) {
            mkdir($dataForSaveFile->path, 0755, true);
        }

        $parser = (new ParserFactory())->createForNewestSupportedVersion();
        $ast = $parser->parse($dataForSaveFile->code);
        $prettyPrinter = new PrettyPrinter\Standard();
        $prettyPrintFile = $prettyPrinter->prettyPrintFile($ast);

        $path = join("/", [$dataForSaveFile->path, $dataForSaveFile->className]);
        file_put_contents($path . '.php', $prettyPrintFile);
    }
}