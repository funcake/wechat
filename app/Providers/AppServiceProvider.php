<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    
    public function boot()
    {
        $config = app('wechat.official_account')->jssdk->buildConfig(['openProductSpecificView'], $debug = false, $beta = false, $json = true);
        view()->composer('layout',function($view) {
            $view->with('config',$config);
        })
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    	$this->app->singleton('App\Wechat',function() {
    		return  app('wechat.official_account');
    	});

        $this->app->singleton('App\Wechat',function() {
            return app('wechat.work');
        });
    }
}
