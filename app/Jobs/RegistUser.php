<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Redis;


class RegistUser extends Job
{
    protected $id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = app('wechat.work')->user->get($this->id);
        Redis::hmset($user['department'][0],
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
}
