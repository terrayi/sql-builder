<?php

namespace Sql;

use Sql\Join\Full;
use Sql\Join\Inner;
use Sql\Join\Left;
use Sql\Join\Outer;
use Sql\Join\Right;
use Sql\Protocol\From;
use Sql\Protocol\Joinable;
use Sql\protocol\Sequel;

abstract class AbstractFrom implements From, Sequel
{
    protected $joins = [];

    public function join(Joinable $join)
    {
        $this->joins[] = $join;
        return $this;
    }

    public function fullJoin($statement, string $alias, $condition)
    {
        return $this->join(new Full($statement, $alias, $condition));
    }

    public function innerJoin($statement, string $alias, $condition)
    {
        return $this->join(new Inner($statement, $alias, $condition));
    }

    public function leftJoin($statement, string $alias, $condition)
    {
        return $this->join(new Left($statement, $alias, $condition));
    }

    public function outerJoin($statement, string $alias, $condition)
    {
        return $this->join(new Outer($statement, $alias, $condition));
    }

    public function rightJoin($statement, string $alias, $condition)
    {
        return $this->join(new Right($statement, $alias, $condition));
    }

    abstract public function toSql();
}
