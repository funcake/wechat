<?php

namespace App\Http\Controllers;

use Log;

use EasyWeChat\Kernel\AccessToken;

use illuminate\http\Request;

use Illuminate\Support\Arr;
use Overtrue\Socialite\User as SocialiteUser;

use Illuminate\Support\Facades\Redis;


class ProductController extends Controller
{
	public function __construct() {
		// session(['wechat.work.default'=>app('wechat.work')->user->get('WuKe')]);
      $this->middleware('work');
      // $this->middleware('oauth:snsapi_userinfo');

	}

  private function IsRegist() {
    if (session('wechat.work.default')['department'][0] == 530528964) {
      $id=session('wechat.work.default')['userid'];
      $user = app('wechat.work')->user->get($id);
      session(['wechat.work.default'=>$user]);
      return $id;
    }
  }

	public function home(Request $request) {
    $id = $this->IsRegist();
		$user = session('wechat.work.default'); 
    if($user['department'][0] == 530528964) {
      return view('regist',compact('id'));
    }

		$property = [];
		if(Redis::exists('property')) {
			$property = json_decode(Redis::get('property') ,true);
		} else {
			$property =  app('wechat.official_account')->merchant->getProperty();
			Redis::set('property',json_encode($property));
		}
    // dd($property);
		$material = $property[array_search('种地分类', array_column($property, 'name'))];
		$style = $property[array_search('样式', array_column($property, 'name'))];
		$gold = $property[array_search('金饰', array_column($property, 'name'))];

         // $order = Redis::hgetall(Redis::hget('groups',
    $user['department'][0]));
		$order = [];

		$group = ['status1'=>[],'status2'=>[]];
		if($status1= Redis::smembers(session('wechat.work.default')['department'][0].':status1')) {
			foreach ( Redis::mget($status1)  as $value) {
				$group['status1'][] = json_decode($value,true);
			}
		}
		if($status2= Redis::smembers(session('wechat.work.default')['department'][0].':status2')) {
			foreach (Redis::mget($status2) as $value) {
				$group['status2'][] = json_decode($value, true);
			}
		}

		$group = json_encode($group);


		return view('hello',compact('material','style','gold','user','order','group'));
	}

  public function delete(Request $request) {
  	app('wechat.official_account')->merchant->delete();
  	Redis::del($request->product_id);
  	return Redis::srem($request->group.':status1',$request->product_id);
  }

// @return json [status1=>[],status2=>[]]
  public function group() {
  	$group = ['status1'=>[],'status2'=>[]];
  	if($status1= Redis::smembers(session('wechat.work.default')['department'][0].':status1')) {
  		foreach ( Redis::mget($status1)  as $value) {
  			$group['status1'][] = json_decode($value,true);
  		}
  	}
  	if($status2= Redis::smembers(session('wechat.work.default')['department'][0].':status2')) {
  		foreach (Redis::mget($status2) as $value) {
  			$group['status2'][] = json_decode($value, true);
  		}
  	}
  	return $group;
  }
  
}
