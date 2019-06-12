<?php

namespace App\Http\Controllers;

use EasyWeChat\Kernel\Messages\Message;
use illuminate\http\Request;
use Illuminate\Support\Facades\Redis;
use Log;


class AdminController extends Controller
{
    public function registDepartment(Request $request) {
        $name = $request->name;
        //创建微信小店的商品分组 返回分组id
        $group_id = app('wechat.official_account')->merchant->groupAdd($name);
        //同时创建企业微信部门
        $dept = app('wechat.work.user')->department->create(['id'=> $group_id, 'name'=> $name, 'parentid'=>5]);
        Log::info('registDepartment=> '.$name.' = ');
        Log::info($group_id);
        return Redis::hset('groups', $group_id, $name);
    }

    public function uploadProduct()    
    {
        $photo = app('wechat.official_account')->material->list('image',0,100);
        dd($photo);
    }

    public function update(array $message) {

        $post = ['name'=>$message['UserID']];

    public function create() {
        //调用这个创建商品接口的时候，需要提供两个参数：1，商品数量。  2，第一张图片的完整地址.通过001.jpg 去获取 002 003
       $amount = $request->amount;
       $group_id = $request->group_id;
      //还可以再提供第三个参数：每个商品需要几个图片，暂时默认6张
      //循环创建多个商品，图片按顺序递增获取
        // $folder = 'feng20190606'; //工作人员在接口地址加上文件夹参数，传入文件夹名称
        for ($i=0; $i < $amount ; $i++) { 

            $domain = 'https://fljy.oss-cn-hangzhou.aliyuncs.com/';
            $post =
            [
              "product_base"=>[
                "category_id"=>[
                  "536903132" // 固定的不用改 品类：翡翠
                ],
                "name"=>"", //商品名称
                //https://fljy.oss-cn-hangzhou.aliyuncs.com/002.jpg
                "main_img"=> 'https://hbimg-other.huabanimg.com/img/promotion/6ab082886258fc087068c8614e86799d1481b3ad687e3', //商品主图
                "img"=>[ // 商品图片列表
                  
                ],
                "detail"=>[
                  ["text"=>"",
                      "img"=> ""
                  ]
                ],
                "buy_limit"=>1
              ],

              "sku_list"=>[
                [
                  "sku_id"=>"",
                  "price"=>1,
                  "icon_url"=> 'https://hbimg-other.huabanimg.com/img/promotion/6ab082886258fc087068c8614e86799d1481b3ad687e3',
                  // 商户每次申请新产品上架 商户会在通知里留下自己的ID
                  "product_code"=>"512519882", // 商户ID就是企业微信部门id department_id
                  "ori_price"=>'',
                  "quantity"=>1
                ],
              ],
              "attrext"=>[
                "location"=>[
                  "country"=>"中国",
                  "province"=>"广东省",
                  "city"=>"广州市",
                  "address"=>"T.I.T创意园"
                ],
                "isPostFree"=>1,
                "isHasReceipt"=>0,
                "isUnderGuaranty"=>0,
                "isSupportReplace"=>0
              ],
            ];
            //创建产品获取id，并归入分组
            $product_id = app('wechat.official_account')->merchant->create($post)['product_id'];
            $list[] = ['product_id'=>$product_id,'mod_action'=>1];
            Redis::sadd($group_id.":status2",$product_id);
            Redis::hset( $product_id, json_encode($post) );

         }
         // 添加产品入分组
         $mod = ['group_id'=>$group_id,'product'=>$list];
         app('wechat.official_account')->merchant->groupMod($mod);

    }


    public function flushGroups()  {
        foreach (app('wechat.official_account')->merchant->groupAll() as $group) {
            $groups[$group['group_id']] = $group['group_name'];
        };
        Redis::hmset('groups',$groups);
    }

    public function flush($a='')
    {
        $list = app('wechat.official_account')->merchant->list();
        $group = [];
        foreach ($list as $product)  {
            if($product['status'] == 1){
                if(isset($group[$product['sku_list'][0]['product_code']])) {
                    $group[$product['sku_list'][0]['product_code']]['status1'][] = $product;
                } else {
                    $group[$product['sku_list'][0]['product_code']] = ['status1'=>[$product],'status2'=>[]];
                }
            } else {
                if(isset($group[$product['sku_list'][0]['product_code']])) {
                    $group[$product['sku_list'][0]['product_code']]['status2'][] = $product;
                } else {
                    $group[$product['sku_list'][0]['product_code']] = ['status1'=>[],'status2'=>[$product]];
                }
            }
        }
        foreach ($group as $key => $value) {
            Redis::hset('product',$key,json_encode($value));
        }
        return "OK";
    }

    public function order() {
        $merchant = app('wechat.official_account')->merchant;

        $list = $merchant->orderList();
        // 获取订单列表，并按照group分组注册入redis
        Redis::pipeline(function($pipe) use ($merchant,$list) {
            foreach ($list as $order) {
                $product = $merchant->get($order['product_id']);
                Redis::sadd($product['sku_list'][0]['product_code'].':order',$order['order_id']);
                Redis::hmset($order['order_id'].":detail",
                [
                    'order_id' => $order['order_id'],
                    'address'=>$order['receiver_province'].$order['receiver_city'].$order['receiver_address'].' '.$order['receiver_name'].' '.$order['receiver_mobile'],
                    'mobile'=>$order['receiver_mobile'],
                    'price'=>$order['order_total_price']/100,
                    'product_id'=>$order['product_id'],
                    'product_name'=>$order['product_name'],
                    'product_count'=>$order['product_count']
                ]);
                foreach ($order['products'] as $value) {
                    $products[$value['product_img']] = $value['product_price']/100;
                }
                Redis::hmset($order['order_id'].':products',$products);
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
