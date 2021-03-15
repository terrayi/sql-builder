<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Sql\Condition;
use Sql\Select;

function condition($leftHandSide)
{
   return new Condition($leftHandSide);
}

function select(...$columns)
{
    $obj = new Select();
    $obj($columns);
    return $obj;
}

$sql1 = select('column1', 'column2', 'column3 AS alias1')
    ->addColumn('column4', 'alias11')
    ->fromTable('table1', function ($table) {
        $table->setAlias('alias2')
            ->innerJoin('table11', 'aliasA', 'columnA = columnB')
            ->leftJoin('table12', 'aliasB', 'columnC = columnD');
    })
    ->fromTable('table2', function ($table) {
        $table->setAlias('alias3');
    })
    ->fromSubQuery(
        select('*')->fromTable('table3'),
        'alias4',
        function ($subQuery) {
            $subQuery->rightJoin('table31', 'aliasC', 'columnE = columnF');
        }
    )
    ->where(function ($condition) {
        $condition->where('column4 = value1')
            ->andWhere(condition('column4')->isEqualTo('value1'))
            ->andWhere('column5 = value2')
            ->andWhere(function ($where) {
                $where->where('column6 > value3')
                    ->orWhere('column7 <= value4');
            });
    });

$sql2 = clone $sql1;

$sql1->orderBy('columnx')
    ->orderBy('columny', 'DESC')
    ->orderBy('columnz', 'DESC')
    ->groupBy('columns')
    ->groupBy('columnt')
    ->offset(100)
    ->limit(20);

$sql2->where(function ($condition) {
    $condition->andWhere('columnU = value5');
});

echo $sql1->toSql(), PHP_EOL, PHP_EOL;
echo $sql2->toSql(), PHP_EOL;
