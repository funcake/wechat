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
        return app('wechat.official_account')->merchant->create();
    }

    public function delete() {
        return app('wechat.official_account')->merchant->delete();
    }

    public function group() {
        $group =  app('wechat.official_account')->merchant->group(530505132);
        return $group;
    }


}
