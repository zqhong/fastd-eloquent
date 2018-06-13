<?php


namespace Zqhong\FastdEloquent\Database;

use Illuminate\Database\SQLiteConnection as DefaultMySQLConn;
use PDO;

class ZqhongSQLiteConn extends DefaultMySQLConn
{
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