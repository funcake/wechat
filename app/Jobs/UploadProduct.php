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
        [
          ' 【貔貅•小摆件】 58.1/33.2/20.8mm',
          ' 【貔貅•小摆件】 56.5/33.6/28.4mm',
          '  【寿星•黄翡】 67.5/35.4/7.3mm',
          ' 【一路平安】68.943.5/7.1mm',
          ' 【龙头龟•富贵长寿】66.3/38.2/19.4mm',
          '  【佛•招财】43.8/39.3/12.1mm',
          ' 【龙鱼•化龙】 51.2/17.8/19.3mm',
          ' 【龙钩•辈辈成龙】 66.9/13.8/20.4mm',
          '  【飞龙•黄翡】56.2/35.5/9.6mm',
          ' 【龙•风调雨顺】 59.1/40.5/11.7mm',
          ' 【龙•风调雨顺】52.1/38.3/13mm',
          ' 【西方三圣】 44.8/26.6/16.2mm',
          ' 【禅•如来】75.6/10.5/31.1mm',
          ' 【禅•如来】 76.5/13.7/27.6mm',
          ' 【禅•如来】 70.3/10.3/40.5mm',
          ' 【禅•如来】35.7/23.6/14.6mm',
          ' 【宝宝佛•禅定】34.2/21.6/15.8mm ',
          ' 【宝宝佛•禅定】32.1/19.5/14.7mm',
          ' 【宝宝佛•禅定】24.9/14.7/14.2mm',
          ' 【宝宝佛•禅定】25.8/15.5/13mm',
          '  【宝宝佛•禅定】30.7/15.6/12.6mm',
          ' 【印•旺财貔貅】 43.9/14/14mm',
          ' 【印•麒麟吉祥】38.4/20.1/14.2mm',
          ' 【印•旺财貔貅】 51.8/17.2/14.2mm',
          ' 【印•旺财貔貅】 34.9/14.4/13.4mm',
          ' 【印•旺财貔貅】 35.1/14.6/13.2mm',
          '【貔貅•招财】 36.3/14.4/14.2mm',
          ' 【貔貅•对庄】 45/21.6/15.5/mm',
          '【貔貅•冰蓝花】 37.2/16.7/13.9mm',
          ' 【蜗牛•安居乐业】37.6/19.2/12mm',
          '  【佛•吉祥】 41/32.7/15.3mm',
          '  【禅定•如来】 45.6/28.3/12.5mm',
          ' 【龙鱼•拼搏】 35.4/21.7/7.1mm',
          ' 【财源滚滚】 43.8/36.6/5.5mm',
          ' 【寿瓜】 55.8/27.4/8.1mm',
          ' 【玉米•丰收】 48.8/16/6.8mm',
          ' 【自在•观音】 45.6/16.1/8.7mm',
          '  【自在•如来】 44.8/12.3/7.2mm',
          '  【自在•如来】 51.3/15.7/7.3mm ',
          ' 【如意•冰蓝花】 29.2/20/6.8mm',
          ' 【知足•冰种】 24.2/14.6/13.1mm',
          ' 【年年有余】 42.9/18/16.5mm',
          ' 【蛙•祈福】50.3/14.1/16mm',
          ' 【灵蛇送财】 53.5/17.4/12.2mm',
          ' 【节节高】40.9/12.9/6.1mm',
          '  【鲤鱼入道】45.1/16.7/11.3mm',
          ' 【鲤鱼跃龙门】36.4/14.1/14.7mm',
          ' 【貔貅•有求必应】34.7/13.6/16.9mm',
          ' 【貔貅•有求必应】33.7/13.4/13.2mm',
          ' 【貔貅•有求必应】36.4/12.2/15.8mm',
          '【事业有成•高冰】45.6/23.6/5.3mm',
          '【马上发财•高冰】44.1/13.2/25.7mm',
          ' 【马上封侯•高冰】36.5/13.7/27.9mm',
          ' 【马上封侯•冰蓝】35.5/11.7/22.7mm',
          ' 【马上封侯•冰蓝】36.3/14.5/23.7mm',
          ' 【自在佛】18K钻 62.7/13.4/13.1mm',
          ' 【自在观音】18K钻 51.5/13.8/10.6mm',
          ' 【观音相】18K 51.1/25.2/11.8mm',
          ' 【观音相】18K 36.2/27.2/11.4mm',
        ];

      $price = 
        [
          3100,
          3100,
          2500,
          1600,
          3200,
          1600,
          1600,
          1600,
          3200,
          3200,
          1900,
          18800,
          6800,
          5600,
          5600,
          11200,
          6800,
          6800,
          5000,
          6800,
          6800,
          16000,
          16000,
          6200,
          6200,
          6200,
          2300,
          5000,
          16200,
          2300,
          3800,
          4500,
          2200,
          3800,
          3800,
          3200,
          4800,
          3800,
          4800,
          10000,
          4500,
          3200,
          3500,
          2900,
          3200,
          2900,
          2900,
          6800,
          4800,
          16200,
          25000,
          22500,
          22500,
          22500,
          22500,
          16200,
          16200,
          18800,
          12500,
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
