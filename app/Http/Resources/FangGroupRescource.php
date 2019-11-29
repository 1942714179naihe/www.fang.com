<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FangGroupRescource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    //d单模型对应指定输出
    public function toArray($request)
    {
       //可以输出的字段与数据表中的不一致，安全！！
        return [
            'id' =>$this->id,
            'gname' => $this->name,
            'pic' => $this->icon
        ];
    }
}
