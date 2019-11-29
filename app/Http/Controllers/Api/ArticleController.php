<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\MyValidateException;
use App\Models\Article;
use App\Models\ArticleCount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    //列表
    public function index()
    {
        //获得的字段数据
        $fields = [
            'id',
            'title',
            'desc',
            'pic',
            'created_at'
        ];

        $data = Article::orderBy('id','asc')->select($fields)->paginate(env('PAGESIZE'));
//        dump($data);die;
        return ['status'=>0,'data'=>$data,'msg'=>'成功辣狗子'];
    }

    public function show(Article $article)
    {
        return ['status' => 0,'data'=>$article,'msg'=>'完全ojbk'];
    }

    public function history(Request $request)
    {
        try{
            $data = $this->validate($request,[
                'openid' => 'required',
//                'art_id' => 'required|numeric'
            ]);
        }catch (\Exception $exception){
            throw new MyValidateException('验证异常辣狗子怪',3);
        }

        //判断哦盆地和文章id当天日期是否存在，在则修改，不在则添加一条记录
        $data['vdt'] = date('Y-m-d');

        $model = ArticleCount::where($data)->first();
        if (!$model){
            $data['click'] =1;
            $model = ArticleCount::create($data);
        }else {
            $model->increment('click');
        }
        return response()->json(['status' => 0,'msg'=>'记录成功','data'=>$model->click],201);
    }
}
