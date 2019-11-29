<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
// 软删除  导入类
use Illuminate\Database\Eloquent\SoftDeletes;


class Apiuser extends Authenticatable  {
    use SoftDeletes;
    // 指定软删除字段 deleted_at 数据表中的字段
    protected $dates = ['deleted_at'];

    // 密码
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
        // 给字段添加一个明文的密码
        $this->attributes['plainpass'] = $value;
    }

    //修改
    public function editBtn(string  $routeName)
    {
        if ($this->checkAuth($routeName)){
            $arr['start'] = request()->get('start') ?? 0;
            //字段在表格的索引
            $arr['field'] = request()->get('order')[0]['column'];
            $arr['order'] = request()->get('order')[0]['dir'];
            //数组转成字符串
            $params = http_build_query($arr);

            //生成url地址
            $url = route($routeName,$this);
            if (stristr($url,'?')){
                $url = $url . '&' . $params;
            }else {
                $url = $url . '?' . $params;
            }

            return '<a href=" '.$url .'" class="label label-secondary radius">修改</a>';

        }
        return '';
    }

    //删除
    public function delBtn(string  $routeName)
    {
        if ($this->checkAuth($routeName)){
            return '<a href="'.route($routeName,$this).'" class="label label-danger radius deluser">删除</a>';

        }
        return '';
    }

    private function checkAuth(string  $routeName){
//    在中间键中得到当前角色持有的权限列表
        $auths = request()->auths;
        //权限判断
        if(!in_array($routeName,$auths)&& request()->username !='admin'){
            return false;
        }
        return true;
    }

    // create添加时所用    黑名单
    protected $guarded = [];
}
