<?php

namespace Sql;

class SubQuery extends AbstractFrom
{
    protected $select;
    protected $alias = '';

    public function __construct(Select $select, string $alias = '')
    {
        $this->select = $select;
        $this->alias = $alias;
    }

    public function setAlias(string $alias)
    {
        $this->alias = $alias;
        return $this;
    }

    public function toSql()
    {
        $sql = '(' . $this->select->toSql() . ')';

        if ($this->alias)
        {
            $sql .= ' AS ' . $this->alias;
        }

        if ($this->joins)
        {
            foreach ($this->joins as $join)
            {
                $sql .= ' ' . $join->toSql();
            }
        }

        return $sql;
    }
}
