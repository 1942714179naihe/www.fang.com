<?php

namespace App\Observers;

use App\Jobs\FangOwnerJob;
use App\Models\FangOwner;
use Illuminate\Mail\Message;
use Mail;

class FangOwnerObserver {
    // 添加成功后会触发
    public function created(FangOwner $fangOwner) {
        $email = $fangOwner->email;
        $name = $fangOwner->name;

        $data = ['name'=>$name,'email'=>$email];
        // 投递一个任务 生产者
        dispatch(new FangOwnerJob($data));

        /*Mail::raw('添加您的信息成功，稍后我们会有工作人员联系您', function (Message $message) use ($email, $name) {
            $message->subject('信息添加通知邮件');
            $message->to($email, $name);
        });*/
    }

}
