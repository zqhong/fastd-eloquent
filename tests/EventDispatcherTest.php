<?php

namespace Zqhong\FastdEloquent\Test;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Database\Events\TransactionCommitted;
use Illuminate\Events\Dispatcher;

class EventDispatcherTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testEvent()
    {
        $triggerCnt = 0;
        $app = Application::$app;

        /** @var Dispatcher $eventDispatcher */
        $eventDispatcher = $app->get('eloquent_event_dispatcher');
        $eventDispatcher->listen(TransactionBeginning::class, function (TransactionBeginning $payload) use (&$triggerCnt) {
            $triggerCnt++;
        });
        $eventDispatcher->listen(TransactionCommitted::class, function (TransactionCommitted $payload) use (&$triggerCnt) {
            $triggerCnt++;
        });

        $this->assertEquals(0, $triggerCnt);

        // beganTransaction event
        Manager::connection()->beginTransaction();
        $this->assertEquals(1, $triggerCnt);

        // committed event
        Manager::connection()->commit();
        $this->assertEquals(2, $triggerCnt);
    }
}