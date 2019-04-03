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
    public function update(array $post)
    {
          $params = [
            'product_id' =>$post['id'],
            'product_base' => [
                'name' => $post['name'],
                'buy_limit' => $post['limit'],
            ],
           
            
         ];
         // return $params;
        return $this->httpPost('merchant/update', $params);
    }

    /**
     * Get black list.
     *
     * @param string|null $beginOpenid
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function blacklist(string $beginOpenid = null)
    {
        $params = ['begin_openid' => $beginOpenid];

        return $this->httpPostJson('cgi-bin/tags/members/getblacklist', $params);
    }

    /**
     * Batch block user.
     *
     * @param array|string $openidList
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function block($openidList)
    {
        $params = ['openid_list' => (array) $openidList];

        return $this->httpPostJson('cgi-bin/tags/members/batchblacklist', $params);
    }

    /**
     * Batch unblock user.
     *
     * @param array $openidList
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function unblock($openidList)
    {
        $params = ['openid_list' => (array) $openidList];

        return $this->httpPostJson('cgi-bin/tags/members/batchunblacklist', $params);
    }

    /**
     * @param string $oldAppId
     * @param array  $openidList
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function changeOpenid(string $oldAppId, array $openidList)
    {
        $params = [
            'from_appid' => $oldAppId,
            'openid_list' => $openidList,
        ];

        return $this->httpPostJson('cgi-bin/changeopenid', $params);
    }
}
