<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Renting extends Base {

    // 给接口所用的地址
    public function getAvatarAttribute() {
        if (stristr($this->attributes['avatar'],'http')){
            return $this->attributes['avatar'];
        }
        return self::$host . $this->attributes['avatar'];
    }
    // 身份图片显示
    public function getCardImgAttribute() {
        $imglist = [];
        if (strstr($this->attributes['card_img'], '#')) {
            $imglist = explode('#', $this->attributes['card_img']);
            $imglist = array_map(function ($item) {
                return self::$host . '/' . $item;
            }, $imglist);
            return $imglist;
        }
        return $imglist;
    }
}
