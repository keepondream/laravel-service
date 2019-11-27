<?php
/**
 * Description:
 * Author: WangSx
 * DateTime: 2019-11-28 07:35
 */

namespace Keepondream\LaravelService\Providers;


use Illuminate\Support\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider
{

    public function boot()
    {
    }

    public function register()
    {
        $this->registerKeepCommand();
    }

    protected function registerKeepCommand()
    {
        $this->app->singleton('luffyzhao.make.excels', function ($app) {
            return new MakeExcels($app['files']);
        });
        $this->commands('luffyzhao.make.excels');
        $this->app->singleton('luffyzhao.make.searchs', function ($app) {
            return new MakeSearchs($app['files']);
        });
        $this->commands('luffyzhao.make.searchs');
        $this->app->singleton('luffyzhao.make.repositories', function ($app) {
            return new MakeRepositories($app['files']);
        });
        $this->commands('luffyzhao.make.repositories');
    }

}