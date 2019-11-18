<?php
// 后台路由
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    // 后台登录显示
    Route::get('login', 'LoginController@index')->name('login');
    // 后台登录处理
    Route::post('login', 'LoginController@login')->name('login');


    Route::group(['middleware' => ['checkadmin']],function(){
        //后台首页
        Route::get('index','IndexController@index')->name('index');
        //欢迎页
        Route::get('welcome','IndexController@welcome')->name('welcome');

        //退出登录
        Route::get('logout','IndexController@logout')->name('logout');


        //用户列表
        Route::get('user/index','AdminController@index')->name('user.index');

        //添加用户显示
        Route::get('user/create','AdminController@create')->name('user.create');

        //添加用户操作
        Route::post('user/create','AdminController@store')->name('user.store');


        //修改用户显示
        Route::get('user/edit/{id}','AdminController@edit')->name('user.edit');


        //修改用户修改
        Route::put('user/edit/{id}','AdminController@update')->name('user.update');


        //个人信息展示
        Route::get('user/own/{id}','AdminController@own')->name('user.own');
        //个人信息更改
        Route::put('user/own/{id}','AdminController@ownedit')->name('user.ownedit');

        //删除用户
        Route::delete('user/destroy/{id}','AdminController@destroy')->name('user.destroy');
        //全选删除
        Route::delete('user/delall','AdminController@delall')->name('user.delall');

        //恢复
        Route::get('user/restore','AdminController@restore')->name('user.restore');


        //定义志愿路由
        Route::resource('role','RoleController');


        //权限管理
        Route::resource('node','NodeController');


        //路由的定义规则，越靠前越精准
        Route::post('article/upfile','ArticleController@upfile')->name('article.upfile');
        //文章的封面图片删除
        Route::get('article/delfile','ArticleController@delfile')->name('article.delfile');
        //文章管理
        Route::resource('article','ArticleController');

    });










});

