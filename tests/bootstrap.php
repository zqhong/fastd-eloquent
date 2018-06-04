<?php

require __DIR__ . '/../vendor/autoload.php';

use FastD\Config\Config;
use Zqhong\FastdEloquent\EloquentServiceProvider;
use Zqhong\FastdEloquent\Test\Application;

$app = new Application();

$config = new Config();
$config->merge([
    'database' => [
        'default' => [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ],
    ],
]);
$app->add('config', $config);

$provider = new EloquentServiceProvider();
$provider->register($app);
