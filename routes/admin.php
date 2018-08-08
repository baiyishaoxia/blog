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
    //手机注册
    Route::post('mobile/sendsms', 'MobileApi\ValidateController@sendSMS');
    //邮箱注册
    Route::get('mobile/sendemail', 'MobileApi\ValidateController@validateEmail');
    //假设商品分类
    Route::get('mobile/category','MobileApi\CategoryController@getIndex');
    Route::get('mobile/cateinfo/{parent_id?}','MobileApi\CategoryController@getInfo');
    //假设商品列表
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
        //Route::get('mobile/order/commit/{product_id?}/{is_wx?}', 'MobileApi\OrderController@getOrderCommit');
        Route::post('mobile/order/commit', 'MobileApi\OrderController@getOrderCommit');
        //我的订单
        Route::get('mobile/order/list', 'MobileApi\OrderController@getOrderList');
        Route::get('mobile/order/del/{id}', 'MobileApi\OrderController@getDel');
        //微信支付
        Route::post('mobile/wxpay', 'MobileApi\PayController@wxPay');
        //微信回调
        Route::post('mobile/pay/wx_notify', 'MobileApi\PayController@wxNotify');
        //支付宝支付 (显示/回调/成功/中断)
        Route::get('mobile/alipay', 'MobileApi\PayController@getIndex');
        Route::post('mobile/alipay/notify', 'MobileApi\PayController@aliNotify');
        Route::get('mobile/alipay/ali_result', 'MobileApi\PayController@aliResult');
        Route::get('mobile/alipay/ali_merchant', 'MobileApi\PayController@aliMerchant');
        Route::post('mobile/alipay', 'MobileApi\PayController@aliPay');
    });
    //endregion






});