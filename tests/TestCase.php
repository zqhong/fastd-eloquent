<?php

namespace Zqhong\FastdEloquent\Test;

use FastD\Config\Config;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Zqhong\FastdEloquent\EloquentServiceProvider;

class TestCase extends BaseTestCase
{
    /**
     * @var Connection
     */
    protected $connection;

    protected function setUp()
    {
        $app = new Application();

        $config = new Config();
        $config->merge([
            'database' => [
                'default' => [
                    'adapter' => 'sqlite',
                    'name' => ':memory:',
                    'prefix' => '',
                ],
            ],
        ]);
        $app->add('config', $config);

        $provider = new EloquentServiceProvider();
        $provider->register($app);

        // 创建一张 Post 表用于测试
        /** @var Manager $eloquentDb */
        $eloquentDb = $app->get('eloquent_db');
        $connection = $eloquentDb->getConnection('default');
        $this->connection = $connection;

        $connection->getSchemaBuilder()->dropIfExists('posts');
        $connection->getSchemaBuilder()->create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('author');
            $table->string('title');
            $table->text('content');
            $table->integer('created_at');
            $table->integer('updated_at');
        });
    }

    protected function tearDown()
    {
        $app = Application::$app;
        /** @var Manager $eloquentDb */
        $eloquentDb = $app->get('eloquent_db');
        $connection = $eloquentDb->getConnection('default');

        $connection
            ->table('posts')
            ->delete();
        $connection->getSchemaBuilder()->dropIfExists('posts');
        $connection->disconnect();
    }
}