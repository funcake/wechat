<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Redis;


class RegistDepartment extends Job
{
    protected $message;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message = $this->message;
        if (isset($message['IsLeaderInDept'])&&$message['IsLeaderInDept'] == 1) {
            Redis::hmset($user['Department'][0],
                [
                    'avatar'=>$user['avatar'],
                    'userid'=>$user['userid'],
                    'name'=$user['name'],
                    'mobile'=>$user['mobile'],
                    'address'=>$user['address'],
                    'finance'=>$user['extattr']['attrs'][0]['value'],
                ]);
        }
    }
}
