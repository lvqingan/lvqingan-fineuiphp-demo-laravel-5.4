<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 初始化配置信息
        \FineUIPHP\Config\GlobalConfig::loadConfig(array(
            'Theme'           => 'Default',  // 默认主题
            'ResourceHandler' => 'res'  // 资源文件获取入口
        ));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
