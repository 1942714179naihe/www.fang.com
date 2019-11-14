<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2019/11/11
 * Time: 20:29
 */

namespace App\Models\Services;
use Illuminate\Http\Request;
use  App\Models\Role;


class RoleService
{
    public function getList(Request $request,int $pagesize=10)
    {


        //角色搜索
        $kw = $request->get('kw');

        //withTranshed 方法显示软删除he可用的所有的数据记录
        //when方法如果参数1条件成功，则调用回调方法
        return Role::when($kw,function ($query) use ($kw){

            $query->where('name','like',"%{$kw}%");

        })->orderBy('id','desc')->paginate($pagesize);
    }

}