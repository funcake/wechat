<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['middleware'=>['oauth']], function () use ($router){
	$router->get('',function() {
		 $app = app('wechat.official_account');

       $list = $app->user->select($app->user->list()['data']['openid'])['user_info_list'];

        return view('hello',compact('list'));   
	});
});

$router->post('express','ExpressController@order');

