<?php

namespace Zqhong\FastdEloquent;

use FastD\Config\Config;
use FastD\Container\Container;
use FastD\Container\ServiceProviderInterface;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

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
     * @param Container $container
     * @return mixed
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

        // 分页设置
        // 1. 设置 page 参数（当前页）
        LengthAwarePaginator::currentPageResolver(function () {
            return (int)Arr::get(array_merge($_GET, $_POST), 'page', 1);
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