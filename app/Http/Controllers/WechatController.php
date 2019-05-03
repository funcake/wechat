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
		if(isset($message['Event'])) {
			$merchant = app('wechat.official_account')->merchant;
			switch ($message['Event']) {
				case 'merchant_order':
					$order = $merchant->getOrder($message['OrderId']);
					$product = $merchant->get($order['products'][0]['product_id']);
					Redis::sadd($product['sku_list'][0]['product_code'],$message['OrderId']);
					foreach ($order['products'] as $value) {
						$products[$value['product_img']] = $value['product_price'];
					}
					Redis::hmset($message['OrderId'],$products);
					break;
					
				default:

					# code...
					break;
			}
		}
		return $server->serve();
	}

	public function order()
	{
		# code...
	}
}