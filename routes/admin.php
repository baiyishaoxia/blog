<?php
Route::group(['middleware'=>['web','admin.login'],'namespace'=>'Admin'],function () {
    //region   系统工具        tang
    Route::get('element', 'ReadSystemController@getElement');
    Route::any('syslist', 'ReadSystemController@getList');
    Route::get('systab', 'ReadSystemController@getTab');
    //endregion

    //region   图片裁剪        tang
    Route::get('img/index', 'SystemToolsController@getIndex');
    Route::post('img/create', 'SystemToolsController@create');
    Route::get('img/imgcat', 'SystemToolsController@imgCat');
    //endregion

    //region   手机api        tang
    Route::get('mobile/login', 'MobileApi\MemberController@login');
    Route::post('mobile/login', 'MobileApi\MemberController@login');
    Route::get('mobile/register', 'MobileApi\MemberController@register');
    Route::post('mobile/register', 'MobileApi\MemberController@postRegister');
    Route::get('mobile/validate', 'MobileApi\ValidateController@create');
    Route::get('mobile/sendsms', 'MobileApi\ValidateController@sendSMS');
    Route::get('mobile/sendemail', 'MobileApi\ValidateController@validateEmail');
    //endregion






});