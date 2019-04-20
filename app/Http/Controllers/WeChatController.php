<?php

namespace App\Http\Controllers;

use Log;

use EasyWeChat\Kernel\AccessToken;

use illuminate\http\Request;

use Illuminate\Support\Arr;
use Overtrue\Socialite\User as SocialiteUser;
// use App\Wechat;


class WeChatController extends Controller
{

    public function __construct() {

        // $this->middleware('work:snsapi_userinfo'); 
        // $this->middleware('oauth:snsapi_userinfo'); 
    }

    public function home() {
       $property =  app('wechat.official_account')->merchant->getProperty();

       $material = $property[array_search('种地分类', array_column($property, 'name'))];
       $usage = $property[array_search('适用场景', array_column($property, 'name'))];
       $style = $property[array_search('款式', array_column($property, 'name'))];
        return view('hello',compact('material','usage','style'));
    }

    public function user() {
      return 123;
    }
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve(int $status = 0)
    {   

        $app = app('wechat.official_account');

       $list = $app->merchant->list()['products_info'];
return $list;
        return view('hello',compact('list','material'));
    }

    public function order() {
        $app = app('wechat.official_account');
    }

    public function update() {
         $app = app('wechat.official_account');

        return $app->merchant->update($_POST );

    }

    public function create() {
        return app('wechat.official_account')->merchant->create();
    }

    public function test() {
        return  app('wechat.official_account')->merchant->group(512519882);
        
    }

}
