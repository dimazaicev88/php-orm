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

//\$config = [
//    'host' => '127.0.0.1',
//    'dbname' => 'test_db',
//    'username' => 'root',
//    'password' => 'root',
//    'charset' => 'utf8mb4'
//];


$config = new Config();
$config->setClasses([User::class])
    ->setDbHost("127.0.0.1")
    ->setDbName("test_db")
    ->setDbUser("root")
    ->setDbPassword("root")
    ->setCharset("utf8")
    ->setOutDir("/generated")
    ->setNamespace("/generated");

(new  Build())->generate($config);
