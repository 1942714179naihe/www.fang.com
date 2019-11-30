<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\MyValidateException;
use App\Http\Resources\FavResourceCollection;
use App\Models\Fav;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FavController extends Controller
{
    public function fav(Request $request)
    {
        try{
        $data = $this->validate($request,[
            'openid' => 'required',
            'fang_id' =>'required|numeric',
            'add'=>'required|numeric'
        ]);

    }catch (\Exception $exception){
        throw new MyValidateException('验证错了狗子怪',3);
    }

        $add = $data['add'];
        unset($data['add']);
        $msg = '';

        $model = Fav::where($data)->first();
        if ($add > 0){
            //判读是取消还是添加0 取消 ，大于0 添加
            if (!$model){
                //数据不存在则添加，存在不执行
                Fav::create($data);
            }
            $msg = '添加成功';
        }else {
            if($model){
                $model->forceDelete();
            }
            $msg='取消成功';
        }
        return ['status'=>0,'msg'=>$msg];
    }

    //openid用户是否收藏
    public function isfav(Request $request)
    {
        try{
            $data = $this->validate($request,[
                'openid' => 'required',
                'fang_id' =>'required|numeric',

            ]);

        }catch (\Exception $exception){
            throw new MyValidateException('验证错了狗子怪',3);
        }

        $model = Fav::where($data)->first();
        if ($model){
            return ['status'=>0,'msg'=>'取消收藏','data'=>1];
        }
        return ['status'=>0,'msg'=>'添加收藏','data'=>0];
    }

    public function list(Request $request)
    {
        try{
            $data = $this->validate($request,[
                'openid' => 'required'


            ]);

        }catch (\Exception $exception){
            throw new MyValidateException('验证错了狗子怪',3);
        }
        $data = Fav::where('openid',$data['openid'])->orderBy('updated_at','asc')->paginate(10);
        return ['status'=>0,'msg'=>'ok','data'=>new FavResourceCollection($data)];
    }
}
