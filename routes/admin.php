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




    //region   移动api        tang
    Route::get('mobile/login', 'MobileApi\MemberController@login');
    Route::post('mobile/login', 'MobileApi\MemberController@login');
    Route::get('mobile/register', 'MobileApi\MemberController@register');
    Route::post('mobile/register', 'MobileApi\MemberController@postRegister');
    Route::get('mobile/validate', 'MobileApi\ValidateController@create');
    Route::post('mobile/sendsms', 'MobileApi\ValidateController@sendSMS');
    Route::get('mobile/sendemail', 'MobileApi\ValidateController@validateEmail');

    Route::get('mobile/category','MobileApi\CategoryController@getIndex');
    Route::get('mobile/cateinfo/{parent_id?}','MobileApi\CategoryController@getInfo');
    Route::get('mobile/product/cate_id/{cate_id?}','MobileApi\CategoryController@getProduct');
    Route::get('mobile/product/{product_id}','MobileApi\CategoryController@getProductContent');
    //加入购物车
    Route::get('mobile/cart/add/{product_id?}', 'MobileApi\CartController@addCart');

    Route::group(['middleware' => 'mobile.login'], function () {
        //退出登陆
        Route::get('mobile/logout', 'MobileApi\MemberController@logout');
        //查看购物车 (用户需要登录)
        Route::get('mobile/cart', 'MobileApi\CartController@getCart');
        //删除订单
        Route::get('mobile/cart/delete', 'MobileApi\CartController@getDelCart');
        //结算
        Route::get('mobile/order/commit/{product_id?}/{is_wx?}', 'MobileApi\OrderController@getOrderCommit');
        //我的订单
        Route::get('mobile/order/list', 'MobileApi\OrderController@getOrderList');


    });
    //endregion






});