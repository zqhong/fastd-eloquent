<?php

namespace Zqhong\FastdEloquent\Test;

use FastD\Container\Container;

class Application extends Container
{
    /**
     * @var Application
     */
    public static $app;

    public function __construct()
    {
        static::$app = $this;
        $this->add('app', $this);
    }
}