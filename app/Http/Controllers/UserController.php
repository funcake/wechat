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
        $post = ['name'=>$message['UserID']];

        return app('wechat.work.user')->user->update('Wuke',$post);
    }

    public function updateParty() {

    }

    public function change() {
        $server = app('wechat.work.user')->server;
        $message = $server->getMessage();
        switch ($message['ChangeType']) {
            case 'create_party': 
                if ($message['ParentId'] == 5) {
                    $id = app('wechat.official_account')->merchant->groupAdd($message['Name']);
                    // app('wechat.work.user')->department->update($id,['name'=>$message['Name'],'parentid'=>5]);
                }
                break;
            
            default:
                # code...
                break;
        }
        $this->update($server->getMessage());
        return  $server->serve();
    }
}
