<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
//    public function __construct()
//    {
//        //绑定路由中间件
//        $this->middleware('checkadmin');
//
//    }

    public function  index()
    {
        return view('admin.index.index');
    }
    //欢迎页
    public function  welcome()
    {
        return view('admin.index.welcome');
    }

    public function logout(){
        auth()->logout();

        return redirect(route('admin.login'))->with('success','退出成功');
    }
}
