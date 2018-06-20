<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//测试数据库连接
Route::get('/test', 'IndexController@index');
//验证码页
Route::get('/getVerify', 'IndexController@getVerify');
//生成验证码
Route::get('test/getCreateverify/{tmp}', 'IndexController@getCreateverify');
//验证码验证
Route::post('test/getCode','IndexController@getCode');

Route::any('admin/crypt', 'Admin\LoginController@crypt');
//后台登陆
Route::any('admin/login', 'Admin\LoginController@login');
//验证码
Route::get('admin/code', 'Admin\LoginController@code');
Route::get('admin/getcode', 'Admin\LoginController@getcode');
//后台主页
//Route::any('admin/index', 'Admin\IndexController@index');
//Route::any('admin/info', 'Admin\IndexController@info');

//路由分组
Route::group(['middleware'=>['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'],function (){
    Route::get('index', 'IndexController@index');
    Route::get('info', 'IndexController@info');
    //退出登陆
    Route::get('quit', 'LoginController@quit');
    //修改密码
    Route::any('pass','IndexController@pass');
    //分类
    Route::resource('category','CategoryController');
    Route::post('cate/changeOrder','CategoryController@changeOrder');

    //文章
    Route::resource('article','ArticleController');

    //图片上传
    Route::any('upload','CommonController@upload');

    //友情链接
    Route::resource('links','LinksController');
    //回收站、还原、逻辑删除、批量删除、批量还原、排序
    Route::get('recycle','LinksController@recycle');
    Route::get('restore/{link_id}','LinksController@restore');
    Route::get('links/del/{link_id}','LinksController@del');
    Route::post('delAll','LinksController@delLinkAll');
    Route::post('restoreAll','LinksController@restoreAll');
    Route::post('link/changeOrder','LinksController@changeOrder');
});


