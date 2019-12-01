<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\FangGroupRescourceCollection;
use App\Http\Resources\FangRescourceCollection;
use  App\Models\Fang;
use App\Models\Fangattr;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FangController extends Controller
{
    public function recommend(Request $request)
    {
        $data =Fang::where('is_recommend',1)->orderBy('updated_at','desc')->limit(5)->get(['id','fang_name','fang_pic']);
        return ['status' => 0,'msg' => '获取成功的狗子','data' =>$data];
    }

    //住房小猪
    public function group(Request $request)
    {
        //字段名称
        $where['field_name'] = 'fang_group';

        //上级id号
        $pid = Fangattr::where($where)->value('id');

        $data = Fangattr::where('pid',$pid)->orderBy('updated_at','desc')->limit(4)->get(['id','name','icon']);

        return ['status'=>0,'msg'=>'完全ojbk狗子','data' => new FangGroupRescourceCollection($data)];
    }
    //房源列表
    public function fanglist(Request $request)
    {
//        if (!empty($request->get('kw'))){
//            return $this->search($request);
//        }

        $data = Fang::orderBy('id','asc')->paginate(10);
        return ['status' => 0,'msg' => 'ok','data'=>new  FangRescourceCollection($data)];
    }
    //房源详情
    public function detail(Request $request)
    {
        $data = Fang::with('fangowner:id,name,phone')->where('id',$request->get('id'))->first();

        $data['fang_config'] = explode(',',$data['fang_config']);
        $data['fang_config'] =Fangattr::whereIn('id',$data['fang_config'])->pluck('name');
        $data['fang_direction'] = Fangattr::where('id',$data['fang_direction'])->value('name');

        return ['status'=>0,'msg'=>'完全ojbk狗子','data'=>$data];
    }

    //房源属性列表
    public function fangAttr(Request $request)
    {
        $attrData = Fangattr::all()->toArray();

        $attrData = subTree2($attrData);

        return['status'=>0,'msg'=>'完全ojbk','data'=>$attrData];
    }

    //es搜索
    public function search(Request $request)
    {
        //关键词的获取
        $kw = $request->get('kw');

        if (empty($kw)){
            $data = Fang::orderBy('id','asc')->paginate(10);
            return ['status'=>0,'msg'=>'完全OK','data'=>new FangRescourceCollection($data)];
        }

        //kw有数据
        $client = ClientBuilder::create()->setHosts(config('es.hosts'))->build();
        $params = [
            //索引名称
            'index' => 'fangs',
            //查询条件
            'body' =>[
                'query' =>[
                    'match' => [
                        'desn' => [
                            'query' => $kw
                        ]
                    ]
                ]
            ]
        ];

        $ret = $client->search($params);

        $total = $ret['hits']['total']['value'];

        if ($total ==0){
            return ['status' => 6,'msg'=>'没有查到数据哦','data'=>[]];
        }

        //二维数组中获取指定下标的值，返回一维数组
        $data = array_column($ret['hits']['hits'],'_id');
        $data = Fang::whereIn('id',$data)->orderBy('id','asc')->paginate(10);

        return ['status'=>0,'msg'=>'完全OK','data'=>new  FangRescourceCollection($data)];



    }


}
