<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/13
 * Time: 16:21
 */
Route::group(['namespace'=>'Home'],function () {
    Route::get('/',function (){return view('home.index');}); //首页导航
    Route::get('/typing',function (){return view('home.index_nav.typing');}); //打字测试

    Route::get('/index','IndexController@getIndex'); //首页
});