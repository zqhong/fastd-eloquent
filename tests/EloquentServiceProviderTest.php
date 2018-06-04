<?php

namespace Zqhong\FastdEloquent\Test;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Connection;
use PHPUnit\Framework\TestCase;

/**
 * 服务提供者测试
 *
 * @package Zqhong\FastdEloquent\Test
 */
class EloquentServiceProviderTest extends TestCase
{
    public function testRegister()
    {
        $app = Application::$app;

        /** @var Manager $eloquentDb */
        $eloquentDb = $app->get('eloquent_db');
        $this->assertInstanceOf(Manager::class, $eloquentDb);

        $connection = $eloquentDb->getConnection('default');
        $this->assertInstanceOf(Connection::class, $connection);
    }
}