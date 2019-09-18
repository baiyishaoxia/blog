<?php

/*
|--------------------------------------------------------------------------
| 接口 Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware'=>['web'],'namespace'=>'Admin'],function () {
    //接口测试
    Route::post('users','AppController@postCheckUser');
    //获取文章
    Route::get('article','AppController@getArticle');

});
//Home相关Api接口
Route::group(['namespace'=>'Api'],function () {
    Route::get('/typing/score','IndexNavController@getUserScore');//打字成绩
    Route::post('/typing/score','IndexNavController@postUserScore');//提交打字
});