<?php

namespace App\Http\Controllers\Admin;

use App\Models\FangOwner;
use App\Models\Notice;
use App\Models\Renting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NoticeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Fenye获取通知数据
        $data = Notice::with(['fangowner','renting'])->paginate($this->pagesize);
        return view('admin.notice.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        // 获取数据
        if ($request->ajax()) {
            // 房东数据
            $fdata = FangOwner::all();
//            dump($fdata);die();
            // 租客数据
            $rdata = Renting::all();
            return [$fdata, $rdata];
        }

        return view('admin.notice.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        try {
            $this->validate($request, [
                'cnt' => 'required'
            ]);
            // 入库操作
            Notice::create($request->except('_token'));
            return ['status' => 0, 'msg' => '成功', 'url' => route('admin.notice.index')];
        } catch (\Exception $exception) {  // 验证有异常
            return ['status' => 1, 'msg' => '验证异常', 'data' => $exception->validator->messages()];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function show(Notice $notice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function edit(Notice $notice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notice $notice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notice $notice)
    {
        //
    }
}
