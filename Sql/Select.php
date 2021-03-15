<?php

namespace Sql;

use Sql\Protocol\From;
use Sql\Protocol\Sequel;

class Select implements Sequel
{
    public const SORT_ASCENDING = 'ASC';
    public const SORT_DESCENDING = 'DESC';

    protected $selects = [];
    protected $froms = [];
    protected $where;
    protected $orderBys = [];
    protected $groupBys = [];
    protected $offsetValue = 0;
    protected $limitValue = null;

    public function __construct(...$columns)
    {
        if (is_array($columns))
        {
            $this->addColumns($columns);
        } 
    }

    public function addColumns(array $columns)
    {
        foreach ($columns as $column)
        {
            $this->addColumn($column);
        }
    }

    public function addColumn($column, string $alias = '')
    {
        if ($column instanceof Column)
        {
            $this->selects[] = $column;
        }
        else if (is_string($column))
        {
            $column = str_replace(' as ', ' AS ', $column);

            if (strpos($column, ' AS ') !== false)
            {
                list($columnName, $columnAlias) = explode(' AS ', $column);
                $this->selects[] = new Column($columnName, $columnAlias);
            }
            else
            {
                $this->selects[] = new Column($column, $alias);
            }
        }

        return $this;
    }

    public function from(From $from, callable $callback = null)
    {
        $this->froms[] = $from;

        if (is_callable($callback))
        {
            $callback($from);
        }

        return $this;
    }

    public function fromTable(string $name, callable $callback = null)
    {
        return $this->from(new Table($name), $callback);
    }

    public function fromSubQuery(Select $query, string $alias, callable $callback = null)
    {
        return $this->from(new SubQuery($query, $alias), $callback);
    }

    public function where(callable $callback = null)
    {
        if ($this->where === null)
        {
            $this->where = new Where();
        }

        $callback($this->where);
        return $this;
    }

    public function orderBy($column, $sortDirection = self::SORT_ASCENDING)
    {
        $this->orderBys[] = [
            'column' => $column,
            'option' => $sortDirection
        ];
        return $this;
    }

    public function groupBy($group)
    {
        $this->groupBys[] = $group;
        return $this;
    }

    public function offset($offset = 0)
    {
        $this->offsetValue = $offset;
        return $this;
    }

    public function limit($limit)
    {
        $this->limitValue = $limit;
        return $this;
    }

    public function toSql()
    {
        $sql = 'SELECT ';
        $selects = [];

        foreach ($this->selects as $column)
        {
            $selects[] = $column->toSql();            
        }

        $sql .= implode(', ', $selects) . ' FROM ';
        $froms = [];

        foreach ($this->froms as $from)
        {
            $froms[] = $from->toSql();
        }

        $sql .= implode(', ', $froms);

        if ($this->where)
        {
            $sql .= ' WHERE ' . $this->where->toSql();
        }

        if ($this->orderBys)
        {
            $orderBys = [];

            foreach ($this->orderBys as $orderBy)
            {
                $orderBys[] = trim("{$orderBy['column']} {$orderBy['option']}");
            }

            $sql .= ' ORDER BY ' . implode(', ', $orderBys);
        }

        if ($this->groupBys)
        {
            $sql .= ' GROUP BY ' . implode(', ', $this->groupBys);
        }

        if ($this->offsetValue)
        {
            $sql .= ' OFFSET ' . $this->offsetValue;
        }

        if ($this->limitValue)
        {
            $sql .= ' LIMIT ' . $this->limitValue;
        }

        return $sql;
    }

    public function __invoke($columns)
    {
        if (is_array($columns))
        {
            $this->addColumns($columns);
        }
        else if (is_string($columns))
        {
            $this->addColumn($columns);
        }
    }
}
