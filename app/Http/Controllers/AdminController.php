<?php

namespace App\Http\Controllers;

use EasyWeChat\Kernel\Messages\Message;
use illuminate\http\Request;
use Illuminate\Support\Facades\Redis;
use App\Jobs\UploadProduct;
use Log;


class AdminController extends Controller
{
    public function registDepartment(Request $request) {
        $name = $request->name;
        //创建微信小店的商品分组 返回分组id 整型
        $group_id = app('wechat.official_account')->merchant->groupAdd($name);
        //同时创建企业微信部门
        $dept = app('wechat.work.user')->department->create(['id'=> $group_id, 'name'=> $name, 'parentid'=>5]);

        Log::info($group_id);
        return Redis::hset('groups', $group_id, $name);
    }

    public function update(array $message) {

        $post = ['name'=>$message['UserID']];
    }

    //http://www.fljy.shop/admin/getProperty
    public function getProperty(){
        $property =  app('wechat.official_account')->merchant->getProperty();
        print_r($property);
    }

    /**
     * 创建商品接口，可以一次性创建多个商品：
     * 1. amount   商品数量
     * 2. group_id 商品分组id（和部门id一样的）
     * 3. 图片地址暂时写死
     * TODO 图片地址只能是上传到微信小店的地址或者微信素材库里面的,不支持外部地址
     */
    public function createProduct(Request $request) {
        // $amount   = $request->input('amount', 1);
        // $group_id = $request->input('group_id', 530528963); // 测试部门：530528963
        $amount  =  '';
        $group_id = '';
        $this->dispatch(new UploadProduct($amount,$group_id));
        return 'ok';
       
    }


    public function flushGroups()  {
        foreach (app('wechat.official_account')->merchant->groupAll() as $group) {
            Redis::hset($group['group_id'].':detail','name',$group['group_name']);
        };
        return 'ok';
    }

    public function flush($a='')
    {
        $products = app('wechat.official_account')->merchant->list(0);
        Redis::pipeline(function ($pipe) use ($products) {
            foreach ($products as $product)  {
                $pipe->set($product['product_id'],json_encode($product));
                $pipe->sadd($product['sku_list'][0]['product_code'].':status'.$product['status'],$product['product_id']);
            }
        });
        return 'OK';
    }

    public function order() {
        $merchant = app('wechat.official_account')->merchant;

        $list = $merchant->orderList();
        // 获取订单列表，并按照group分组注册入redis
        Redis::pipeline(function($pipe) use ($merchant,$list) {
            foreach ($list as $order) {
                Redis::sadd(Redis::get($order['product_id']).':order',$order['order_id']);
                Redis::hmset($order['order_id'].":detail",
                [
                    'order_id' => $order['order_id'],
                    'address'=>$order['receiver_province'].$order['receiver_city'].$order['receiver_address'].' '.$order['receiver_name'].' '.$order['receiver_mobile'],
                    'mobile'=>$order['receiver_mobile'],
                    'price'=>$order['order_total_price']/100,
                    'product_id'=>$order['product_id'],
                    'product_name'=>$order['product_name'],
                    'product_count'=>$order['product_count'],
                    'receiver_name' => $order['receiver_name'],
                ]);
                foreach ($order['products'] as $value) {
                    $products[$value['product_img']] = $value['product_price']/100;
                }
                Redis::hmset($order['order_id'],$products);
            }
        });
        $users = [];
        $groupOrders = [];
            //获取部门id,名称列表,
        foreach (Redis::hgetall('groups') as $group => $name) {
            //根据部门id,获取订单列表
            $user = Redis::hgetall($group);
            foreach (Redis::smembers($group.':order') as $order_id) {
                $orders = Redis::hgetall($order_id.":detail");
                $orders['products'] = Redis::hgetall($order_id.":products");
                $groupOrders[$group]['orders'][] =  $orders;
                $groupOrders[$group]['total'] +=  Redis::hgetall($order_id.":detail")['price'];
            }
            $user['name'] = $name;
            $users[$group] = $user;
        }
        return view('admin',compact('groupOrders','users'));
    }

    public function setDelivery()
    {
        // Redis::hset($_POST['order_id'],);
        app('wechat.official_account')->merchant->setDelivery();
    }

}
