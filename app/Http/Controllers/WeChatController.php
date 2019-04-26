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
        // if(!session('wechat.work.default',[])) {
        //     session(['wechat.work.default' =>['name'=>'吴可','alias'=>512519882]]);
        // }
        $this->middleware('work:snsapi_userinfo'); 
        // $this->middleware('oauth:snsapi_userinfo'); 
    }

    public function home() {
       $property =  app('wechat.official_account')->merchant->getProperty();

       $material = $property[array_search('种地分类', array_column($property, 'name'))];
       $usage = $property[array_search('适用场景', array_column($property, 'name'))];
       $style = $property[array_search('款式', array_column($property, 'name'))];

        return view('hello',compact('material','usage','style'));
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

    public function group() {
        $group =  app('wechat.official_account')->merchant->group(session("wechat.work.default")['alias']);
        return $group;
    }

}
