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

Route::domain("admin.ele.com")->namespace("Admin")->group(function (){
    //商户分类
    Route::get("shopCate/index","ShopCategoryController@index")->name("admin.shopCate.index");
    Route::any("shopCate/add","ShopCategoryController@add")->name("admin.shopCate.add");
    Route::any("shopCate/edit/{id}","ShopCategoryController@edit")->name("admin.shopCate.edit");
    Route::any("shopCate/del/{id}","ShopCategoryController@del")->name("admin.shopCate.del");
    //登录、注册、退出
    Route::any("admin/login","AdminController@login")->name("admin.admin.login");
    Route::any("admin/reg","AdminController@reg")->name("admin.admin.reg");
    Route::any("admin/logout","AdminController@logout")->name("admin.admin.logout");
    Route::any("admin/change/{id}","AdminController@change")->name("admin.admin.change");

    //商户管理
    Route::get("user/index","UserController@index")->name("admin.user.index");
    Route::any("user/add","UserController@add")->name("admin.user.add");
    Route::any("user/edit/{id}","UserController@edit")->name("admin.user.edit");
    Route::get("user/del/{id}","UserController@del")->name("admin.user.del");
    Route::get("user/reset/{id}","UserController@reset")->name("admin.user.reset");

    //店铺管理
    Route::get("shop/index","ShopController@index")->name("admin.shop.index");
});

Route::domain("shop.ele.com")->namespace("Shop")->group(function (){
    //商户注册、登录、修改密码
    Route::any("user/reg","UserController@reg")->name("shop.user.reg");
    Route::any("user/login","UserController@login")->name("shop.user.login");
    Route::get("user/logout","UserController@logout")->name("shop.index.logout");
    Route::any("user/change","UserController@change")->name("shop.index.change");

    //商户首页,注册店铺
    Route::get("index/index","IndexController@index")->name("shop.index.index");
    Route::any("index/reg","ShopController@reg")->name("shop.reg");
});