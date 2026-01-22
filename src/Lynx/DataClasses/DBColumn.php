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
        if (empty($column['name'])) {
            throw new Exception('Column name cannot be empty');
        }

        $name = $column['name'];
        $notNull = false;
        $autoIncrement = false;
        if (!empty($column['notNull'])) {
            $notNull = $column['notNull'];
        }

        if (!empty($column['autoIncrement'])) {
            $autoIncrement = $column['autoIncrement'];
        }


        return new static($name, $notNull, $autoIncrement);
    }
}