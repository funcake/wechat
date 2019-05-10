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
$router->group([],function($router) {

	$router->get('','ProductController@home');

	$router->get('group','ProductController@group');

	$router->post('','ProductController@update');

	$router->post('delete','ProductController@delete');

	$router->get('create','ProductController@create');

});

$router->get('flush','AdminController@flushGroups');
$router->get('close','AdminController@close');
//通知路由
$router->get('wechat','ServeController@wechat');

$router->post('wechat','ServeController@wechat');

$router->get('change','ServeController@work');

$router->post('change','ServeController@work');


//用户路由
$router->group(['prefix'=>'user'],function($router) {

	$router->get('create','UserController@create');
	// $router->get('admin','WeChatController@group');

});

//管理员路由
$router->group(['prefix'=>'admin'],function($router) {

	$router->get('order','AdminController@order');

	// $router->get('')

});

$router->post('express','ExpressController@order');

