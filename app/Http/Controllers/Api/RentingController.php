<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\LoginException;
use App\Exceptions\MyValidateException;
use App\Models\Renting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RentingController extends Controller {
    // 图片上传
    public function upfile(Request $request) {
        $file = $request->file('cardimg');
        $info = $file->store('card', 'renting');

        return ['statuts' => 0, 'path' => '/uploads/renting/' . $info];
    }

    // 根据openid来修改用户基本信息
    public function editrenting(Request $request) {
        // 表单验证
        try {
            $this->validate($request, [
                'openid' => 'required'
            ]);
        } catch (\Exception $exception) {
            throw new MyValidateException('验证异常', 3);
        }
        // 获取所有的数据
        $data = $request->all();
        // 根据openid来进行数据查询 如果有则返回对应的模型对象
        $model = Renting::where('openid', $data['openid'])->first();
        if (!$model) throw new LoginException('没有查询到此信息', 4);

        $model->update($data);
        return ['status' => 0, 'msg' => '更新用户信息成功'];
    }

    // 以openid来返回用户信息
    public function show(Request $request) {
        // 表单验证
        try {
            $data = $this->validate($request, [
                'openid' => 'required'
            ]);
        } catch (\Exception $exception) {
            throw new MyValidateException('验证异常', 3);
        }

        // 根据openid来进行数据查询 如果有则返回对应的模型对象
        $model = Renting::where('openid', $data['openid'])->first();
        if (!$model) throw new LoginException('没有查询到此信息', 4);

        return ['status' => 0, 'msg' => '成功', 'data' => $model];
    }
}
