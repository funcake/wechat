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

        // $this->middleware('oauth:snsapi_userinfo'); 
        $this->middleware('work:snsapi_userinfo'); 
    }

    public function home() {
      $user = session('wechat.work.default');
      return $user->getName();
      // dd(session('wechat.oauth_user.default'));
      // dd(session('wechat.work.default'));
        return view('hello');
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

        $app = app('wechat.work');

       // $list = $app->merchant->list()['products_info'];
 /*       $list =  
            [
                 [
                    'product_base' => 
                    [
                      'name' => '123',
                      'category_id' => 
                      [
                        0 => 536903132,
                    ],
                    'img' => 
                    [
                        0 => 'https://mmbiz.qpic.cn/mmbiz_jpg/zjU4wTBaB7ciajzF7DUr2MgUskxa7SXCxX9CdNkcALX8gOrvpey8MJojVanbO5NTnFIw7yScdNUaib6TE0cCRiccw/0?wx_fmt=jpeg',
                        1 => 'https://mmbiz.qpic.cn/mmbiz_jpg/zjU4wTBaB7ciajzF7DUr2MgUskxa7SXCxdOzhJvvUwmW040RRRnQ11ia9KLrfDZjgPzswTgwXfTw89W4ic9oHs0Eg/0?wx_fmt=jpeg',
                        2 => 'https://mmbiz.qpic.cn/mmbiz_jpg/zjU4wTBaB7ciajzF7DUr2MgUskxa7SXCxGnJYoRN1e4knKJCiapaaJFWKdaAgaRHTgyVsk8LbXyiaEc4lOaNAPL4g/0?wx_fmt=jpeg',
                        3 => 'https://mmbiz.qpic.cn/mmbiz_jpg/zjU4wTBaB7ciajzF7DUr2MgUskxa7SXCxpQMTQHM3SQ84wNbsKPFxwvPmYfFtibOD48RYy0rloSmeg1BG6wAFcpg/0?wx_fmt=jpeg',
                        4 => 'https://mmbiz.qpic.cn/mmbiz_jpg/zjU4wTBaB7ciajzF7DUr2MgUskxa7SXCxQ5PYA6pvyIomO425o2T1z5eUibMj3380vngNrNvuc3CWk4yF1niaap5Q/0?wx_fmt=jpeg',
                        5 => 'https://mmbiz.qpic.cn/mmbiz_jpg/zjU4wTBaB7ciajzF7DUr2MgUskxa7SXCx5Ckp7emUefibo2XCJfyDCBysDlJ6S54QfUa4EwzcPuQPQRQrK8JJJGg/0?wx_fmt=jpeg',
                        6 => 'https://mmbiz.qpic.cn/mmbiz_jpg/zjU4wTBaB7ciajzF7DUr2MgUskxa7SXCxuGeibsyJt3gTcuPjCFwqGibjOg9qFBpPibrtsgL3aA8JI3tStdtf2nYCw/0?wx_fmt=jpeg',
                        7 => 'https://mmbiz.qpic.cn/mmbiz_jpg/zjU4wTBaB7ciajzF7DUr2MgUskxa7SXCxRocqVT8SrI533kyUwAGsFTumbqeOgQQgNGnY7V1pmuJe4aTljiaicoJA/0?wx_fmt=jpeg',
                    ],
                    'detail' => 
                    [
                    ],
                    'property' => 
                    [
                    ],
                    'sku_info' => 
                    [
                    ],
                    'buy_limit' => 0,
                    'main_img' => 'https://mmbiz.qpic.cn/mmbiz_jpg/zjU4wTBaB7ciajzF7DUr2MgUskxa7SXCxX9CdNkcALX8gOrvpey8MJojVanbO5NTnFIw7yScdNUaib6TE0cCRiccw/0?wx_fmt=jpeg',
                    'detail_html' => '',
                ],
                'sku_list' => 
                [
                  0 => 
                  [
                    'sku_id' => '',
                    'price' => 12300,
                    'icon_url' => '',
                    'quantity' => 12,
                    'product_code' => '',
                    'ori_price' => 0,
                ],
            ],
            'delivery_info' => 
            [
              'delivery_type' => 0,
              'template_id' => 0,
              'weight' => 0,
              'volume' => 0,
              'express' => 
              [
              ],
                ],
                'product_id' => 'p13XCwZzrIz4Ib6qlXnE0OpaPcRc',
                'status' => 2,
                'attrext' => 
                [
                    'isPostFree' => 0,
                    'isHasReceipt' => 0,
                    'isUnderGuaranty' => 0,
                    'isSupportReplace' => 0,
                    'location' => 
                    [
                      'country' => '中国',
                      'province' => '上海',
                      'city' => '卢湾',
                      'address' => '',
                  ],
                  ],
                  ],
        ];*/
// dd($list);
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
