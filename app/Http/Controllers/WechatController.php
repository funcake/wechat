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
					Redis::sadd($product['sku_list'][0]['product_code'],$order['order_id']);
					foreach ($order['products'] as $value) {
						$products[$value['product_img']] = $value['product_price'];
					}
					Redis::hmset($order['order_id'],$products);
					break;
					
				default:

					# code...
					break;
			}
		}
		return $server->serve();
	}



	public function change() {
	    $server = app('wechat.work.user')->server;
	    $message = $server->getMessage();
	    switch ($message['ChangeType']) {
	        case 'create_party': 
	            if ($message['ParentId'] == 11) {
	                $id = app('wechat.official_account')->merchant->groupAdd($message['Name']);
	                app('wechat.work.user')->department->create(['id'=>$id,'name'=>$message['Name'],'parentid'=>5]);
	                app('wechat.work.user')->department->delete($message['Id']);
	            }
	            break;
	        default:
	            break;
	    }
	    return  $server->serve();
	}
}