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
        $params = [
            'product_id' => $productId,
        ];

        return $this->httpPostJson('merchant/get', $params);
    }

    /**
     * Batch get users.
     *
     * @param array  $openids
     * @param string $lang
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function select(array $openids, string $lang = 'zh_CN')
    {
        return $this->httpPostJson('cgi-bin/user/info/batchget', [
            'user_list' => array_map(function ($openid) use ($lang) {
                return [
                    'openid' => $openid,
                    'lang' => $lang,
                ];
            }, $openids),
        ]);
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

    return $this->httpPostJson  ('merchant/getbystatus', $params);
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
    public function update(array $post,string $lang = 'zh_CN')
    {
        // return $post['sku_list'];
$post['product_base']['detail'][0]['test'] = '<h1> sldkfj</h1><p>123132</p>';
        $post['sku_list'][0]['icon_url'] = "http://mmbiz.qpic.cn/mmbiz/4whpV1VZl28bJj62XgfHPibY3ORKicN1oJ4CcoIr4BMbfA8LqyyjzOZzqrOGz3f5KWq1QGP3fo6TOTSYD3TBQjuw/0";


        return $this->httpPostJson('merchant/update', $post);
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
        ], [
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

}
