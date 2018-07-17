<?php
Route::group(['middleware'=>['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'],function () {
    //region   系统工具        tang
    Route::get('element', 'ReadSystemController@getElement');
    Route::any('syslist', 'ReadSystemController@getList');
    Route::get('systab', 'ReadSystemController@getTab');
    //endregion

    //region   分类列表        tang

    //endregion






});