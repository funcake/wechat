<?php

namespace App\Http\Controllers;

use EasyWeChat\Kernel\Messages\Message;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function create() {

        return $a;
    }

    public function update(array $message) {

        $post = ['name'=>$message['UserID']];

        return app('wechat.work.user')->user->update('Wuke',$post);

    }

    public function photoMessage()
    {
        // return app('wechat.work')->messenger->message("新至商品")->toTag(1)->send();
        Redis::hset('photo',$_POST['group'],$_POST['amount']);
        return app('wechat.work')->messenger->message(Redis::hget('group',$_POST['group'])."新至商品".$_POST['amount'].'件')->toTag(1)->send();
        // return app('wechat.work')->messenger->message(Redis::hget('group',$_POST['group'])."新至商品".$_POST['amount'].'件')->toTag(1)->send();
    }
}
