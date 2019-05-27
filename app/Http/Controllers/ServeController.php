<?php

namespace App\Http\Controllers;

use Log;

use EasyWeChat\Kernel\AccessToken;

use illuminate\http\Request;

use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Redis;
use App\Jobs\RegistDepartment;
use App\Jobs\RegistUser;

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
	    $message = $server->getMessage();
		if(isset($message['ChangeType'])) {
		    switch ($message['ChangeType']) {
		    	// 注册主管
		        case 'update_user':
		        	if (isset($message['IsLeaderInDept'])) {
		        		if( ($key = array_search(1, explode(',',	$message['IsLeaderInDept'])) ) !== false ) {
			        		$user = app('wechat.work')->user->get($message['UserID']);
			        		Redis::hmset($user['department'][0],
			        		    [
			        		        'avatar'=>$user['avatar'],
			        		        'userid'=>$user['userid'],
			        		        'name'=>$user['name'],
			        		        'mobile'=>$user['mobile'],
			        		        'address'=>$user['address'],
			        		        'finance'=>$user['extattr']['attrs'][0]['value'],
			        		    ]
			        		);
			        		return app('wechat.work')->messenger->message("新至商品")->toTag(1)->send();
			        	}
		        	}
		        	break;
		        // 注册部门
		      //   case 'create_party': 
			     //    if ($message['ParentId'] == 8) {
				    // 	$this->dispatch(new RegistDepartment($message));
				    // }
		      //       break;

		        default:
		            break;
		    }
		}
		return $server->serve();
	}


}