<?php

namespace Lynx\Creator;



class UserCreator
{
    private array $fields;

    function setId(string $id): UserCreator
    {
        $this->fields[':id'] = $id;
        return $this;
    }

    function setName(?string $name): UserCreator
    {
        $this->fields[':name'] = $name;
        return $this;
    }

    function setLogin(?string $login): UserCreator
    {
        $this->fields[':login'] = $login;
        return $this;
    }

    function save(): void
    {
        $pdo = Database::connection();
        $tableFields = implode(', ', array_keys($this->fields));
        $cleanTableFields = str_replace(':', '', $tableFields);
        $sql = "INSERT INTO users ($cleanTableFields) VALUES ($tableFields)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($this->fields);
    }
}


class User
{
    private static ?UserCreator $userCreator = null;

    static function create(): UserCreator
    {
        if (self::$userCreator === null) {
            self::$userCreator = new UserCreator();
        }

        return self::$userCreator;
    }
}

User::create()->
setName("a8m")->
setLogin(12)->
save();