<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        //php artisan queue:table
        $this->email=$email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //编辑任务, 在控制器推送队列任务,再执行队列监听器 php artisan queue:listen

        \Mail::raw('队列测试',function ($message){
            $message->subject('队列主题测试');
            $message->to($this->email);
        });

        //\Log::info('已发送邮件 - '.$this->email);

    }
}
