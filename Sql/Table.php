<?php

namespace Sql;

class Table extends AbstractFrom
{
    protected $name;
    protected $alias = '';

    public function __construct(string $name, string $alias = '')
    {
        $this->name = $name;
        $this->alias = $alias;
    }

    public function setAlias(string $alias)
    {
        $this->alias = $alias;
        return $this;
    }

    public function toSql()
    {
        $sql = $this->name;

        if ($this->alias)
        {
            $sql .= ' AS ' . $this->alias;
        }

        if (count($this->joins))
        {
            foreach ($this->joins as $join)
            {
                $sql .= ' ' . $join->toSql();
            }
        }

        return $sql;
    }
}
