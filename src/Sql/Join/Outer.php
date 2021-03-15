<?php

namespace Sql\Join;

use Sql\AbstractJoinable;
use Sql\Traits\JoinableCommonToSql;

class Outer extends AbstractJoinable
{
    use JoinableCommonToSql;

    public function toSql()
    {
        return $this->getCommonToSql('OUTER');
    }
}
