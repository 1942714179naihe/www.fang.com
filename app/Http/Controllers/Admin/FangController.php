<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fang;
use App\Models\Fangattr;
use App\Models\FangOwner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Http\Requests\FangRequest;

//网络请求
use GuzzleHttp\Client;
class FangController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $data = Fang::with('fangowner')->paginate($this->pagesize);

        return view('admin.fang.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //添加显示
    public function create()
    {

        //初始获取省份信息
        $pData = $this->getCity();

        //房源属性
        $attrData =Fangattr::all()->toArray();

//        dump($attrData);die;
        $attrData = subTree2($attrData);
        //读取房东
        $fData = FangOwner::all();
        return view('admin.fang.create',compact('pData','attrData','fData'));
    }
    //获取城市
    public function getCity($pid =0)
    {
       $pid = $pid === 0 ? request()->get('pid',0) : $pid;
        //地区三级联动
        return City::where('pid',$pid)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //添加处理
    public function store(FangRequest $request)
    {
        $data = $request->except(['file', '_token']);
        dump($data);
        Fang::create($data);
        return redirect(route('admin.fang.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fang  $fang
     * @return \Illuminate\Http\Response
     */
    public function show(Fang $fang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fang  $fang
     * @return \Illuminate\Http\Response
     */
    //修改显示
    public function edit(Fang $fang)
    {
        //初始化获取省份信息
        $pData = $this->getCity();

        $cData = $this->getCity($fang->fang_province);

        $rData = $this->getCity($fang->fang_city);

        //房源属性
        $attrData = Fangattr::all()->toArray();
        //字段名创建多层数组
        $attrData = subTree2($attrData);
        //读取房东
        $fData = FangOwner::all();

        return view('admin.fang.edit',compact('fang','pData','cData','rData','attrData','fData'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fang  $fang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fang $fang)
    {
        $fang->update($request->except(['_token','_method','file','fang_addr2']));
        return redirect(route('admin.fang.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fang  $fang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fang $fang)
    {
        //
    }
}
