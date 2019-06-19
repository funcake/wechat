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
        // $this->middleware('work');
        // $this->middleware('oauth:snsapi_userinfo');
    }

    public function home() {
       $property =  app('wechat.official_account')->merchant->getProperty();
       $material = $property[array_search('种地分类', array_column($property, 'name'))];
       $usage = $property[array_search('适用场景', array_column($property, 'name'))];
       $style = $property[array_search('款式', array_column($property, 'name'))];

       $user = session('wechat.work.default');
       // $order = Redis::hgetall(Redis::hget('groups',$user['department'][0]));
       $order = [];

        return view('hello',compact('material','usage','style','user','order'));
    }

    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve(int $status = 0)
    {
        $app = app('wechat.official_account');

        return $app->merchant->list($status);
        return view('hello',compact('list','material'));
    }



    public function update() {
        $app = app('wechat.official_account');

        return $app->merchant->update();

    }

    public function create() {
        return app('wechat.official_account')->merchant->uploadImage('DSC_0095.jpg');
    }

    public function delete() {
        return app('wechat.official_account')->merchant->delete();
    }

    public function group() {
        // $group =  app('wechat.official_account')->merchant->group(session('wechat.work.default')['department'][0]);
        $group =  app('wechat.official_account')->merchant->group(530528963);
        // $group =  json_decode(Redis::get('512519882'),true);
        // $group = json_decode(Redis::hget('530505229','products'),true);
        return $group;
    }

    public function flushGroup()
    {
        return  Redis::set(session('wechat.work.default')['department'][0]);
    }


}
