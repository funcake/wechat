<?php

/*
 * This file is part of the overtrue/laravel-wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Overtrue\LaravelWeChat\Middleware;

use Closure;
use Illuminate\Support\Facades\Event;
use http\Env\Request;
use Overtrue\LaravelWeChat\Events\WeChatUserAuthorized;

/**
 * Class OAuthAuthenticate.
 */
class OAuthAuthenticateWork
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param string|null              $scopes
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $account = 'default', $scopes = null)
    {
        // $account 与 $scopes 写反的情况

        if (is_array($scopes) || (\is_string($account) && str_is('snsapi_*', $account))) {
            list($account, $scopes) = [$scopes, $account];
            $account || $account = 'default';
        }

        $isNewSession = false;
        $sessionKey = \sprintf('wechat.work.%s', $account);
        $config = config(\sprintf('wechat.work.%s', $account), []);
        $workAccount = app(\sprintf('wechat.work.%s', $account));
        $scopes = $scopes ?: array_get($config, 'oauth.scopes', ['snsapi_base']);

        if (is_string($scopes)) {
            $scopes = array_map('trim', explode(',', $scopes));
        }

        $session = session($sessionKey, []);

        if (!$session) {

            if ($request->has('code')) {

                $id = $workAccount->oauth->detailed()->user()['original'];
                dd($id);
                $user = $workAccount->user->get($id);

                //检测是否注册部门
                if ($user['department'][0] == 530528964) {
                  $id=$user['userid'];
                  return view('regist',compact('id'));
                }

                if($user['is_leader_in_dept'][0]) {
                    Redis::hmset($user['department'][0].':detail',
                        [ 
                            'avatar'=>$user['avatar'],
                            'userid'=>$user['userid'],
                            'name'=>$user['name'],
                            'mobile'=>$user['mobile'],
                            'address'=>$user['address'],
                            'finance'=>$user['extattr']['attrs'][0]['value'],
                        ]
                    );
                }
                session([$sessionKey => $user ?? []]);
                $isNewSession = true;

                // Event::fire(new WeChatUserAuthorized(session($sessionKey), $isNewSession, $account));
                return redirect()->to($this->getTargetUrl($request));
            }

            session()->forget($sessionKey);
            return $workAccount->oauth->scopes($scopes)->redirect($request->fullUrl());
        }
        // Event::fire(new WeChatUserAuthorized(session($sessionKey), $isNewSession, $account));

        return $next($request);
    }

    /**
     * Build the target business url.
     *
     * @param Request $request
     *
     * @return string
     */
    protected function getTargetUrl($request)
    {
        $queries = array_except($request->query(), ['code', 'state']);

        return $request->url().(empty($queries) ? '' : '?'.http_build_query($queries));
    }
}
