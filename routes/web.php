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
$router->get('','WeChatController@home');

$router->get('group','WeChatController@group');

$router->post('','WeChatController@update');



$router->get('user/create','UserController@create');
// $router->get('admin','WeChatController@group');
$router->get('user/change','UserController@change');

$router->post('express','ExpressController@order');

