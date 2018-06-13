<?php

namespace Zqhong\FastdEloquent;

use FastD\Config\Config;
use FastD\Container\Container;
use FastD\Container\ServiceProviderInterface;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Events\Dispatcher;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Zqhong\FastdEloquent\Database\ConnectionFactory;

/**
 * Class EloquentServiceProvider
 *
 * @package ServiceProvider
 */
class EloquentServiceProvider implements ServiceProviderInterface
{
    /**
     * @var Manager
     */
    protected $capsule;

    /**
     * 注册 Eloquent 服务
     *
     * @param Container $container
     */
    public function register(Container $container)
    {
        /** @var Config $config */
        $config = $container->get('config');
        $dbNames = array_keys($config->get('database', []));
        $this->capsule = new Manager();

        foreach ($dbNames as $dbName) {
            $dbConfig = $config->get(sprintf('database.%s', $dbName), []);
            $this->addConnection($dbName, $dbConfig);
        }

        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
        $container['eloquent_db'] = $this->capsule;

        $this->setPageResolver($container);
        $this->setEvent($container);
        $this->extendManager();
    }

    /**
     * 扩展
     */
    protected function extendManager()
    {
        $connFactory = new ConnectionFactory($this->capsule->getContainer());
        $this
            ->capsule
            ->getDatabaseManager()
            ->extend('mysql', function (array $config, $name) use ($connFactory) {
                return $connFactory->make($config, $name);
            });
        $this
            ->capsule
            ->getDatabaseManager()
            ->extend('sqlite', function (array $config, $name) use ($connFactory) {
                return $connFactory->make($config, $name);
            });
    }

    /**
     * event dispatcher 设置
     *
     * @param Container $container
     */
    protected function setEvent(Container $container)
    {
        $eventDispatcher = new Dispatcher();
        $this->capsule->setEventDispatcher($eventDispatcher);
        $container['eloquent_event_dispatcher'] = $eventDispatcher;
    }

    /**
     * 分页设置
     *
     * @param Container $container
     */
    protected function setPageResolver(Container $container)
    {
        LengthAwarePaginator::currentPageResolver(function ($pageName) use ($container) {
            return (int)Arr::get(array_merge($_GET, $_POST), $pageName, 1);
        });
    }

    protected function addConnection($dbName, $dbConfig)
    {
        $eloquentSettings = [
            'driver' => Arr::get($dbConfig, 'adapter', 'mysql'),
            'host' => Arr::get($dbConfig, 'host', '127.0.0.1'),
            'database' => Arr::get($dbConfig, 'name', ''),
            'username' => Arr::get($dbConfig, 'user', 'root'),
            'password' => Arr::get($dbConfig, 'pass', 'root'),
            'charset' => Arr::get($dbConfig, 'charset', 'utf8'),
            'collation' => Arr::get($dbConfig, 'collation', 'utf8_general_ci'),
            'prefix' => Arr::get($dbConfig, 'prefix', ''),
        ];

        $this->capsule->addConnection($eloquentSettings, $dbName);
    }
}