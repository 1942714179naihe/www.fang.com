<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//引入邮件类
use  Mail;
use  Illuminate\Mail\Message;


class LoginController extends Controller
{
    public function  index(){
        return view('admin.login.index');
    }

    //登录处理
    public  function  login(Request $request){
        $data = $this->validate($request,[
//            'email' => 'email|required',
            'username' => 'required',
            'password' => 'required',
        ]);
//        $t = time();
//        dump($t);die;
//         $a = bcrypt('123456');
//         dump($a);die;

//        dump($request);die;
        //auth登录
        $bool = auth()->attempt($data);
        //dump($bool);die;

       //判断用户是否登录成功
        if(!$bool){
            //如果没登录就返回登录界面
            return redirect(route('admin.login'))->withErrors(['error'=>'登录失败']);
        }

//        发邮件通知
//        Mail::send('admin.mailer.login',compact('data'),function (Message $message) use ($data){
//            //主题
//            $message->subject('登录用户通知');
//            //发给谁
//            $message->to($data['email'],$data['username'],$data['password']);
//        });

        //跳转到后台页面
        return redirect(route('admin.index'));
    }
}
