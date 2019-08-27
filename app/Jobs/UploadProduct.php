<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Redis;
use Log;


class UploadProduct extends Job
{
    protected $amount;
    protected $group_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($amount,$group_id)
    {
        $this->amount = $amount;
        $this->group_id = $group_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $name =
        ['【八方来财】 54.5/20.4/14',
'【八方来财】 4420.2/13.6',
'【八方来财】 45.4/23.2/12.3',
'【八方来财】 40.1/18/13.5',
'【八方来财】 43.9/21.112.7',
'【八方来财】 40.2/17.2/9.3',
'【八方来财】 28/17.8/9.8',
'【吉祥如意】 44.3/21.8/6.7',
'【吉祥如意】 35.4/20.2/5.1',
'【连中三元】 36.8/13.6/6.9',
'【兰花芬芳】 48.3/20.1/5.9',
'【福寿绵长】 43.6/17.8/4.7',
'【连中三元】 49.6/17.4/10',
'【多子多孙】 47.3/17.1/8',
'【福禄万年】 41.1/23.7/6.6',
'【千手观音•鼠】54.5/40.1/5.5mm',
'【虚空藏菩萨•牛虎】52.8/44.6/5.0mm',
'【文殊菩萨•兔】52.2/43.7/5.7mm',
'【普贤菩萨•龙蛇】51.3/43.9/6.3mm',
'【大势至菩萨•马】53.5/45.8/7.1mm',
'【大日如来•羊猴】50.2/43/6.5mm',
'【不动尊菩萨•鸡】51/42.6/4.6mm',
'【阿弥陀佛•狗猪】48/40/6.9mm',];

      $price = 
        [1500,
2250,
2500,
1880,
3130,
1630,
860,
3500,
4380,
1500,
4380,
1250,
3130,
1250,
3500,
2300,
2800,
2000,
1000,
2500,
2800,
2800,
2500,
];
        // return app('wechat.official_account')->merchant->uploadImage(,$i.'.jpg');
        $err = []; //第多少个商品创建失败
        for ($i=0; $i < $this->amount ; $i++) {
            $post =
            [
              "product_base"=>[
                "category_id"=>[
                  "536903132" // 微信小店的种类：翡翠，总之不要管这个
                ],
                "name"=> $name[$i], //商品名称

                "main_img"=> app('wechat.official_account')->merchant->uploadImage(($i*6+1).'.jpg'),
                "img"=>[ // 商品图片列表
                    app('wechat.official_account')->merchant->uploadImage(($i*6+2).'.jpg'),
                    app('wechat.official_account')->merchant->uploadImage(($i*6+3).'.jpg'),
                    app('wechat.official_account')->merchant->uploadImage(($i*6+4).'.jpg'),
                    app('wechat.official_account')->merchant->uploadImage(($i*6+5).'.jpg'),
                    app('wechat.official_account')->merchant->uploadImage(($i*6+6).'.jpg'),
                ],
                "detail"=>[
                    [
                        "img"=>"http://mmbiz.qpic.cn/mmbiz_jpg/zjU4wTBaB7d4scsYfueOS7icPDVwMtYdiadEN4biaQhiaehIzsGOHay1QpUTPJ6R6buVkxHcB1UvQGSsfL80Fjs8sQ/0?wx_fmt=jpeg"
                    ],
                   /* [
                        "img"=>app('wechat.official_account')->merchant->uploadImage(($i+1).'z.jpg'),
                    ],*/
                    [
                        "img"=>"http://mmbiz.qpic.cn/mmbiz_jpg/zjU4wTBaB7djyj1nkyDJXzrno3g92gKicwMcQWGp7eu3ftmBRSNJQl0CAGt5UFpwr4jkhWacEyKKcVRvxicbjQQg/0?wx_fmt=jpeg"
                    ]
                ],
                "buy_limit"=>1,
                'property' => [
                    [
                        'id' => 1075743464,
                        'vid'  => 1079783184,
                    ]
                ]
              ],

              "sku_list"=>[ //商品型号
                [
                  "sku_id"=>"",
                  "price"=>100*$price[$i], // 1分 微信价必须比原价ori_price小，不然添加失败
                  "icon_url"=> app('wechat.official_account')->merchant->uploadImage(($i+1).'.jpg'),
                  // 部门人员每次申请新产品上架 会在通知里留下自己的部门ID
                  "product_code"=> $this->group_id."", //字符串 这个是产品分组id也就是部门id, department_id
                  "ori_price"=>100*$price[$i]*1.5, //100分
                  "quantity"=>1
                ],
              ],
              "attrext"=>[
                "location"=>[
                  "country"=>"中国",
                  "province"=>"广东省",
                  "city"=>"肇庆市四会市",
                  "address"=>"中国玉器博览城"
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
                $list[] = ['product_id'=>$product_id, 'mod_action'=>1]; //1增加 
                // 分组id:状态未上架 => 产品id0删除
                Redis::sadd($this->group_id.":status2",$product_id); // 2:表示未上架
                // 产品id => json内容
                $post['product_id'] = $product_id;
                Redis::set($product_id, json_encode($post) );
            } else {
                $err[] = $i + 1;
            }
         }
         if(!empty($list)){
             // 添加产品入分组
            $mod = ['group_id' => $this->group_id, 'product'=>$list];
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
}
