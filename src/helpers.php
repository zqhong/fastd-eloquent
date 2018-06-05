<?php

if (!function_exists('eloquent_db')) {
    /**
     * 获取数据库连接实例
     *
     * @param string $name
     * @return \Illuminate\Database\Connection
     */
    function eloquent_db($name = 'default')
    {
        return app()->get('eloquent_db')->getConnection($name);
    }
}

if (!function_exists('eloquent_event_dispatcher')) {
    /**
     * @return \Illuminate\Events\Dispatcher
     */
    function eloquent_event_dispatcher()
    {
        return app()->get('eloquent_event_dispatcher');
    }
}
