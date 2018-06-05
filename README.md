# fastD Eloquent
使用 Eloquent 替换 fastD 自带的 [Medoo](https://medoo.in/)

## 安装
```bash
$ composer require -vvv zqhong/fastd-eloquent
```

## 配置
修改配置文件 `config/app.conf`，添加 `EloquentServiceProvider`，如下：
```php
<?php
return [
    // 省略了无关配置
    'services' => [
        \ServiceProvider\EloquentServiceProvider::class,
    ],
];
```

修改配置文件 `.env.yml`，添加如下信息：
```yaml
database:
    default:
        adapter: db_adapter
        name: db_name
        host: db_host
        user: db_username
        pass: db_password
        charset: db_charset
        port: db_port
        prefix: db_prefix
```

其中，`driver` 的可选值为：`mysql`、`pgsql`、`sqlite` 和 `sqlsrv`。

## 直接使用
```php
<?php
<?php

use Illuminate\Database\Capsule\Manager;

// create
Manager::connection('default')
    ->table('demo')
    ->insert([
        'content' => 'hello world',
    ]);

// read
// 参数一可省略，默认值为 default
Manager::connection('default')
    ->table('demo')
    ->where('id', 1)
    ->where('created_at', '<=', time())
    ->get([
        'id',
        'content',
    ]);

// update
Manager::connection('default')
    ->table('demo')
    ->where('id', 1)
    ->update([
        'content' => 'hello 2',
    ]);

// delete
Manager::connection('default')
    ->table('demo')
    ->where('id', 1)
    ->delete();

```

## 配置 Model 使用
```php
<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class DemoModel extends Model
{
    public $table = 'demo';

    public static function fetchAll()
    {
        return static::query()
            ->get()
            ->toArray();
    }
}
```

## 分页
### 分页的简单使用
```php
<?php
$perPage = 10;
$columns = ['*'];
$pageName = 'page';

$paginator = YourModel::query()->paginate($perPage, $columns, $pageName);
$data = $paginator->toArray();

// 注：page 参数（当前页）会自动从 $_GET 或 $_POST 中的 page 参数自动获取，不需要单独设置。
// 参考代码
//LengthAwarePaginator::currentPageResolver(function () {
//    return (int)Arr::get(array_merge($_GET, $_POST), 'page', 1);
//});
```


## 其他资源
如果你对在其他框架中使用 Eloquent 感兴趣，请参考 Slim 的这篇文章 - [Using Eloquent with Slim](https://www.slimframework.com/docs/cookbook/database-eloquent.html)。

如果你对 Eloquent 不熟悉，请阅读下面的资料。
* [Laravel - Database: Query Builder](https://laravel.com/docs/5.4/queries)
* [Laravel - Database: Pagination](https://laravel.com/docs/5.4/pagination)
* [Laravel - Eloquent: Getting Started](https://laravel.com/docs/5.4/eloquent)
* [Laravel - Eloquent: Collections](https://laravel.com/docs/5.4/eloquent-collections)
