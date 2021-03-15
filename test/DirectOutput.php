<?php

echo 'SELECT column1, column2, column3 AS alias1, column4 AS alias11 FROM table1 AS alias2 INNER JOIN table11 AS aliasA ON (columnA = columnB) LEFT JOIN table12 AS aliasB ON (columnC = columnD), table2 AS alias3, (SELECT * FROM table3) AS alias4 RIGHT JOIN table31 AS aliasC ON (columnE = columnF) WHERE (column4 = value1 AND column4 = value1 AND column5 = value2 AND (column6 > value3 OR column7 <= value4)) ORDER BY columnx ASC, columny DESC, columnz DESC GROUP BY columns, columnt OFFSET 100 LIMIT 20';
