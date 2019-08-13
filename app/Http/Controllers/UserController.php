<?php

namespace App\Http\Controllers;

use EasyWeChat\Kernel\Messages\Message;

use Illuminate\Support\Facades\Redis;
use illuminate\http\Request;



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
        Redis::hset('photo',$_POST['group'],$_POST['amount']);
        return app('wechat.work')->messenger->message(Redis::hget('groups',$_POST['group']).' '.$_POST['address']." 新至商品".$_POST['amount'].'件')->toTag(1)->send();
    }

    public function registDepartment(Request $request) {
        $name = $request->name;
        //创建微信小店的商品分组 返回分组id 整型
        $group_id = app('wechat.official_account')->merchant->groupAdd($name);
        //同时创建企业微信部门
        $dept = app('wechat.work.user')->department->create(['id'=> $group_id, 'name'=> $name, 'parentid'=>5]);

        if($dept['errcode'] !== 0) {
            return '部门名称已存在，请使用其他名称！';
        }
        
        $tag = app('wechat.work.user')->tag->tagDepartments(2,[$group_id]);

        app('wechat.work.user')->user->update($request->id,['department'=>[$group_id],'is_leader_in_dept'=>[1],'address'=>$request->address,'mobile'=>$request->mobile]);

        Redis::hset('groups', $group_id, $name);
        session()->forget('wechat.work.default');
        return '注册成功！';
        return redirect('/');
    }
}
