<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ApiuserRequest;
use App\Models\Apiuser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ApiuserController extends BaseController {
    // 列表
    public function index() {
        $data = Apiuser::paginate($this->pagesize);
        return view('admin.apiuser.index', compact('data'));
    }

    // 添加显示
    public function create() {
        return view('admin.apiuser.create');
    }

    // 添加处理
    public function store(ApiuserRequest $request) {
       Apiuser::create($request->except('_token'));

        return ['status' => 0, 'msg' => '添加接口账号成功', 'url' => route('admin.apiuser.index')];
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Apiuser $apiuser
     * @return \Illuminate\Http\Response
     */
    public function show(Apiuser $apiuser) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Apiuser $apiuser
     * @return \Illuminate\Http\Response
     */
    public function edit(Apiuser $apiuser) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Apiuser $apiuser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apiuser $apiuser) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Apiuser $apiuser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apiuser $apiuser) {
        //
    }
}
