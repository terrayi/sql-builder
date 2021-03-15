<?php

namespace Sql\Traits;

trait JoinableCommonToSql
{
    public function getCommonToSql($joinPrefix = '')
    {
        $sql = ($joinPrefix ? "{$joinPrefix} " : '') .
            "JOIN {$this->statement}";

        if ($this->alias)
        {
            $sql .= " AS {$this->alias}";
        }

        $sql .= " ON ({$this->condition})";

        return $sql;
    }
}
