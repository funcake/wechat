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
      $name = [
         '【佛 豆果绿 】25/17.5/6.5mm',
        '【佛 果绿 】21.1/17.5/4.3mm',
        '【佛 果绿 】25.4/21.8/4.3mm',
        '【佛 果绿 】22.9/18.5/4.6mm',
        '【佛 果绿 】25.1/18.8/4.3mm',
        '【佛 果绿 】25.1/18.8/4.3mm',
        '【金鱼 阳绿】28.5/24.4/4.4mm',
        '【蛋面 果绿】13.4/12/6.2mm',
        '【蛋面 果绿 】18.3/12.8/5.2mm',
        '【蛋面 果绿】18.2/16.6/8.4mm',
        '【蛋面 果绿】18.3/14.8/6.5mm',
        '【蛋面 果绿】14/12.2/4.5mm',
        '【貔貅•阳绿】24.2/11.3/4.6mm',
        '【福豆•阳绿】35.1/11.6/6.4mm',
        '【福豆•阳绿】33.5/12.7/7.8mm',
        '【寿瓜•阳绿】28/11.2/4.1mm',
        '【佛•冰阳绿】21.1/16.7/3.6mm',
        '【佛•冰阳绿】23.5/22.4/4.5mm',
        '【佛•冰阳绿】28.5/23.2/5.2mm',
        '【如意•冰阳绿】43.2/21/5.2mm',
        '【寿瓜•冰阳绿】26.6/8.9/4.8mm',
        '【福豆•豆冰阳绿】44.9/19.6/5.5mm',
        '【福豆•豆冰阳绿】44.7/18.2/5.4mm',
        '【福豆•冰阳绿】40.6/16.8/5.6mm',
        '【佛•冰漂阳绿】21.1/19.4/5.2mm',
        '【送财蟾•冰阳绿】22/16.3/7.7mm',
        '【寿瓜•金丝绿】37.5/12.6/3.5mm',
        '【寿瓜•阳绿】40.8/16/2.7mm',
        '【寿瓜•阳绿】39.6/15.6/4.6mm',
        '【自在•满冰阳绿】23.3/19.6/2.1mm',
        '【如意•满冰阳绿】12.7/9.4/2.5mm',
        '【套水滴•冰阳绿】17.9/8.3/2.7mm',
        '【寿瓜•冰漂阳绿】28.4/12.3/4.7mm',
        '【寿瓜•背面有纹】40.8/15.7/4.4mm',
        '【寿瓜•满阳绿】36.8/13/3.4mm',
        '【寿瓜•阳绿】33.7/15.3/4.6mm',
        '【福豆•阳绿】35.1/14.5/5.1mm',
        '【寿瓜•冰阳绿】35.5/14.4/4.7mm',
        '【如意•冰阳绿】29.4/18.8/2.6mm',
        '【如意•冰阳绿】29.1/18.6/2.9mm',
        '【如意•冰阳绿】32.2/19.9/3mm',
        '【如意•阳绿花】33.8/20.8/2.9mm',
        '【寿瓜•金丝绿】38.2/14.2/2.8mm',
        '【自在•果绿】25.1/13.4/3.9mm',
        '【福•果阳绿】20.6/13.3/4.8mm',
        '【福禄•冰阳绿】26.4/15.5/5.2mm',
        '【福禄•冰阳绿】26.1/15.4/4.9mm',
        '【福禄•冰阳绿】20/14.5/5.2mm',
        '【福升•冰阳绿】44.3/21.5/3.8mm',
        '【福瓜•18K钻果阳绿】47.2/14.6/7.8',
        '【福瓜•18K钻满阳绿】42/20.5/9.2',
        '【寿瓜•18K钻冰阳绿】39.4/16.3/8.6',
        '【如意•18K钻阳绿】27.4/26.5/8.3',
        '【平安扣•冰阳绿】27.7/27.7/4.1mm',
        '【平安扣•冰阳绿花】25.9/25.9/3.6m',
        '【平安扣•金丝绿】24.3/24.3/3.5mm',
        '【平安扣•金丝绿】29.8/29.8/4.5mm',
        '【平安扣•阳绿花】30/30/4.2mm',
      ];

     $price = [1300,1300,2500,1000,3500,3000,3500,1300,3800,1500,1000,1000,3000,7000,12000,4000,5000,13000,45000,30000,9000,13000,13000,16000,6800,13000,15000,20000,30000,35000,10000,6000,9000,12000,18000,13000,20000,15000,8000,8000,8000,8000,7000,2000,3000,15000,10000,10000,12000,13000,28000,20000,20000,13000,10000,4000,8000,8000,];
        // return app('wechat.official_account')->merchant->uploadImage(,$i.'.jpg');
        $err = []; //第多少个商品创建失败
        for ($i=0; $i < $this->amount ; $i++) {
            $post =
            [
              "product_base"=>[
                "category_id"=>[
                  "536903132" // 微信小店的种类：翡翠，总之不要管这个
                ],
                "name"=> $name[$i+1], //商品名称

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
                  "price"=>100*$price[$i+1], // 1分 微信价必须比原价ori_price小，不然添加失败
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
