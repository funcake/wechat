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

	$router->post('update','ProductController@update');

	$router->post('delete','ProductController@delete');

	$router->get('join','ProductController@join');

});

//通知路由
$router->get('join','ServeController@join');

$router->get('wechat','ServeController@wechat');

$router->post('wechat','ServeController@wechat');

$router->get('change','ServeController@work');

$router->post('change','ServeController@work');

$router->post('order','ServeController@Message');

$router->get('test',function () {
	chmod();
});

//用户路由
$router->group(['prefix'=>'user'],function($router) {

	$router->post('photo','UserController@photoMessage');

	$router->get('create','UserController@create');
	// $router->get('admin','WeChatController@group');
	$router->post('regist','UserController@registDepartment');

});

//管理员路由
$router->group(['prefix'=>'admin'],function($router) {

	$router->get('home','AdminController@home');

	$router->get('flushGroups','AdminController@flushGroups');
	
	// $router->get('flush','AdminController@flush');

	$router->post('setDelivery','AdminController@setDelivery');

	$router->post('regist','AdminController@registDepartment');

	$router->get('uploadProduct','AdminController@uploadProduct');
    //创建商品
	$router->post('createProduct','AdminController@createProduct');

    $router->get('getProperty','AdminController@getProperty');

    $router->post('uploadImage','AdminController@uploadImage');

});

$router->post('express','ExpressController@order');
