<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Services\AdminService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//引入邮件类
use Mail;
use Illuminate\Mail\Message;

class AdminController extends BaseController
{
    //列表
    public  function  index(Request $request){
//        echo  $this-> pagesize;

//        $data  = Admin::orderBy('id','desc')->paginate($this->pagesize);

        $data = (new AdminService())->getList($request,$this->pagesize);

        return view('admin.admin.index',compact('data'));


    }
    //添加用户显示
    public function create(){
        return view('admin.admin.create');
    }
//    添加用户处理
    public function store(Request $request)
    {
        $this->validate($request,[
            'username' => 'required|unique:admins,username',
            'truename' => 'required',
            'email' => 'nullable|email',
            'password' => 'required|confirmed'
        ]);
        //获取数据
        $data = $request->except(['_token','password_confirmation']);

        //验证通过添加到数据表中
        $model = Admin::create($data);

         //发送邮件通知
         //        Mail::raw('添加用户成功',function (Message $message){
    //            //主题
    //            $message->subject('添加用户通知');
    //            //发给谁
    //            $message->to('1942714179@qq.com','狗子');
    //        });

        //发送html邮件
        Mail::send('admin.mailer.adduser',compact('model'),function (Message $message) use ($model){
            //主题
            $message->subject('添加用户通知');
            //发给谁
            $message->to($model->email,$model->truename);
        });


        return redirect(route('admin.user.index'))->with('success','添加用户【'.$model->truename.'】成功');
    }

    //修改显示
    public function edit(int $id)
    {
        $data = Admin::find($id);
        return view('admin.admin.edit',compact('data'));
    }

    public function update(Request $request,int $id)
    {
        //表单验证
       $data=$this->validate($request,[
            'username' => 'required|unique:admins,username,'.$id,
            'truename' => 'required',
            'email' => 'nullable|email',
            'password' => 'nullable|confirmed',
            'phone'     => 'nullable|min:6',
           'sex'    => 'in:先生,女士'
        ]);

       if(!$data['password']){
           unset($data['password']);
       }

       //修改
        Admin::where('id',$id)->update($data);

       return redirect(route('admin.user.index'))->with('success','修改用户【'.$data['truename'].'】成功');

    }

    //个人信息展示
    public function  own(int $id){
        $data = Admin::find($id);
        return view('admin.own.index',compact('data'));
    }

    //个人信息修改
    public function ownedit(Request $request ,int $id)
    {
        $data = $this->validate($request,[
            'truename' => 'required',
            'email' => 'nullable|email',
            'password' => 'required|confirmed',
            'phone'     => 'nullable|min:6',
            'sex'    => 'in:先生,女士'
        ]);
        $data['password'] = bcrypt($data['password']);
        Admin::where('id',$id)->update($data);

        return redirect(route('admin.login'))->with('success','修改成功,请重新登录');
    }

    //删除用户
    public function  destroy(int $id)
    {
        Admin::destroy($id);

        return ['status' => 0,'msg' => '删除成功'];

    }

    //全选删除
    public function delall(Request $request)
    {
        $ids = $request->get('ids');

        Admin::destroy($ids);
        return['status' => 0,'msg' =>'删除成功'];
    }

    //恢复用户
    public function restore(Request $request)
    {
        $id = $request->get('id');

        //查找到此用户
        Admin::where('id',$id)->onlyTrashed()->restore();

        return ['status' => 0,'msg' => '成功'];
    }
}
