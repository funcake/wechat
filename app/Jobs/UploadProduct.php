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
        ['【一品清廉】 33*16.1*6.6',
'【一品清廉】 41*18.5*5.3',
'【悟道】 41*25.1*5.3',
'【莲蓬】 37.6*14.1*8.5',
'【一夜成龙】 62.1*20.3*10.2',
'【如鱼得水】 64.5*18.7*6',
'【出水芙蓉】 51.5*21.5*6.6',
'【爱莲说】 55.6*21.7*6.2',
'【隐居】 44.1*30.3*5.7',
'【大浪淘沙】 38*29*6',
'【大浪淘沙】 36*27*6',
'【出水芙蓉】 42*26.5*5.3',
'【平安扣】 25.8*3.3',
'【平安扣】  29.2*6.8',
'【平安扣】 25.6*4.7',
'【平安扣】 26*5.4',
'【平安扣】 28.7*5',
'【一鸣惊人】 63*18.3*10.5',
'【如意】 36.8*27*4.3',
'【如意】 45.8*34*3.1',
'【如意】 45.7*34.6*3',
'【节节高】 31*13.7*5.8',
'【傲骨长存】 34*16*6',
'【如意】 39.6*27*5.6',
'【出水芙蓉】 33.3*26.9*7.2',
'【出水芙蓉】 24.5*19.7*10.6',
'【四季豆】   30.5/12.1/6.0',
'【四季豆】  26.6/10.9/4.7',
'【四季豆】  31.1/11.1/5.1',
'【四季豆】  28.8/14/6.9',
'【四季豆】  34.2/12.7/7.6',
'【四季豆】  32.1/12.2/7.3',
'【莲蓬】  28.1/13.2/8.2',
'【如鱼得水】  30.6/15.9/5.9',
'【出水芙蓉】 32.4/14.86.3',
'【金玉满堂】 24.1/12.7/5.2',
'【松柏】 28.4/20.7/5.2',
'【四季豆】 29/13.8/6.6',
'【竹报平安】 31.9/16.8/9.0',
'【福袋】 25.5/15.8/9.8',
'【玉兰花】 29.3/13.6/4.6',
'【鱼跃龙门】 31.9/16.0/7.1',
'【金玉满堂】 38.6/16.9/9.8',
'【观音】 48/13.8/7.3',
'【悟道】 39.7/20.4/7.7',
'【一鸣惊人】 41.8/16.9/8.6',
'【多子多福】 43.5/13.4/7.6',
'【悟道】 37.2/19.6/6.3',
'【如意】 28.5/24.2/4.9',
'【如意】 39.1/26.3/5.2',
'【出淤泥而不染】 40.2/11.8/5.7',
'【出水芙蓉】 31.9/18.6/8.3',
'【爱莲说】 38/18.1/7.1',
'【一品清廉】 47.8/13.5/7.2',
'【出水芙蓉】 39.9/17.2/6.3',
'【一品清廉】 42.8/14.8/5.8',
'【蜻蜓点水】 34.8/13.4/4.8',
'【出水芙蓉】 33/18/11.2',
];

      $price = 
        [1290,
2750,
1250,
1150,
2250,
2630,
2500,
1630,
2000,
2000,
1880,
1250,
1150,
3750,
860,
860,
2750,
2750,
4750,
4500,
4500,
660,
860,
1250,
2250,
1290,
860,
580,
950,
580,
1290,
2250,
430,
580,
860,
720,
720,
720,
6000,
860,
720,
860,
1000,
3000,
1630,
4750,
1630,
1000,
1250,
1750,
860,
1500,
1380,
1880,
1290,
1250,
860,
1750,
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
