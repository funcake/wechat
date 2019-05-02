<?php

namespace App\Http\Controllers;

use Log;

use EasyWeChat\Kernel\AccessToken;

use illuminate\http\Request;

use Illuminate\Support\Arr;
use Overtrue\Socialite\User as SocialiteUser;

use Illuminate\Support\Facades\Redis;


class WechatController extends Controller
{
	public function serve() {
		$server = app('wechat.official_account')->server;
		$message = $server->getMessage();
		$merchant = app('wechat.official_account')->merchant;
		switch ($message['Event']) {
			case 'merchant_order':
				$order = $merchant->getOrder($message['OrderId']);
				$product = $merchant->get($message['ProductId']);
				Redis::sadd($product['sku_list'][0]['product_code'],$message['OrderId']);
				Redis::hmset('OrderId',$product['product_id'],$product['product_base']['main_img']);
				break;
				
			default:

				# code...
				break;
		}
		return $server->serve();
	}

	public function order()
	{
		# code...
	}
}