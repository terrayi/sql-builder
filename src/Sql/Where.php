<?php

namespace Sql;

class Where implements Protocol\Sequel
{
    public const LOGIC_AND = 'AND';
    public const LOGIC_OR = 'OR';

    protected $logic = self::LOGIC_AND;
    protected $nextSibling;
    protected $current;

    public function __construct($clause = '')
    {
        $this->current = $clause;
    }

    public function andWhere($clause)
    {   
        $this->logic = self::LOGIC_AND;
        return $this->addNextSibling($clause);
    }

    public function orWhere($clause)
    {   
        $this->logic = self::LOGIC_OR;
        return $this->addNextSibling($clause);
    }

    public function where($clause)
    {
        return $this->andWhere($clause);
    }

    protected function addNextSibling($clause)
    {
        if (is_callable($clause))
        {
            $this->nextSibling = new Where();
            $clause($this->nextSibling);
        }
        elseif ($clause instanceof Condition)
        {
            $this->nextSibling = new Where($clause);
        }
        elseif (is_string($clause))
        {
            $this->nextSibling = new Where($clause);
        }

        return $this->nextSibling;
    }

    public function toSql()
    {
        $sql = '';

        if (!empty($this->current))
        {
            if (is_string($this->current))
            {
                $sql = $this->current;
            }
            elseif ($this->current instanceof Condition) {
                $sql = $this->current->toSql();
            }

            if ($this->nextSibling)
            {
                $sql .=  " {$this->logic} " . $this->nextSibling->toSql();
            }
        }
        elseif ($this->nextSibling)
        {
            $sql = '(' . $this->nextSibling->toSql() . ')';
        }

        return $sql;
    }
}
