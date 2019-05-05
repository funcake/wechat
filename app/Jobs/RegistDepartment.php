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
        echo 1234;
        app('wechat.work')->user->update('WuKe',['name'=>'asdfsdfs']);
        // $message = $this->message;
     /*   if ($message['ParentId'] == 11) {
            $id = app('wechat.official_account')->merchant->groupAdd($message['Name']);
            app('wechat.work.user')->department->create(['id'=>$id,'name'=>$message['Name'],'parentid'=>5]);
            app('wechat.work.user')->department->delete($message['Id']);
        }*/
    } 

}
