<?php

namespace Sql;

use Sql\Protocol\Sequel;

class Column implements Sequel
{
    protected $statement;

    protected $alias;

    public function __construct(string $statement, string $alias = '')
    {
        $this->statement = $statement;
        $this->alias = $alias;
    }

    public function toSql()
    {
        return $this->statement . ($this->alias ? " AS {$this->alias}" : '');
    }
}
