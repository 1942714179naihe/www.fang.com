<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\MyValidateException;
use App\Models\Notice;
use App\Models\Renting;
use Elasticsearch\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use QL\QueryList;

class NoticeController extends Controller
{
    //表单验证

    public function index(Request $request)
    {
        try{
            $data = $this->validate($request,[
                'openid' => 'required'
            ]);
        }catch (\Exception $exception){
            throw new  MyValidateException('验证异常',3);
        }

        $renting_id = Renting::where($data)->value('id');

//        return $renting_id;

        $data = Notice::with('fangowner')->where('renting_id',$renting_id)->paginate(env('PAGESIZE'));

        return ['status' => 0,'msg' => '可以的狗子','data'=>$data];
    }

    public function sipder()
    {

    //Danxiancheng

//     $data = QueryList::Query('http://desk.zol.com.cn/meinv/xingganmeinv/',[
//         "src" =>['.photo-list-padding .pic img','src','',function($item){
//         return '你好呀-' . $item;

//             //图片名称
//             $filename =basename($item);
//             //保存到本地路劲和文件名称
//             $filepath = public_path('img/' . $filename);
//
//             //请求图片资源
//             $client = new Client(['timout' => 5,'verify' =>false]);
//             $reponse = $client->get($item);
//
//             //写入本地
//             file_put_contents($filepath,$reponse->getBody());
//             return '/img/' . $filename;
//         }]
//     ])->getData();
//        dump($data);



        //多线程扩展
        QueryList::run('Multi',[
            'list' =>[
                'https://news.ke.com/bj/baike/033/pg1/',
                'https://news.ke.com/bj/baike/033/pg2/',
                'https://news.ke.com/bj/baike/033/pg3/',
            ],
            //线程curl的相关配置
            'curl' => [
                'opt' => array(
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_AUTOREFERER => true
                ),

                //设置线程数
                'maxThread' => 100,
                'maxTry' => 10
            ],
            'success' => function($ret){
                    //采集规则
                $reg = [
                    'title' => ['.summary','text']
                ];
                $ql = QueryList::Query($ret['content'],$reg);
                $data = $ql->getData();
                dump($data);
            }
        ]);
    }
    
}
