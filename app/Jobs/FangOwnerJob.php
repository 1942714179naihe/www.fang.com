<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Message;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;

class FangOwnerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    //成员熟悉
    public $userData;
    public function __construct(array  $data)
    {
        //
        $this->userData = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //

        $email = $this->userData['email'];
        $name = $this->userData['name'];

        Mail::raw('添加你的信息成功，等会有恩通知你',function (Message $message) use ($email,$name){
            $message->subject('信息添加通知');
            $message->to($email,$name);
        } );
    }
}
