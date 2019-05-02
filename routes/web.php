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
$router->get('','ProductController@home');

$router->get('group','ProductController@group');

$router->post('','ProductController@update');

$router->post('delete','ProductController@delete');

$router->get('create','ProductController@create');

$router->get('wechat','WechatController@serve');

$router->post('wechat','WechatController@serve');

$router->get('user/create','UserController@create');
// $router->get('admin','WeChatController@group');
$router->get('user/change','UserController@change');

$router->post('user/change','UserController@change');

$router->post('express','ExpressController@order');

