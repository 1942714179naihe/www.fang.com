<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function  index(){
        return view('admin.login.index');
    }

    //登录处理
    public  function  login(Request $request){
        $data = $this->validate($request,[
            'username' => 'required',
            'password' => 'required',
        ]);

        //auth登录
        $bool = auth()->attempt($data);

        dump($bool);

        dump(auth()->user());
    }
}
