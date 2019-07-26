<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    
    public function boot()
    {
        view()->composer('layout',function($view) {
            $view->with('config',\App\Jssdk::config());
        });
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
