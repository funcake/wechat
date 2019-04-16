<?php

/*
 * This file is part of the overtrue/socialite.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Overtrue\Socialite\Providers;

use Overtrue\Socialite\AccessTokenInterface;
use Overtrue\Socialite\InvalidArgumentException;

use Overtrue\Socialite\ProviderInterface;
use Overtrue\Socialite\User;

/**
 * Class WeWorkProvider.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class WeWorkProvider extends AbstractProvider implements ProviderInterface
{
    /**
     * @var string
     */
    protected $agentId;

    /**
     * @var bool
     */
    protected $detailed = false;


    protected $stateless = true;
    /**
     * Set agent id.
     *
     * @param string $agentId
     *
     * @return $this
     */


    public function setAgentId($agentId)
    {
        $this->agentId = $agentId;

        return $this;
    }

    /**
     * @param string $agentId
     *
     * @return $this
     */
    public function agent($agentId)
    {
        return $this->setAgentId($agentId);
    }

    /**
     * Return user details.
     *
     * @return $this
     */
    public function detailed()
    {
        $this->detailed = true;

        return $this;
    }

    /**
     * @param string $state
     *
     * @return string
     */
    protected function getAuthUrl($state)
    {
        // 网页授权登录
        if (!empty($this->scopes)) {
            return $this->getOAuthUrl($state);
        }

        // 第三方网页应用登录（扫码登录）
        return $this->getQrConnectUrl($state);
    }

    /**
     * OAuth url.
     *
     * @param string $state
     *
     * @return string
     */
    protected function getOAuthUrl($state)
    {
        $queries = [
            'appid' => $this->clientId,
            'redirect_uri' => $this->redirectUrl,
            'response_type' => 'code',
            'scope' => $this->formatScopes($this->scopes, $this->scopeSeparator),
            'agentid' => $this->agentId,
            'state' => $state,
        ];

        return sprintf('https://open.weixin.qq.com/connect/oauth2/authorize?%s#wechat_redirect', http_build_query($queries));
    }

    /**
     * Qr connect url.
     *
     * @param string $state
     *
     * @return string
     */
    protected function getQrConnectUrl($state)
    {
        $queries = [
            'appid' => $this->clientId,
            'agentid' => $this->agentId,
            'redirect_uri' => $this->redirectUrl,
            'state' => $state,
        ];

        return 'https://open.work.weixin.qq.com/wwopen/sso/qrConnect?'.http_build_query($queries);
    }

    protected function getTokenUrl()
    {
        return null;
    }

    /**
     * @param \Overtrue\Socialite\AccessTokenInterface $token
     *
     * @return mixed
     */
    protected function getUserByToken(AccessTokenInterface $token)
    {
        $userInfo = $this->getUserInfo($token);

        if ($userInfo['errcode']!= 0) {
            throw new InvalidArgumentException($userInfo['errcode'].' '.$userInfo['errmsg'], 1);
        }

        if ($this->detailed && isset($userInfo['UserId'])) {
            return $this->getUserDetail($token, $userInfo['UserId']);
        }

        $this->detailed = false;

        return $userInfo;
    }

    /**
     * Get user base info.
     *
     * @param \Overtrue\Socialite\AccessTokenInterface $token
     *
     * @return mixed
     */
    protected function getUserInfo(AccessTokenInterface $token)
    {
        $response = $this->getHttpClient()->get('https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo', [
            'query' => array_filter([
                'access_token' => $token->getToken(),
                'code' => $this->getCode(),
            ]),
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * Get user detail info.
     *
     * @param \Overtrue\Socialite\AccessTokenInterface $token
     * @param $ticket
     *
     * @return mixed
     */
    protected function getUserDetail(AccessTokenInterface $token, $ticket)
    {dd($ticket);
        $response = $this->getHttpClient()->get('https://qyapi.weixin.qq.com/cgi-bin/user/get', [
            'query' => [
                'access_token' => $token->getToken(),
                'userid' => $ticket,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * @param array $user
     *
     * @return \Overtrue\Socialite\User
     */
    protected function mapUserToObject(array $user)
    {
        if ($this->detailed) {
            return new User([
                'id' => $this->arrayItem($user, 'userid'),
                'name' => $this->arrayItem($user, 'name'),
                'avatar' => $this->arrayItem($user, 'avatar'),
                'email' => $this->arrayItem($user, 'email'),
            ]);
        }

        return new User(array_filter([
            'id' => $this->arrayItem($user, 'UserId') ?: $this->arrayItem($user, 'OpenId'),
            'userId' => $this->arrayItem($user, 'UserId'),
            'openid' => $this->arrayItem($user, 'OpenId'),
            'deviceId' => $this->arrayItem($user, 'DeviceId'),
        ]));
    }
}
