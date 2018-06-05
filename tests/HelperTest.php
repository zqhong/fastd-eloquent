<?php

namespace Zqhong\FastdEloquent\Test;

use Illuminate\Database\Connection;
use Illuminate\Events\Dispatcher;

/**
 * 辅助方法测试
 *
 * @package Zqhong\FastdEloquent\Test
 */
class HelperTest extends TestCase
{
    public function testEloquentDb()
    {
        $this->assertInstanceOf(Connection::class, eloquent_db());
    }

    public function testEloquentEventDispatcher()
    {
        $this->assertInstanceOf(Dispatcher::class, eloquent_event_dispatcher());
    }
}