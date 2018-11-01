<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("shop/index","Api\ShopController@index");
Route::get("shop/detail","Api\ShopController@detail");
Route::get("member/sms","Api\MemberController@sms");

//注册
Route::post("member/reg","Api\MemberController@reg");
Route::post("member/login","Api\MemberController@login");
Route::post("member/forget","Api\MemberController@forget");
Route::get("member/detail","Api\MemberController@detail");
Route::post("member/change","Api\MemberController@change");

//收货地址
Route::post("address/add","Api\AddressController@add");
Route::get("address/list","Api\AddressController@list");
Route::get("address/address","Api\AddressController@address");
Route::post("address/edit","Api\AddressController@edit");

//购物车
Route::post("cart/add","Api\CartController@add");
Route::get("cart/cart","Api\CartController@cart");