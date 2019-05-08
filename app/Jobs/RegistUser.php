<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Redis;


class RegistDepartment extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Redis::hmset($user['Department'][0],
            [
                'avatar'=>$user['avatar'],
                'userid'=>$user['userid'],
                'name'=$user['name'],
                'mobile'=>$user['mobile'],
                'address'=>$user['address'],
                'finance'=>$user['extattr']['attrs'][0]['value'],
            ]
        );
    }
}
