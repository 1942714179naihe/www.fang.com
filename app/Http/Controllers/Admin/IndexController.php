<?php

namespace App\Http\Controllers\Admin;

use App\Models\Node;
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
        //闪存
//        session()->flash('success',session('success'));

        //的能到当前登录用户
        $userModel = auth()->user();
        //用户对应的角色关联关系  属于
        $roleModel = $userModel->role;

        //得到有彩蛋权限的权限
        if ($userModel->username != 'admin'){
        //普通用户
            $nodeData = $roleModel->nodes()->where('is_menu','1')->get(['id','pid','name','route_name'])->toArray();
        }else{
            //超级管理员
            $nodeData = Node::where('is_menu','1')->get(['id','pid','name','route_name'])->toArray();
        }

        //调用递归函数，进行多成数组嵌套
        $menuData = subTree($nodeData);
        return view('admin.index.index',compact('menuData'));
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
