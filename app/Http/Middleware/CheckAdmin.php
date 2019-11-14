<?php

namespace App\Http\Middleware;

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

        return $next($request);
    }
}
