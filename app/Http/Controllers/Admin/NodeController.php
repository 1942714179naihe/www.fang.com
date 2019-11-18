<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  App\Models\Node;

class NodeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //权限列表
        $data = Node::all()->toArray();
        $data = treeLevel($data);
        return view('admin.node.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //添加权限显示
    public function create()
    {
        //读取 pid=0的数据   pluck取一列数据
        //参数1 数组的值
        //参数2 数组的下标
        $data = Node::where('pid',0)->pluck('name','id')->toArray();

        // 在数组顶部添加一个值
        $data[0] = '==顶级==';
        ksort($data);
        return view('admin.node.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //添加处理
    public function store(Request $request)
    {
        //表单验证
        $this->validate($request,[
            'name'=>'required'
        ]);
        //添加数据入库
        Node::create($request->except(['_token']));
        return redirect(route('admin.node.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
