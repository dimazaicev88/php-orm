<?php

use Lynx\Attributes\Column;
use Lynx\Attributes\Table;

require_once "vendor/autoload.php";

#[Table(name: 'user')]
class UserModel
{
    #[Column(name: "id", notNull: true, autoIncrement: true)]
    public int $id;

    #[Column(name: "login")]
    public string $login;

    #[Column(name: "login")]
    public string $name;
}


$config = new GeneratorConfig();
$config->setClasses([
    UserModel::class
]);
$config->outDir("/generated");
$config->nameSpace("/generated");
\Lynx\Build\Generator::generate($config);