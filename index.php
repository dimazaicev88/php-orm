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

#[Table(name: 'lxc')]
class LXC
{
    #[Column(name: 'lxc_uid', notNull: true)]
    public string $uid;

    #[Column(name: 'proxmox_lxc_id', notNull: true)]
    public int $proxmoxLxcId;

    #[Column(name: 'parent_proxmox_lxc_id')]
    public string $parentProxmoxLxcId;

    #[Column(name: 'hostname')]
    public string $hostname;

    #[Column(name: 'ip')]
    public string $ip;

    #[Column(name: 'enable_recreate')]
    public string $enableRecreate;

    #[Column(name: 'no_branch', notNull: true)]
    public bool $noBranch;

    #[Column(name: 'lxc_type_code', notNull: true)]
    public string $typeCode;
}

//\$config = [
//    'host' => '127.0.0.1',
//    'dbname' => 'test_db',
//    'username' => 'root',
//    'password' => 'root',
//    'charset' => 'utf8mb4'
//];


$config = new Config();
$config->setClasses([LXC::class])
    ->setDbHost("127.0.0.1")
    ->setDbName("test_db")
    ->setDbUser("root")
    ->setDbPassword("rootpassword")
    ->setCharset("utf8")
    ->setOutputDir(str_replace("\\", "/", __DIR__) . "/generated")
    ->setNamespace("Ptr");

(new  Build())->generate($config);
