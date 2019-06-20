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
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use Log;


/**
 * Class UserClient.
 *
 * @author overtrue <i@overtrue.me>
 */
class Merchant extends BaseClient
{

  // 产品管理

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

// 货架管理
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

    public function create($post) {

        return $this->httpPostJson('merchant/create',$post);

    }

    public function delete() {
        return $this->httpPostJson('merchant/del',$_POST);
    }

// 属性管理
    public function getProperty() {
        $post = ['cate_id' =>536903132];
        return $this->httpPostJson('merchant/category/getproperty',$post)['properties'];
    }


// 分组管理
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

    public function groupMod($mod)
    {
        return $this->httpPostJson('merchant/group/productmod',$mod);
    }

    public function groupById($id)
    {
        return $this->httpPostJson('merchant/group/getbyid',['group_id'=>$id]);
    }
// 订单管理
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

    public function uploadImage( string $filename)
    {
        $path = getcwd().'/storage/app/public/'.$filename;
          if (!file_exists($path) || !is_readable($path)) {
              throw new InvalidArgumentException(sprintf('File does not exist, or the file is unreadable: "%s"', $path));
          }
        $url = "https://api.weixin.qq.com/merchant/common/upload_img?access_token=".app('wechat.official_account')->access_token->getToken()['access_token']."&filename=".$filename;

        $data = file_get_contents($path);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $return_data = curl_exec($ch);
        curl_close($ch);
        Log::info($return_data);
        return  json_decode($return_data,true)['image_url'];
    }

}
