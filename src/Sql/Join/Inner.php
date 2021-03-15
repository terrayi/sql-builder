<?php

namespace Sql\Join;

use Sql\AbstractJoinable;
use Sql\Traits\JoinableCommonToSql;

class Inner extends AbstractJoinable
{
    use JoinableCommonToSql;

    public function toSql()
    {
        return $this->getCommonToSql('INNER');
    }
}
