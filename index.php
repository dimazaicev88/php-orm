<?php

use Lynx\Attributes\Column;
use Lynx\Attributes\Table;
use Lynx\Build\Config;

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


$config = new Config();
$config->setClasses([
    UserModel::class
]);
$config->outDir("/generated");
$config->nameSpace("/generated");
$models = (new  \Lynx\Parser\Parser())->parse($config->getClasses());
var_dump($models);