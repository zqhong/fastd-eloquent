<?php

namespace Zqhong\FastdEloquent\Database;

use Illuminate\Database\MySqlConnection as BaseMySQLConn;
use PDO;

/**
 * @package Zqhong\FastdEloquent
 */
class MySQLConnection extends BaseMySQLConn
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
                // 某些情况下，如果使用 PDO::PARAM_INT，当 $value 大于2147483647会出问题
                PDO::PARAM_STR
            );
        }
    }
}