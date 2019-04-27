<?php

namespace App\Http\Controllers;

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

    public function change() {
        return  app('wechat.work.user')->server->serve();
    }
}
