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
	$router->get('wechat','WechatController@serve');
});


$router->get('wechat', 'WeChatController@serve');

$router->post('wechat', 'WeChatController@serve');

$router->post('express','ExpressController@order');

