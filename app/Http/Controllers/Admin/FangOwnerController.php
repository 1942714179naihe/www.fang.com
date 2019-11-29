<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FangOwnerRequest;
use App\Models\FangOwner;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FangownerExport;

class FangOwnerController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //房东列表
    public function index()
    {
        $excelpath = public_path('/uploads/fangownerexcel/fangowner.xlsx');
        //判断文件是否纯在
        $isshow = file_exists($excelpath) ? true : false;
        //排序和分页
        $data =FangOwner::orderBy('id','desc')->paginate($this->pagesize);
        return view('admin.fangowner.index')->with(['data'=>$data,'isshow'=>$isshow]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //添加显示
    public function create()
    {
        return view('admin.fangowner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //添加处理
    public function store(FangOwnerRequest $request)
    {
        $data =$request->except(['file','_token']);
        FangOwner::create($data);
        return redirect(route('admin.fangowner.index'));
    }

    //导出房东Excel
    public function export()
    {
        //导出并下载
//        return Excel::download(new FangownerExport(),'fangowner.xlsx');

//        导出并保存到服务器指定磁盘中
        $obj = Excel::store(new FangownerExport(),'fangowner.xlsx','fangownerexcel');

        //返回true/falas
        dump($obj);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FangOwner  $fangOwner
     * @return \Illuminate\Http\Response
     */
    //c查看身份证图片
    public function show(FangOwner $fangowner)
    {
        $pics = $fangowner->pic;
        $picList = explode('#',$pics);
        if (count($picList) <= 1){
            return ['status' => 1,'msg' => '没有图片','data' => []];
        }
        //去除第一个元素
        array_shift($picList);
        return ['status' => 0,'msg'=>'成功','data'=>$picList];

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FangOwner  $fangOwner
     * @return \Illuminate\Http\Response
     */
    public function edit(FangOwner $fangOwner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FangOwner  $fangOwner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FangOwner $fangOwner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FangOwner  $fangOwner
     * @return \Illuminate\Http\Response
     */
    public function destroy(FangOwner $fangOwner)
    {
        //
    }
}
