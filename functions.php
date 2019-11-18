<?php

function staticAdminWeb(){
    return '/admin/';
}

function treeLevel(array $data,int  $pid = 0 ,string  $html = '--',int  $level =0){
    static $arr = [];
    foreach ($data as $val) {
        if ($pid == $val['pid']){
            $val['html'] = str_repeat($html,$level *2);
            $val['level'] = $level + 1 ;
            $arr[] = $val;
            treeLevel($data,$val['id'],$html,$val['level']);
        }
    }
    return $arr;
}


//递归多成数组

function subTree(array $data,int $pid =0){
    $arr = [];
    foreach ($data as $val){
        if ($pid == $val['pid']){
            $val['sub'] = subTree($data,$val['id']);
            $arr[] = $val;
        }
    }
    return $arr;
}