<?php

namespace Lynx\DataClasses;

use Exception;

readonly class DBColumn
{
    function __construct(
        public string $name,
        public bool   $notNull = false,
        public bool   $autoIncrement = false,
    )
    {
    }

    /**
     * @throws Exception
     */
    public static function fromArray(array $column): DBColumn
    {
        return new DBColumn(
            name: $column['name'] ?? throw new Exception('Column name cannot be empty'),
            notNull: (bool)($column['notNull'] ?? false),
            autoIncrement: (bool)($column['autoIncrement'] ?? false)
        );
    }
}