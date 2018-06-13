<?php

namespace Zqhong\FastdEloquent\Database;

use Illuminate\Database\Connection;
use Illuminate\Database\Connectors\ConnectionFactory as DefaultFactory;
use Illuminate\Database\PostgresConnection;
use Illuminate\Database\SqlServerConnection;
use InvalidArgumentException;

class ConnectionFactory extends DefaultFactory
{
    protected function createConnection($driver, $connection, $database, $prefix = '', array $config = [])
    {
        if ($resolver = Connection::getResolver($driver)) {
            return $resolver($connection, $database, $prefix, $config);
        }

        switch ($driver) {
            case 'mysql':
                // 备注：这里将 MySQL 连接重写
                return new MySQLConnection($connection, $database, $prefix, $config);
            case 'pgsql':
                return new PostgresConnection($connection, $database, $prefix, $config);
            case 'sqlite':
                // 备注：这里将 SQLite 连接重写
                return new SQLiteConnection($connection, $database, $prefix, $config);
            case 'sqlsrv':
                return new SqlServerConnection($connection, $database, $prefix, $config);
        }

        throw new InvalidArgumentException("Unsupported driver [$driver]");
    }
}