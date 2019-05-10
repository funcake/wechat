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
        $post = 
        [
          "product_base"=>[
            "category_id"=>[
              "536903132"
            ],
            "name"=>"",
            "main_img"=>"http://mmbiz.qpic.cn/mmbiz/4whpV1VZl2iccsvYbHvnphkyGtnvjD3ulEKogfsiaua49pvLfUS8Ym0GSYjViaLic0FD3vN0V8PILcibEGb2fPfEOmw/0", 
            "img"=>[
              "http://mmbiz.qpic.cn/mmbiz/4whpV1VZl2iccsvYbHvnphkyGtnvjD3ulEKogfsiaua49pvLfUS8Ym0GSYjViaLic0FD3vN0V8PILcibEGb2fPfEOmw/0"
            ],
            "property"=>[['id'=> "1075743465", 'vid'=> '1079783194']],
            "buy_limit"=>1
          ],
          "sku_list"=>[
            [
              "sku_id"=>"",
              "price"=>1,
              "icon_url"=>"http://mmbiz.qpic.cn/mmbiz/4whpV1VZl28bJj62XgfHPibY3ORKicN1oJ4CcoIr4BMbfA8LqyyjzOZzqrOGz3f5KWq1QGP3fo6TOTSYD3TBQjuw/0",
              "product_code"=>"512519882",
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
            "isHasReceipt"=>1,
            "isUnderGuaranty"=>0,
            "isSupportReplace"=>0
          ],
          "delivery_info"=>[
            "delivery_type"=>0,
            "template_id"=>0, 
            "express"=>[
              [
                "id"=>10000027, 
                "price"=>100
              ], 
              [
                "id"=>10000028, 
                "price"=>100
              ], 
              [
                "id"=>10000029, 
                "price"=>100
              ]
            ]
          ]
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
        return $this->httpPostJson('merchant/order/getbyfilter',['status'=>2])['order_list'];
    }

}
