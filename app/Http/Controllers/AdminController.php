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
        //创建微信小店的商品分组 返回分组id 整型
        $group_id = app('wechat.official_account')->merchant->groupAdd($name);
        //同时创建企业微信部门
        $dept = app('wechat.work.user')->department->create(['id'=> $group_id, 'name'=> $name, 'parentid'=>5]);
        Log::info('registDepartment=> '.$name.' = ');
        Log::info($group_id);
        return Redis::hset('groups', $group_id, $name);
    }

    public function update(array $message) {

        $post = ['name'=>$message['UserID']];
    }

    public function uploadProduct()
    {
        $photo = app('wechat.official_account')->material->list('image',0,100);
        dd($photo);
    }

    //http://www.fljy.shop/admin/getProperty
    public function getProperty(){
        $property =  app('wechat.official_account')->merchant->getProperty();
        print_r($property);
    }

    /**
     * 上传图片到微信小店，模仿的上传素材接口
     * TODO 总是返回 -1 ,不知道什么意思 {"errcode":-1,"errmsg":"system error"}
     */
    public function uploadImage(){
        $property =  app('wechat.official_account')->merchant->uploadImage('test.png', '/var/www/html/website/wechat-shop/releases/20190615174153/public/test.png');
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
        $amount   = $request->input('amount', 1);
        $group_id = $request->input('group_id', 530528963); // 测试部门：530528963
        //$domain = 'https://fljy.oss-cn-hangzhou.aliyuncs.com/';
        //die('=='.$group_id);
        $err = []; //第多少个商品创建失败
        for ($i=0; $i < $amount ; $i++) {
            $post =
            [
              "product_base"=>[
                "category_id"=>[
                  "536903132" // 微信小店的种类：翡翠，总之不要管这个
                ],
                "name"=> "请输入商品名称", //商品名称

                //https://fljy.oss-cn-hangzhou.aliyuncs.com/002.jpg
                //"main_img"=> 'http://mmbiz.qpic.cn/mmbiz/4whpV1VZl2iccsvYbHvnphkyGtnvjD3ulEKogfsiaua49pvLfUS8Ym0GSYjViaLic0FD3vN0V8PILcibEGb2fPfEOmw/0', //商品主图
                //"main_img"=> 'http://www.fljy.shop/test.jpeg',
                "main_img"=> 'https://wechat-shop-1258718274.cos.ap-chengdu.myqcloud.com/test.jpeg',
                "img"=>[ // 商品图片列表
                    'http://mmbiz.qpic.cn/mmbiz/4whpV1VZl2iccsvYbHvnphkyGtnvjD3ulEKogfsiaua49pvLfUS8Ym0GSYjViaLic0FD3vN0V8PILcibEGb2fPfEOmw/0'
                    //'http://mmbiz.qpic.cn/mmbiz/4whpV1VZl2iccsvYbHvnphkyGtnvjD3ulEKogfsiaua49pvLfUS8Ym0GSYjViaLic0FD3vN0V8PILcibEGb2fPfEOmw/0'
                ],
                "detail"=>[
        			[
                        "text"=>"第一段详情描述"
                    ],
        			[
                        "img"=>"http://mmbiz.qpic.cn/mmbiz/4whpV1VZl2iccsvYbHvnphkyGtnvjD3ulEKogfsiaua49pvLfUS8Ym0GSYjViaLic0FD3vN0V8PILcibEGb2fPfEOmw/0"
                    ],
        			[
                        "text"=>"第二段详情描述"
                    ]
                ],
                "buy_limit"=>1
              ],

              "sku_list"=>[ //商品型号
                [
                  "sku_id"=>"",
                  "price"=>1, // 1分 微信价必须比原价ori_price小，不然添加失败
                  "icon_url"=> 'http://mmbiz.qpic.cn/mmbiz/4whpV1VZl2iccsvYbHvnphkyGtnvjD3ulEKogfsiaua49pvLfUS8Ym0GSYjViaLic0FD3vN0V8PILcibEGb2fPfEOmw/0',
                  // 部门人员每次申请新产品上架 会在通知里留下自己的部门ID
                  "product_code"=> $group_id."", //字符串 这个是产品分组id也就是部门id, department_id
                  "ori_price"=>100, //100分
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
            $product_arr = app('wechat.official_account')->merchant->create($post);
            if($product_arr['errcode'] === 0){ //创建成功
                $product_id = $product_arr['product_id']; //商品号 字符串
                Log::info('product_id=> '.$product_id.' = ');
                $list[] = ['product_id'=>$product_id, 'mod_action'=>1]; //1增加 0删除
                // 分组id:状态未上架 => 产品id
                Redis::sadd($group_id.":status2",$product_id); // 2:表示未上架
                // 产品id => json内容
                Redis::hset($product_id, json_encode($post) );
            } else {
                $err[] = $i + 1;
            }
         }
         if(!empty($list)){
             // 添加产品入分组
             $mod = ['group_id'=>$group_id,'product'=>$list]; // group_id 整型
             app('wechat.official_account')->merchant->groupMod($mod);
         }

         $msg = '';
         if(!empty($err)){
             $msg = '第 ' . implode(',',$err) . ' 个商品创建失败';
         } else {
             $msg = '商品创建成功';
         }

         return response($msg);
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
