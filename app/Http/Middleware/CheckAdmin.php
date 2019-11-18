<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        var_dump($params);
        //中间件
//        echo  '<h1>哈哈哈</h1>';



        if(!auth()->check()){
            return redirect(route('admin.login'))->withErrors(['errors' => '狗子先登录']);
        }

        //登录成功后得到当前登录用户的模型
        $userModel = auth()->user();

        //登录成功后获取用户角色
        $roleModel = $userModel->role;

        //使用角色与权限的多对多关联模型获取对应权限
        $auths = $roleModel->nodes()->pluck('route_name','id')->toArray();
        //真正的权限
        $authList = array_filter($auths);

        //不需要验证的权限
        $allowList = [
            'admin.index',
            'admin.logout',
            'admin.welcome'
        ];

        $authList = array_merge($authList,$allowList);

        //把权限写到request对象中
        $request->auths = $authList;

        //获取当前路由的别名
        $currentRouteName = $request->route()->getName();

        //获取当前用户名
        $currentUserName = auth()->user()->username;

        //保存当前用户名
        $request->username = $currentUserName;
        //权限判断
        if (!in_array($currentRouteName,$authList) && $currentUserName != 'admin'){
            exit('你没有权限');
        }

        return $next($request);
    }
}
