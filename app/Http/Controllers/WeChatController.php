<?php

namespace App\Http\Controllers;

use Log;

use EasyWeChat\Kernel\AccessToken;

use illuminate\http\Request;

class WeChatController extends Controller
{

    public function __construct() {
        // $this->middleware('oauth:snsapi_userinfo');
    }
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {

        $app = app('wechat.official_account');

       $list = $app->merchant->list()['products_info'];
// return $list[0];
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
