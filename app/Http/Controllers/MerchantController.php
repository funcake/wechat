<?php

namespace App\Http\Controllers;

use Log;

use EasyWeChat\Kernel\AccessToken;

use illuminate\http\Request;

use Illuminate\Support\Arr;
use Overtrue\Socialite\User as SocialiteUser;

use Illuminate\Support\Facades\Redis;


class MerchantController extends Controller
{
	public function __construct() {
      // $this->middleware('work');
      $this->middleware('oauth:snsapi_userinfo');

	}

 
}
