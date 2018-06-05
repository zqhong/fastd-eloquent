<?php

use Zqhong\FastdEloquent\Test\Application;

require __DIR__ . '/../vendor/autoload.php';

if (!function_exists('app')) {
    function app()
    {
        return Application::$app;
    }
}