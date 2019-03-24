<?php

namespace App\Http\Controllers;

use Log;

class WeChatController extends Controller
{

    public function __construct() {
        $this->middleware('oauth');
    }
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        // Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $app = app('wechat.official_account');

       $list = $app->user->select($app->user->list()['data']['openid'])['user_info_list'];

        return view('hello',compact('list'));   
    }

    public function order() {
        $app = app('wechat.official_account');

        
    }


}
