<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2019/11/11
 * Time: 20:29
 */

namespace App\Models\Services;
use Illuminate\Http\Request;
use  App\Models\Admin;


class AdminService
{
    public function getList(Request $request,int $pagesize=10)
    {
        //时间
        $st = $request->get('st');
        $et = $request->get('et');

        //张哈及
        $kw = $request->get('kw');

        //withTranshed 方法显示软删除he可用的所有的数据记录
        //when方法如果参数1条件成功，则调用回调方法
        return Admin::when($st,function ($query) use ($st,$et){
           $st = date('Y-m-d 00:00:00',strtotime($st));
           $et = date('Y-m-d 23:59:59',strtotime($et));
           $query->whereBetween('created_at',[$st,$et]);
        })->when($kw,function ($query) use ($kw){
            $query->where('username','like',"%{$kw}%");
        })->orderBy('id','desc')->withTrashed()->paginate($pagesize);

    }

}