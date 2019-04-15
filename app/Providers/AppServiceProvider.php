<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
