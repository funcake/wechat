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
        return 123;
    }

    public function update(array $message) {
        $post = ['name'=>'吴可可'];
        return app('wechat.work.user')->user->update('WuKe',$post);
    }

    public function change() {
        $server = app('wechat.work.user')->server;
        return $server->getMessage();
        $server->push($this->update($server->getMessage()), Message::EVENT);
        return  $server->serve();
    }
}
