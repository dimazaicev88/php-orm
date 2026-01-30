<?php

namespace Lynx\Config;

class Config
{

    /**
     * @var array<string>
     */
    private array $classes;
    private string $dbHost = "";
    private string $dbName = "";
    private string $charset = "";
    private string $dbUser = "";
    private string $dbPassword = "";
    private string $namespace = "";
    private string $outputDir = "";

    /**
     * @return array<string>
     */
    public function getClasses(): array
    {
        return $this->classes;
    }

    function getDbHost(): string
    {
        return $this->dbHost;
    }

    public function getDbName(): string
    {
        return $this->dbName;
    }

    public function getCharset(): string
    {
        return $this->charset;
    }

    public function getDbUser(): string
    {
        return $this->dbUser;
    }

    public function getDbPassword(): string
    {
        return $this->dbPassword;
    }

    public function getOutputDir(): string
    {
        return $this->outputDir;
    }

    public function setDbHost(string $dbHost): Config
    {
        $this->dbHost = $dbHost;
        return $this;
    }

    public function setDbName(string $dbName): Config
    {
        $this->dbName = $dbName;
        return $this;
    }

    public function setCharset(string $charset): Config
    {
        $this->charset = $charset;
        return $this;
    }

    public function setDbUser(string $dbUser): Config
    {
        $this->dbUser = $dbUser;
        return $this;
    }

    public function setDbPassword(string $dbPassword): Config
    {
        $this->dbPassword = $dbPassword;
        return $this;
    }

    /**
     * @param array<string> $array
     */
    public function setClasses(array $array): Config
    {
        $this->classes = $array;
        return $this;
    }

    public function setOutputDir(string $OutputDir): Config
    {
        $this->outputDir = $OutputDir;
        return $this;
    }

    public function setNameSpace(string $namespace): Config
    {
        $this->namespace = $namespace;
        return $this;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }
}