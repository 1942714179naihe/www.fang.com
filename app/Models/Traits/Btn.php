<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2019/11/14
 * Time: 21:44
 */

namespace App\Models\Traits;


trait Btn
{
private function checkAuth(string  $routeName){
//    在中间键中得到当前角色持有的权限列表,解决前后端公用异常
    $auths = request()->auths ?? [];
    //权限判断
    if(!in_array($routeName,$auths)&& request()->username !='admin'){
        return false;
    }
    return true;
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

    //显示按钮，根据ID来显示按钮
    public function showBtn(string $routeName)
    {
        if ($this->checkAuth($routeName)){
            return '<a href="'.route($routeName,$this).'" class="label label-success radius showBtn">查看</a>';
        }
        return '';
    }

}