<?php

namespace App\Http\Controllers;

use Log;

use EasyWeChat\Kernel\AccessToken;

use illuminate\http\Request;

use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Redis;
use App\Jobs\RegistDepartment;

class ServeController extends Controller
{

	public function wechat() {
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



	public function work() {
	    $server = app('wechat.work.user')->server;
	    $server->serve()->send();
	    $message = $server->getMessage();
		if(isset($message['ChangeType'])) {
		    switch ($message['ChangeType']) {
		        case 'create_party': 
			        if ($message['ParentId'] == 11) {
				    	$message = $this->message;
				    	$id = app('wechat.official_account')->merchant->groupAdd($message['Name']);
				    	$this->id = $id;
				    	app('wechat.work.user')->department->create(['id'=>$id,'name'=>$message['Name'],'parentid'=>5]);
				    	app('wechat.work.user')->department->delete($message['Id']);
				    	Redis::hset('groups',$this->id,$message['Name']]);
				    }
		            break;
		        case 'update_user':
		        	if (isset($message['IsLeaderInDept']) && $message['IsLeaderInDept'] == 1) {
		        		$user = app('wechat.work.user')->user->get($message['UserID']);
			        	Redis::hmset($user['Department'][0],
			        	    [
			        	        'avatar'=>$user['avatar'],
			        	        'userid'=>$user['userid'],
			        	        'name'=$user['name'],
			        	        'mobile'=>$user['mobile'],
			        	        'address'=>$user['address'],
			        	        'finance'=>$user['extattr']['attrs'][0]['value'],
			        	    ]
			        	);
		        	}
		        	break;
		        default:
		            break;
		    }
		}
	}

}