<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Redis;


class RegistDepartment extends Job
{
    protected $message;
    protected $id;
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
        if ($message['ParentId'] == 11) {
            $id = app('wechat.official_account')->merchant->groupAdd($message['Name']);
            $this->id = $id;
            app('wechat.work.user')->department->create(['id'=>$id,'name'=>$message['Name'],'parentid'=>5]);
            app('wechat.work.user')->department->delete($message['Id']);
            // Redis::hset('groups',[$this->id=>$message['Name']]);
        }
    } 

    public function failed() {
        app('wechat.official_account')->merchant->groupDel($this->id);
    }

}
