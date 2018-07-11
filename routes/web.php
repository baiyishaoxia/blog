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

    //文章(资源  搜索  移动到回收站)
    //回收站列表
    Route::get('article/recycleList','ArticleController@getRecycleList');
    //还原
    Route::post('article/restore','ArticleController@postRestore');
    //保存排序
    Route::post('article/save','ArticleController@postSave');
    //彻底删除
    Route::post('article/del','ArticleController@postDel');
    //定义资源(其中包括 index create store edit update destroy 方法)
    Route::resource('article','ArticleController');
    //自定义post方法,将覆盖 资源中的store
    Route::post('article','ArticleController@index');
    Route::post('article/softdel','ArticleController@postSoftDel');
    //该方法本应是资源里自带的,由于自定义搜索与该方法冲突,因此重新定义
    Route::post('article/store','ArticleController@store');

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



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=>['web'],'prefix'=>'home','namespace'=>'Home'],function () {
    Route::any('/upload', 'ArticleController@upload');
    Route::any('/mail', 'ArticleController@mail');

    Route::get('cache1','ArticleController@cache1');
    Route::get('cache2','ArticleController@cache2');

    Route::get('error','ArticleController@error');
    Route::get('log','ArticleController@log');
    Route::get('queue','ArticleController@queue');
});