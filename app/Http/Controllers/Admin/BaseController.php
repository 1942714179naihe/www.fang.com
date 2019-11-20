<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    //分页数
    protected  $pagesize = 1;

    public function __construct()
    {
        $this->pagesize = env('PAGESIZE');
    }

    //s文件上传
    public function upfile(Request $request)
    {
        //上传节点名称
        $nodeName = $request->get('node');

        //获取上传表单文件或名称对应的对象
        $file = $request->file('file');

        //上传

        $uri = $file->store('',$nodeName);
        return ['status' => 0,'url' => '/uploads/'.$nodeName.'/'.$uri];

    }
}
