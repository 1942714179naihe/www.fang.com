<?php

namespace App\Observers;

use App\Models\Fang;
use GuzzleHttp\Client;

class FangObserver {
    // 添加之前得到地址转化为经纬度
    public function creating(Fang $fang) {
        $geo = $this->geo();
        $fang->longitude = $geo[0];
        $fang->latitude = $geo[1];
        $fang->fang_config = implode(',', request()->get('fang_config'));
    }

    // 添加成功事件
    public function created(Fang $fang){
//        $hosts = config('es.hosts');
//        $client = \Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();
//        // 写文档
//        $params = [
//            // 索引名称
//            'index' => 'fangs',
//            // 可以不定义，它会自动给生成
//            'id' => $fang->id,
//            // 文档字段内容
//            'body' => [
//                'xiaoqu' => $fang->fang_xiaoqu,
//                'desn' => $fang->fang_desn,
//            ],
//        ];
//        $client->index($params);
    }

    // 修改之前
    public function updating(Fang $fang){
        // 地址和上次修改的地址一致可以不进行更新经纬度
        if(request()->get('fang_addr2') != request()->get('fang_addr')){
            $geo = $this->geo();
            $fang->longitude = $geo[0];
            $fang->latitude = $geo[1];
        }
        $fang->fang_config = implode(',', request()->get('fang_config'));
    }


    public function updated(Fang $fang) {
        $this->created($fang);
    }

    // 获取经纬度
    private function geo(){
        // 把地址转为经纬度 请求地址
        $url = sprintf(config('geo.url'), request()->get('fang_addr'));

        $client = new Client(['timeout' => 5, 'verify' => false]);
        $response = $client->get($url);


        $json = (string)$response->getBody();
        $arr = json_decode($json, true)['geocodes'];

        $longitude = $latitude = 0;
        if (count($arr) > 0) {
            $location = $arr[0]['location'];
            // 解析赋值
            [$longitude, $latitude] = explode(',', $location);
        }

        return [$longitude, $latitude];
    }


}
