<?php

namespace Zqhong\FastdEloquent\Database;

use Illuminate\Database\MySqlConnection as DefaultMySQLConn;
use PDO;

/**
 * 备注：添加前缀（Zqhong），便于区分默认连接和自定义连接
 *
 * @package Zqhong\FastdEloquent
 */
class ZqhongMySQLConn extends DefaultMySQLConn
{
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