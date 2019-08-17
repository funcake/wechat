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
        [' 【龙璧】51.4/51.3/5.0mm',
' 【长寿富贵】53.1/53.1/6.2mm',
' 【麒麟送福】53.5/53.5/5.8mm',
' 【寿瓜】37.2/24.9/12.3mm',
' 【霸王貔貅】36.9/20.2/20.3mm',
' 【霸王貔貅】37.5/23.1/22.8mm',
' 【布袋佛】46.2/24.2/16.4mm',
' 【禅•大慈大悲】35.9/21.4/3.3mm',
' 【禅•普度众生】48/23.2/10.1mm',
' 【佛法无疆】43.2/17.8/12.5mm',
' 【大慈大悲】42.4/23.9/9.7mm',
' 【大慈大悲】45.2/21.1/12mm',
' 【普度众生】53.3/19.3/9.9mm',];

      $price = 
        [3500,
4380,
5380,
4800,
9380,
8800,
15000,
5600,
4380,
7500,
10600,
10600,
7250,];
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
