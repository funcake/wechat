<?php

namespace App\Http\Controllers;

use EasyWeChat\Kernel\Messages\Message;

use Illuminate\Support\Facades\Redis;


class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function create() {
        return 123;
    }

    public function update(array $message) {

        $post = ['name'=>$message['UserID']];

        return app('wechat.work.user')->user->update('Wuke',$post);
    }

    private function flushGroups()  {
        foreach (app('wechat.official_account')->merchant->groupAll() as $group) {
            $groups[$group['group_id']] = $group['group_name'];
        };
        Redis::hmset('groups',$groups);
    }

    public function order() {
        $merchant = app('wechat.official_account')->merchant;

        $list = $merchant->orderList();
        
        Redis::pipeline(function($pipe) use ($merchant,$list) {
            foreach ($list as $order) {
                $product = $merchant->get($order['products'][0]['product_id']);
                Redis::sadd($product['sku_list'][0]['product_code'],$order['order_id']);
                foreach ($order['products'] as $value) {
                    $products[$value['product_img']] = $value['product_price']/100;
                }
                Redis::hmset($order['order_id'],$products);
            }
        });
        $all = [];
        //获取部门id,名称列表,
        foreach (Redis::hgetall('groups') as $key => $group) {
            //根据部门id,获取订单列表
            $user = Redis::hgetall($group); 
            foreach (Redis::smembers($key) as $orderid) {
                $user['order'] = Redis::hgetall($orderid);
            }
            $user['group'] = $group;
            $users[$key] = $user;
        }
        dd($users);
        return $users;
    }

}
