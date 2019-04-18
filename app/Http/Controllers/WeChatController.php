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

        $this->middleware('work:snsapi_userinfo'); 
        // $this->middleware('oauth:snsapi_userinfo'); 
    }

    public function home() {
     $user = session('wechat.work.default');
        
     $name =  $user['name'];

     $app = app('wechat.official_account');

     $list = $app->merchant->list()['products_info'];
        return view('hello',compact('list','name'));
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
        return view('hello',compact('list'));
    }

    public function order() {
        $app = app('wechat.official_account');
    }

    public function update() {
         $app = app('wechat.official_account');

        return $app->merchant->update($_POST );

    }




}
