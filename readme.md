# Laravel 5.4

@(FineUIPHP)

[TOC]

### 1. 安装

首先您需要按照 [Laravel 5.4 官方文档](https://laravel.com/docs/5.4#installing-laravel) 的说明进行安装

假设您的安装目录是 /home/http/laravel

#### a. 将 `FineUIPHP` 的代码解压缩到您认为合适的任意目录，您可以将代码放到项目内，也可以放到项目外

假设您的解压目录是 /home/fineui-lib

#### b. 修改 `composer.json` 增加下面的配置信息

```json
    "repositories": [
        {
            "type": "path",
            "url": "../fineui-lib"
        }
    ]
```

#### c. 执行安装命令
```bash
composer require lvqingan/fineuiphp:dev-master
```

### 2. 配置

#### 2.1 初始化应用

修改 `app/Providers/AppServiceProvider.php` 的 `boot()` 方法增加下面的代码

```php

    public function boot()
    {
        // 初始化配置信息
        \FineUIPHP\Config\GlobalConfig::loadConfig(array(
            'Theme'           => 'Default',  // 默认主题
            'ResourceHandler' => 'res'  // 资源文件获取入口
        ));
    }
```

#### 2.2 增加事件响应

创建 `app/Listeners/RequestHandledListener.php`

```php
<?php

namespace App\Listeners;

use Illuminate\Foundation\Http\Events\RequestHandled;

class RequestHandledListener
{
    /**
     * Handle the event.
     *
     * @param RequestHandled $event
     *
     * @return void
     */
    public function handle(RequestHandled $event)
    {
        $content = $event->response->content();

        $event->response->setContent(\FineUIPHP\ResourceManager\ResourceManager::finish($content));
    }
}

```

并在 `app/Providers/EventServiceProvider.php`中进行注册

```php
    protected $listen = [
        // ......
        'Illuminate\Foundation\Http\Events\RequestHandled' => [
            'App\Listeners\RequestHandledListener',
        ],
    ];
```

### 3. 静态资源入口文件

修改 `routes/web.php` 增加路由

```php
Route::get('/res', function () {
    $handler = new \FineUIPHP\ResourceManager\ResourceHandler();

    $handler->ProcessRequest();
});
```

### 4. 演示例子

修改 `routes/web.php` 的默认路由为
```php
Route::get('/', 'Controller@index');
```

并在 `app/Http/Controllers/Controller.php` 中增加方法

```php
    public function index()
    {
        return view('index');
    }
```

创建 `resources/views/index.blade.php` 模板文件
```php
<html>
<head>
    <title>Laravel 5.4 使用教程</title>
</head>
<body style="padding: 20px;">
<?php
echo \FineUIPHP\FineUIControls::textBox()->text('默认文字');
echo '<hr/>';
echo \FineUIPHP\FineUIControls::button()->text('提交');
?>
</body>
</html>
```
