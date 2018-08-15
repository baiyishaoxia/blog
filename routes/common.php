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

Route::get('/captcha/{width}/{height}', function ($width,$height){
    return \App\Http\Model\Common\Captcha::build($width,$height,true);
});

//region   中英文切换        tang
Route::get('/change/language','IndexController@changeSession');
//endregion
