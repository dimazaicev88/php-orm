<?php

namespace Lynx\Templates;

class CreateEntity implements IEntityTemplate
{
    function __construct(public DataCreateEntity $dataCreateEntity)
    {
    }

    function template(): string
    {
        return <<<PHP
        <?php
        
        namespace Generated;
        
        use Database\BaseEntity;
        
        class {$this->dataCreateEntity->className}
        {
            private array \$fields = [];
            protected string \$table = '{$this->dataCreateEntity->tableName}';
            
            {$this->dataCreateEntity->propertiesCode}
                             
            public function save(): bool  {
                if (!empty(\$this->errors)) {
                   throw new ValidationException(implode(', ', \$this->errors));
                }
        
                \$pdo = Database::connection();
                \$tableFields = implode(', ', array_keys(\$this->fields));
                \$cleanTableFields = str_replace(':', '', \$tableFields);
                \$sql = "INSERT INTO {$this->dataCreateEntity->tableName} (\$cleanTableFields) VALUES (\$tableFields)";
                \$stmt = \$pdo->prepare(\$sql);
        
                return \$stmt->execute(\$this->fields);
            }
        }
        PHP;
    }

    static function setter(string $propName): string
    {
        $name = ucfirst($propName);

        return <<<PHP
            
            public function set$name(\$value): self
            {
                \$this->{$name} = \$value;
                return \$this;
            }
        PHP;
    }
}

