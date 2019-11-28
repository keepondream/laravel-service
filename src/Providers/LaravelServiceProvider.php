<?php
/**
 * Description:
 * Author: WangSx
 * DateTime: 2019-11-28 07:35
 */

namespace Keepondream\LaravelService\Providers;


use Illuminate\Support\ServiceProvider;
use Keepondream\LaravelService\Console\MakeServices;

class LaravelServiceProvider extends ServiceProvider
{

    public function boot()
    {
    }

    public function register()
    {
        # 注册脚本
        $this->registerKeepCommand();
    }

    /**
     * Author: WangSx
     * DateTime: 2019-11-28 13:18
     */
    protected function registerKeepCommand()
    {
        $this->app->singleton('keepondream.make.services', function ($app) {
            return new MakeServices($app['files']);
        });
        $this->commands('keepondream.make.services');
    }

}