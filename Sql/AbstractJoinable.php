<?php

namespace Sql;

use Sql\Protocol\Joinable;
use Sql\Protocol\Sequel;

abstract class AbstractJoinable implements Joinable, Sequel
{
    protected $statement;
    protected $alias;
    protected $condition;

    public function __construct($statement, string $alias, $condition)
    {
        $this->statement = $statement;
        $this->alias = $alias;
        $this->condition = $condition;
    }

    public function setAlias(string $alias)
    {
        $this->alias = $alias;
        return $this;
    }

    public function setCondition($condition)
    {
        $this->condition = $condition;
        return $this;
    }

    abstract public function toSql();
}
