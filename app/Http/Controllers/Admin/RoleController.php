<?php

namespace App\Http\Controllers\Admin;

use App\Models\Node;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services\RoleService;

class RoleController extends BaseController
{
    //列表
    public function index(Request $request)
    {
//        $data = Role::paginate($this->pagesize);
        $data = (new RoleService())->getList($request,$this->pagesize);

        return view('admin.role.index',compact('data'));

    }

    //添加显示
    public function create()
    {
        //读取全部权限一树桩的数组返回
        $nodeData = Node::all()->toArray();

        $nodeData = treeLevel($nodeData);
        return view('admin.role.create',compact('nodeData'));
    }

    //添加处理
    public function store(Request $request)
    {
        $data = $this->validate($request,[
            'name'=>'required'
        ]);
        $model =Role::create($data);
        $model->nodes()->sync($request->get('node_ids'));

//        Role::create($data);
        return redirect(route('admin.role.index'))->with('success','添加角色成功');
    }

    //修改显示
    public function edit(Role $role)
    {
        //转为数组
        $nodeData = Node::all()->toArray();

        $nodeData =treeLevel($nodeData);

        $role_node = $role->nodes()->pluck('id')->toArray();
        return view('admin.role.edit',compact('role','nodeData','role_node'));

    }

    //修改处理
    public function update(Request $request,Role $role)
    {
        $data =$this->validate($request,[
            'name'=>'required|unique:roles,name,'.$role->id
        ]);
        $role->update($data);
        $role->nodes()->sync($request->get('node_ids'));

        return redirect(route('admin.role.index'))->with('success','修改角色成功');
    }
}
