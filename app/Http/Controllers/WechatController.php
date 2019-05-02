<?php

namespace App\Http\Controllers;

use Log;

use EasyWeChat\Kernel\AccessToken;

use illuminate\http\Request;

use Illuminate\Support\Arr;
use Overtrue\Socialite\User as SocialiteUser;

use Illuminate\Support\Facades\Redis;


class WechatController extends Controller
{
	public function serve() {
		$server = app('wechat.official_account')->server;

		return $server->serve();
	}
}