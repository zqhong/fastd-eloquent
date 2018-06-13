<?php

namespace Zqhong\FastdEloquent\Database;

use Illuminate\Database\SQLiteConnection as BaseMySQLConn;
use PDO;

class SQLiteConnection extends BaseMySQLConn
{
    /**
     * Bind values to their parameters in the given statement.
     *
     * @param  \PDOStatement $statement
     * @param  array $bindings
     * @return void
     */
    public function bindValues($statement, $bindings)
    {
        foreach ($bindings as $key => $value) {
            $statement->bindValue(
                is_string($key) ? $key : $key + 1, $value,
                PDO::PARAM_STR
            );
        }
    }
}