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
        ['【代代有福】34.1/20.2/7.8mm   ',
'【连生贵子】35.4/16.2/14.0mm ',
'【福寿绵长】44.5/14.3/10mm  ',
'【贵子开花】27.5/17.9/9.1mm ',
'【平平安安】49.4/17.4/10.4mm ',
'【福寿绵长】34.2/16.6/7.7mm ',
'【如意吉祥】27.1/18.2/3.8mm ',
'【红红火火】31.4/10.9/6.5mm ',
'【红红火火】30.6/8.6/6.9mm ',
'【平安静心】21.6/4.9mm ',
'【平安静心】21.6/4.9mm ',
'【平安无事】36.2/13.66.4mm ',
'【平安无事】38.3/20.5/6.2mm ',
'【招财佛手】21.9/8.9/6.8mm ',
'【平安扣】12.3/4.0mm ',
'【禅•悟道】48/16.7/7.2mm ',
'【风调雨顺】30.8/17.8/8.8mm ',
'【红红火火】39.1/16/8.1mm ',
'【心平气和】41.1/13.9/8.7mm ',
'【八方来财】34.6/18.5/9.8mm ',
'【18K钻高冰吊坠】裸石21.1/10.9/6.0mm ',
'【18K钻高冰葫芦】裸石21.2/14.4/5.5mm ',
'【平安意境蓝花】18.8/19/6.4mm ',
'【平安意境蓝花】31.4/12.6/8.1mm ',
'【平安意境蓝花】23.8/6.7/4.0mm ',
'【避邪】24/12.1/6.8mm ',
'【避邪】24.2/12.1/6.8mm ',
'【福禄满满】28.3/16.2/9.2mm ',
'【冰漂蓝花扣】25.3/6.5mm ',
'【冰漂蓝花扣】23.2/4.6mm ',
'【冰漂蓝花扣】26.5/6.3mm ',
'【平安无事】29.4/15.2/3.8mm ',
'【紫气东来】37.614.5/6.1mm ',
'【冰蓝花扣】29.3/6.4mm ',
'【相印•18K戒】直径6.8mm ',
'【紫心•18K戒】13.9/12.4/5.6mm ',
'【紫蛋•18K戒】12.8/11.8/6.9mm ',
'【相拥•18K翡翠】7.1/5.8/2.5mm ',
'【招财•18K翡翠】13.9/9.8/5mm ',
'【圆满•18K紫翠】直径13.9mm ',
'【冰紫蛋面•I8K钻】15.2/11.3/5.5mm ',
'【冰紫蛋面•18k钻】13.7/13.4/6.8mm ',
'【紫蛋面•18K钻】20/15.5/9.5mm ',
'【冰紫蛋•18k钻】16.9/13.4/6.8mm ',
'【招财貔貅】32.3/15/12.8mm ',
'【招财貔貅】34.114.7/11.8mm ',
'【招财貔貅】37.5/18.5/16.2mm ',
'【招财貔貅】29.6/13.5/13.3mm ',
'【招财貔貅】34.5/13.5/19.7mm ',
'【招财貔貅】40.9/13.1/24mm ',
'【招财貔貅】37.1/14.4/26.8mm ',
'【富贵小猪】24.7/14.1/13.3mm ',
'【招财貔貅】45.5/23.6/12.5mm ',
'【招财貔貅】38.7/14.512.3mm ',
'【富贵小猪】30.8/19.2/14.3mm ',
'【招财貔貅】36.8/14.4/17.8mm ',
'【招财貔貅】42.8/19.4/13.3mm ',
'【富贵紫猪】20.6/18/14.1mm ',
'【富贵小猪】24.1/18.2/13.2mm ',
'【呱呱叫】26.2/18.7/16.6mm ',
'【富贵小猪】26.8/17.8/14.3mm ',
'【富贵小猪】26.9/20/12.6mm ',
'【招财貔貅】36.2/14.3/16.1mm ',
'【富贵小猪】24.2/13.9/15.8mm ',
'【运财财神】30/17.4/14.4mm ',
'【运财财神】34/16.6/12.9mm ',
'【运财财神】29.3/19.2/13.4mm ',
'【活泼兔】33.8/16.3/15.2mm ',
'【富贵小猪】27.7/18.3/16mm ',
'【旺财】24.4/14.4/15.5mm ',];

      $price = 
        [1300,
1300,
2000,
1500,
1600,
1300,
1300,
1900,
1300,
2200,
2200,
2000,
1800,
1600,
1600,
2000,
1600,
2200,
2200,
1600,
7800,
10000,
2200,
2200,
1600,
2000,
2000,
4200,
3300,
4500,
4500,
1600,
2800,
8200,
2300,
2600,
2600,
3200,
3200,
2600,
6800,
4500,
3980,
15000,
1300,
1680,
1800,
1800,
2600,
1300,
1900,
2400,
3300,
2000,
2200,
2500,
1300,
1200,
1300,
1800,
2600,
1800,
1580,
2500,
1680,
1500,
1000,
1000,
800,
800,];
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
                  "ori_price"=>'', //100分
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
                Redis::sadd($this->group_id.":status1",$product_id); // 2:表示未上架
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
