<?php

use Lynx\Attributes\Column;
use Lynx\Attributes\Table;
use Lynx\Build\Build;
use Lynx\Build\Config;

require_once "vendor/autoload.php";

#[Table(name: 'user')]
class User
{
    #[Column(name: "id", notNull: true, autoIncrement: true)]
    public int $id;

    #[Column(name: "login")]
    public ?string $login;

    #[Column(name: "name")]
    public ?string $name;
}


$config = new Config();
$config->setClasses([
    User::class
]);
$config->outDir("/generated");
$config->nameSpace("/generated");
(new  Build())->generate($config);
