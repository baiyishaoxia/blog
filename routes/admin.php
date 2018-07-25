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






});