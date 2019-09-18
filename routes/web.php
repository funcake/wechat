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
$router->group(['prefix'=>'merchant'],function($router) {

	$router->get('','MerchantController@home');

	$router->get('group','MerchantController@group');

	$router->post('update','MerchantController@update');

	$router->post('delete','MerchantController@delete');

	$router->get('join','MerchantController@join');


});
$router->group(['prefix'=>'shop'],function($router) {

	$router->get('','MerchantController@home');

});

//通知路由
$router->get('join','ServeController@join');

$router->get('wechat','ServeController@wechat');

$router->post('wechat','ServeController@wechat');

$router->get('change','ServeController@work');

$router->post('change','ServeController@work');

$router->post('order','ServeController@Message');

$router->get('test',function () {
	// return 123;
	// return app('wechat.official_account')->jssdk->buildConfig(['openProductSpecificView'], $debug = false, $beta = false, $json = true);
	return $list = app('wechat.official_account')->merchant->list(1);
	$response = app('wechat.official_account')->oauth->scopes(['snsapi_userinfo'])
                          ->redirect();
	$list = app('wechat.official_account')->merchant->list();
	$bin = array_filter($list,function($p) {
		return array_search('冰种', array_column( $p['product_base']['property'],'vid'));
	});
	$product=[];
foreach ($bin as $value) {
	$product[] = ['product_id' =>$value['product_id'],'mod_action' =>1];
}
	$mod = ['group_id' => 530591877,'product'=>$product];
	// dd($mod);
	app('wechat.official_account')->merchant->groupMod($mod);
	return 'ok';

});

//用户路由
$router->group(['prefix'=>'user'],function($router) {

	$router->post('photo','UserController@photoMessage');

	$router->get('create','UserController@create');
	// $router->get('admin','WeChatController@group');
	$router->post('regist','UserController@registDepartment');

});

// 供应商/货主
$router->group(['prefix'=>'supplier'],function($router) {
	$router->get('/','SupplierController@home');
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

    $router->get('shelf','AdminController@shelf');
});

$router->post('express','ExpressController@order');
