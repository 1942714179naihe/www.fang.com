<?php

// 接口

Route::group(['prefix'=>'v1','namespace'=>'Api'],function (){

    // 实现小程序的登录
    Route::post('wxlogin','WxloginController@login');

    // 小程序授权
    Route::post('userinfo','WxloginController@userinfo');

    // 图片上传
    Route::post('upfile','RentingController@upfile');
    // 租客信息接受处理
    Route::put('editrenting','RentingController@editrenting');

    // 以openid来返回用户信息
    Route::get('renting','RentingController@show');


    //看房通知
    Route::get('notice','NoticeController@index');
    Route::get('sipder','NoticeController@sipder');


    //记录用户浏览次数
    Route::post('articles/history','ArticleController@history');
    //文章管理
    Route::get('articles/{article}','ArticleController@show');
    Route::get('articles','ArticleController@index');

    //房源推荐接口
    Route::get('fang/recommend','FangController@recommend');

    //住房小猪
    Route::get('fang/group','FangController@group');

    //房源列表
    Route::get('fang/fanglist','FangController@fanglist');

    //房源列表
    Route::get('fang/detail','FangController@detail');

    //收藏记录
    Route::get('fang/fav','FavController@fav');

    //是否收藏
    Route::get('fang/isfav','FavController@isfav');

    // 收藏记录
    Route::get('fav/list', 'FavController@list');

    // 看房
    Route::get('fang/can', function () {
        return ['statuts' => 0, 'msg' => '看房'];
    });

    // 房源属性
    Route::get('fang/attr','FangController@fangAttr');

});
