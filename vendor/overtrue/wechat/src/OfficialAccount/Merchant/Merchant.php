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

use illuminate\http\Request;
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
    public function update($product)
    {
        //编辑商品
       $this->httpPostJson('merchant/update', $product);
        //上架商品
        return $this->httpPostJson('merchant/modproductstatus',['product_id'=>$product['product_id'],'status'=>1]);
    }

// 货架管理
    public function shelf() {
        $post = [
        "shelf_data"=>[
          "module_infos"=>[
            [
                'group_infos' => [
                    'groups' => [
                        [
                            'group_id' => 530579200
                        ],
                    ],
                ],
                'eid' => 3
            ],
            // [
            //     "group_infos"=>[
            //           "groups"=>[
            //               [
            //                   "group_id"=>530579200
            //               ],
            //                [
            //                   "group_id"=>530579200
            //               ],
            //                [
            //                   "group_id"=>530579200
            //               ],
            //                [
            //                   "group_id"=>530579200
            //               ],
            //           ],
            //           "img_background"=>"http://mmbiz.qpic.cn/mmbiz_jpg/zjU4wTBaB7fCM4PaQ3tia6zU8bvgxT8q28YkDNPNwkj97M23s0IwZIcRYaPjdq2AWGDDqXTMd3IiaCUEzbsn6ojQ/0"
            //       ],
            //       "eid"=>5
            // ]

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

    public function setDelivery($order_id,$delivery_track_on) {
      $post = [
        'order_id' => $order_id,
        'delivery_company' => '066zhongtong',
        'delivery_track_on' => $delivery_track_on,
        'need_delivery' => 1,
        'is_others'=>0
      ];
        return $this->httpPostJson('merchant/order/setdelivery',$post);
    }

    public function uploadImage( string $filename)
    {
        $data = app('wechat.official_account')->material->uploadImage(getcwd().'/storage/app/public/'.$filename);
        app('wechat.official_account')->material->delete($data['media_id']);
        return $data['url'];
    }

}
