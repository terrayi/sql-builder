<?php

namespace Sql\Join;

use Sql\AbstractJoinable;
use Sql\Traits\JoinableCommonToSql;

class Right extends AbstractJoinable
{
    use JoinableCommonToSql;

    public function toSql()
    {
        return $this->getCommonToSql('RIGHT');
    }
}
