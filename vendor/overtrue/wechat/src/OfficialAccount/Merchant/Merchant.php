<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyWeChat\OfficialAccount\Merchant;

use EasyWeChat\Kernel\BaseClient;
use EasyWeChat\Kernel\Http\StreamResponse;


/**
 * Class UserClient.
 *
 * @author overtrue <i@overtrue.me>
 */
class Merchant extends BaseClient
{
    /**
     * Fetch a user by open id.
     *
     * @param string $openid
     * @param string $lang
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function get(string $productId, string $lang = 'zh_CN')
    {
        return $this->httpPostJson('merchant/get', ['product_id'=>$productId])['product_info'];
    }


/**
     * List users.
     *
     * @param string $nextOpenId
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function list(int $status = 0)
    {
        $params = ['status' => $status];

        return $this->httpPostJson  ('merchant/getbystatus', $params)['products_info'];
    }

    /**
     * Set user remark.
     *
     * @param string $openid
     * @param string $remark
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function update(string $lang = 'zh_CN')
    {
        $_POST['sku_list'][0]['icon_url'] = "http://mmbiz.qpic.cn/mmbiz/4whpV1VZl28bJj62XgfHPibY3ORKicN1oJ4CcoIr4BMbfA8LqyyjzOZzqrOGz3f5KWq1QGP3fo6TOTSYD3TBQjuw/0";
        //编辑商品
        $this->httpPostJson('merchant/update', $_POST);
        //上架商品
        return $this->httpPostJson('merchant/modproductstatus',['product_id'=>$_POST['product_id'],'status'=>1]);
    }

    public function shelf() {
        $post = ['shelf_id'=>1,
        "shelf_data"=>[
          "module_infos"=>[
            [
              "group_infos"=>[
                "groups"=>[

                  [
                    "group_id"=>512519882
                        ]
                    ],
                    "img"=>"http://mmbiz.qpic.cn/mmbiz_jpg/zjU4wTBaB7fCM4PaQ3tia6zU8bvgxT8q28YkDNPNwkj97M23s0IwZIcRYaPjdq2AWGDDqXTMd3IiaCUEzbsn6ojQ/0"
                ],
                "eid"=>3
            ],
                [
                  "group_infos"=>[
                    "groups"=>[

                      [
                        "group_id"=>512519882
                    ]
                ],
                "img"=>"http://mmbiz.qpic.cn/mmbiz_jpg/zjU4wTBaB7fCM4PaQ3tia6zU8bvgxT8q28YkDNPNwkj97M23s0IwZIcRYaPjdq2AWGDDqXTMd3IiaCUEzbsn6ojQ/0"
            ],
            "eid"=>3
            ]

            ]
            ],
            "shelf_banner"=>"http://mmbiz.qpic.cn/mmbiz_jpg/zjU4wTBaB7fCM4PaQ3tia6zU8bvgxT8q28YkDNPNwkj97M23s0IwZIcRYaPjdq2AWGDDqXTMd3IiaCUEzbsn6ojQ/0",
            "shelf_name"=>"货架"
            ];

        return $this->httpPostJson('merchant/shelf/add',$post);
    }

    public function create() {
      //调用这个创建商品接口的时候，需要提供两个参数：1，商品数量。  2，第一张图片的完整地址.通过001.jpg 去获取 002 003
      //还可以再提供第三个参数：每个商品需要几个图片，暂时默认6张
      //循环创建多个商品，图片按顺序递增获取
        $folder = 'feng20190606'; //工作人员在接口地址加上文件夹参数，传入文件夹名称
        $domain = 'https://fljy.oss-cn-hangzhou.aliyuncs.com/';
        $post =
        [
          "product_base"=>[
            "category_id"=>[
              "536903132" // 固定的不用改 品类：翡翠
            ],
            "name"=>"", //商品名称
            //https://fljy.oss-cn-hangzhou.aliyuncs.com/002.jpg
            "main_img"=> $domain . $folder . '/m.jpg', //商品主图
            "img"=>[ // 商品图片列表
              $domain . $folder . '/1.jpg',
              $domain . $folder . '/2.jpg',
              $domain . $folder . '/3.jpg',
              $domain . $folder . '/4.jpg',
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
              "icon_url"=> $domain . $folder . '/i.jpg',
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


        return $this->httpPostJson('merchant/create',$post);
    }

    public function delete() {
        return $this->httpPostJson('merchant/del',$_POST);
    }

    public function getProperty() {
        $post = ['cate_id' =>536903132];
        return $this->httpPostJson('merchant/category/getproperty',$post)['properties'];
    }


    public function group($group_id = 0) {
        $post = ['group_id' => $group_id];
        $group = $this->httpPostJson('merchant/group/getbyid',$post)['group_detail']['product_list'];
        $list = ['status1'=>[],'status2'=>[]];
         foreach ($group as $key => $id) {
            $product =  $this->get($id);
            if($product['status'] === 1) {
                array_unshift($list['status1'], $product);
            } else {
                array_unshift($list['status2'], $product);
            }
        }
        return $list;
    }

    public function groupAdd($name) {
        $post = ['group_detail'=>['group_name'=>$name]];
        return $this->httpPostJson('merchant/group/add',$post)['group_id'];
    }

    public function groupDel($id)
    {
        return $this->httpPostJson('merchant/group/del',['group_id'=>$id]);
    }

    public function groupAll()
    {
        return $this->httpGet('merchant/group/getall')['groups_detail'];
    }

    public function getOrder($id)
    {
        return $this->httpPostJson('merchant/order/getbyid',['order_id'=>$id])['order'];
    }

    public function orderList(int $status = 2)
    {
        return $this->httpPostJson('merchant/order/getbyfilter',['status'=>$status])['order_list'];
    }

    public function setDelivery() {
      $post = [
        'order_id' => $_POST['order_id'],
        'delivery_company' => '',
        'delivery_track_on' => $_POST['delivery_track_on'],
        'need_delivery' => 1,
      ];

        return $this->httpPostJson('merchant/order/setdelivery',$post);
    }



}
