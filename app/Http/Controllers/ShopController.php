<?php

namespace App\Http\Controllers;

use Log;

use EasyWeChat\Kernel\AccessToken;

use illuminate\http\Request;

use Illuminate\Support\Arr;
use Overtrue\Socialite\User as SocialiteUser;

use Illuminate\Support\Facades\Redis;

/**
 * 
 */
class ShopController extends Controller
{
  
  function __construct()  
  {
          $this->middleware('oauth:snsapi_userinfo');
  }

  public function home() {
    return view('merchant.layout');
  }
}