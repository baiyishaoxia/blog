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
//导出数据
Route::get('link/export','Common\ExcelController@getExportLink');
//生成二维码
Route::get('create/qrcode','Common\QrcodeImgController@getAjaxQrcode');
//后台主页
//Route::any('admin/index', 'Admin\IndexController@index');
//Route::any('admin/info', 'Admin\IndexController@info');

//后台admin路由分组,会走admin.login中间件验证
Route::group(['middleware'=>['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'],function (){
    Route::get('index', 'IndexController@index');
    Route::get('info', 'IndexController@info');
    //退出登陆
    Route::get('quit', 'LoginController@quit');
    //修改密码
    Route::any('pass','IndexController@pass');
    //清空缓存
    Route::get('clear','IndexController@getClear');
    //授权登录
    Route::get('auth_login/{admin_id}/{super_id?}','LoginController@getAuthorizedLogin');

    //分类
    Route::resource('category','CategoryController');
    Route::post('cate/changeOrder','CategoryController@changeOrder');
    Route::post('cate/delAll','CategoryController@postDel');

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
    //回收站、还原、逻辑删除、批量删除、批量还原、排序
    Route::get('links/recycle','LinksController@recycle');
    Route::get('links/restore/{link_id}','LinksController@restore');
    Route::get('links/del/{link_id}','LinksController@del');
    Route::post('links/delAll','LinksController@delLinkAll');
    Route::post('links/restoreAll','LinksController@restoreAll');
    Route::post('link/changeOrder','LinksController@changeOrder');
    //by 资源路由
    Route::resource('links','LinksController');

    //图片分类
    Route::get('image/list','ImagesListController@index');
    Route::get('image/list/create/{Pid?}','ImagesListController@getCreate');
    Route::post('image/list/create','ImagesListController@postCreate');
    Route::get('image/list/edit/{id}','ImagesListController@getEdit');
    Route::post('image/list/edit','ImagesListController@postEdit');
    Route::post('image/list/delAll','ImagesListController@postDel');
    Route::post('image/list/save','ImagesListController@postSave');
    //图片列表
    Route::get('images/content','ImagesContentController@index');
    Route::get('image/content/create','ImagesContentController@getCreate');
    Route::post('image/content/create','ImagesContentController@postCreate');
    Route::post('image/content/delAll','ImagesContentController@postDel');
    Route::get('image/content/del','ImagesContentController@del');

    //region   工具类        tang
    Route::get('tools/list','ToolsController@getIndex');
    //by 操作
    Route::get('tools/list/create/{parent_id?}','ToolsController@getCreate');
    Route::post('tools/list/create','ToolsController@postCreate');
    Route::get('tools/list/edit/{id}','ToolsController@getEdit');
    Route::post('tools/list/edit','ToolsController@postEdit');
    Route::post('tools/list/save','ToolsController@postSave');
    Route::post('tools/list/delAll','ToolsController@postDel');
    Route::get('tools/list/top/{id}','ToolsController@getTop');
    Route::get('tools/list/red/{id}','ToolsController@getRed');
    Route::get('tools/list/hot/{id}','ToolsController@getHot');
    Route::get('tools/list/slide/{id}','ToolsController@getSlide');
    Route::post('tools/list/softdel','ToolsController@postSoftDel');
    Route::get('tools/list/recycle/list','ToolsController@getRecycleList');
    Route::post('tools/list/recycle/del','ToolsController@postRecycleDel');
    Route::post('tools/list/recycle/restore','ToolsController@postRestore');
    //endregion


    //region   工具类 - 内容管理        tang
    Route::get('tools/content','ToolsContentController@getIndex');
    Route::get('tools/content/create','ToolsContentController@getCreate');
    Route::post('tools/content/create','ToolsContentController@postCreate');
    Route::get('tools/content/edit/{id}','ToolsContentController@getEdit');
    Route::post('tools/content/edit','ToolsContentController@postEdit');
    Route::get('tools/content/top/{id}','ToolsContentController@getTop');
    Route::get('tools/content/red/{id}','ToolsContentController@getRed');
    Route::get('tools/content/hot/{id}','ToolsContentController@getHot');
    Route::get('tools/content/slide/{id}','ToolsContentController@getSlide');
    Route::get('tools/content/download/{id}','ToolsContentController@getDownLoad');
    Route::post('tools/content/save','ToolsContentController@postSave');
    Route::post('tools/content/del','ToolsContentController@postDel');
    Route::post('tools/content/softdel','ToolsContentController@postSoftDel');
    Route::get('tools/content/recycle/list','ToolsContentController@getRecycleList');
    Route::post('tools/content/restore','ToolsContentController@postRestore');
    //endregion

    //region   活动管理        tang
    Route::get('tmp/list/{status?}','ArticleTmpController@getIndex');
    Route::get('tmp/check/{id}','ArticleTmpController@getCheck');
    Route::post('tmp/check','ArticleTmpController@postCheck');
    Route::get('tmp/create','ArticleTmpController@getCreate');
    Route::post('tmp/create','ArticleTmpController@postCreate');
    Route::get('template/{id?}','ArticleTmpController@getTemplatePage');
    Route::get('template_detail/{id}','ArticleTmpController@getArticleTmpPage');
    Route::get('is_able_del_field','ArticleTmpController@isAbleDelField');
    Route::get('tmp/edit/{id}','ArticleTmpController@getEdit');
    Route::post('tmp/edit','ArticleTmpController@postEdit');
    Route::get('tmp/to_activity/{id}','ArticleTmpController@getToActivity');
    Route::post('tmp/to_activity','ArticleTmpController@postToActivity');
    Route::get('tmp/activity/list','ArticleTmpActivityController@getIndex');
    Route::get('tmp/activity/detail/{user_id}/{article_tmp_id}','ArticleTmpActivityController@getDetail');
    Route::post('tmp/activity/del','ArticleTmpActivityController@postDel');
    //endregion
});

Route::group(['middleware'=>['web','admin.login'],'prefix'=>'background','namespace'=>'Background'],function (){
    //region   上传组件        tang
    Route::post('file','UploadController@postFile');
    Route::post('image','UploadController@postImg');
    Route::post('edimg','UploadController@postEditorImg');
    Route::post('video','UploadController@postVideo');
    //endregion

    //region   工具配置 （附件上传时）       tang
    Route::get('tools/file','ToolsController@getFile');
    //endregion

    //region   上传文件配置        tang
    Route::get('file/list','FileController@getList');
    Route::get('file/create','FileController@getCreate');
    Route::post('file/create','FileController@postCreate');
    Route::get('file/edit/{id}','FileController@getEdit');
    Route::post('file/edit','FileController@postEdit');
    Route::post('file/del','FileController@postDel');
    Route::get('file/set_key/{sms_id}','FileKeyController@getSetKey');
    Route::post('file/set_key','FileKeyController@postSetKey');
    //endregion

    //region   管理员管理        tang
    Route::get('admin/list','AdminController@getList');
    Route::get('admin/create','AdminController@getCreate');
    Route::post('admin/create','AdminController@postCreate');
    Route::get('admin/edit/{id}','AdminController@getEdit');
    Route::post('admin/edit','AdminController@postEdit');
    Route::post('admin/del','AdminController@postDel');
    Route::get('admin/auth_login/{admin_id}/{super_id?}','AdminController@getAuthorizedLogin');
    //by 角色管理
    Route::get('admin_role/list','AdminRoleController@getList');
    Route::get('admin_role/create','AdminRoleController@getCreate');
    Route::post('admin_role/create','AdminRoleController@postCreate');
    Route::get('admin_role/edit/{id}','AdminRoleController@getEdit');
    Route::post('admin_role/edit','AdminRoleController@postEdit');
    Route::post('admin_role/del','AdminRoleController@postDel');
    //by 权限控制
    Route::get('admin_navigation/list','AdminNavigationController@getList');
    Route::get('admin_navigation/create/{id?}','AdminNavigationController@getCreate');
    Route::post('admin_navigation/create','AdminNavigationController@postCreate');
    Route::get('admin_navigation/edit/{id}','AdminNavigationController@getEdit');
    Route::post('admin_navigation/edit','AdminNavigationController@postEdit');
    Route::post('admin_navigation/save','AdminNavigationController@postSave');
    Route::post('admin_navigation/del','AdminNavigationController@postDel');
    //endregion

    //region   邮件设置        tang
    //by 服务器管理
    Route::get('email/smtp/list','EmailController@getList');
    Route::get('email/smtp/create','EmailController@getCreate');
    Route::post('email/smtp/create','EmailController@postCreate');
    Route::get('email/smtp/edit/{id}','EmailController@getEdit');
    Route::post('email/smtp/edit','EmailController@postEdit');
    Route::post('email/smtp/del','EmailController@postDel');
    Route::get('email/test','EmailController@getTestEmail');
    Route::post('email/test','EmailController@postTestEmail');
    //by配置服务器
    Route::get('key/set_email/{sms_id}','EmailKeyController@getSetKey');
    Route::post('key/set_email','EmailKeyController@postSetKey');
    //by邮件日志列表
    Route::get('email/log/list','EmailLogController@getList');
    //endregion

    //region   系统配置        tang
    Route::get('config','ConfigController@getConfig');
    Route::post('config','ConfigController@postConfig');
    //endregion

    //region   黑白名单        tang
    //by黑名单
    Route::get('ip/black/list','IpBlacklistsController@getList');
    Route::get('ip/black/create','IpBlacklistsController@getCreate');
    Route::post('ip/black/create','IpBlacklistsController@postCreate');
    Route::get('ip/black/edit/{id}','IpBlacklistsController@getEdit');
    Route::post('ip/black/edit','IpBlacklistsController@postEdit');
    Route::post('ip/black/del','IpBlacklistsController@postDel');
    //by白名单
    Route::get('ip/white/list','IpWhitelistsController@getList');
    Route::get('ip/white/create','IpWhitelistsController@getCreate');
    Route::post('ip/white/create','IpWhitelistsController@postCreate');
    Route::get('ip/white/edit/{id}','IpWhitelistsController@getEdit');
    Route::post('ip/white/edit','IpWhitelistsController@postEdit');
    Route::post('ip/white/del','IpWhitelistsController@postDel');
    //by限制名单
    Route::get('iplimit','ConfigController@getIpLimit');
    Route::post('iplimit','ConfigController@postIpLimit');
    //endregion
});



//前台路由
Auth::routes();

Route::get('/front', 'HomeController@index');
Route::get('/index', 'Home\TestController@GetTestList');



Route::group(['middleware'=>['web'],'prefix'=>'home','namespace'=>'Home'],function () {
    Route::any('/upload', 'ArticleController@upload');
    Route::any('/mail', 'ArticleController@mail');

    Route::get('cache1','ArticleController@cache1');
    Route::get('cache2','ArticleController@cache2');

    Route::get('error','ArticleController@error');
    Route::get('log','ArticleController@log');
    Route::get('queue','ArticleController@queue');
});