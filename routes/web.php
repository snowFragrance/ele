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
    Route::any("shop/edit/{id}","ShopController@edit")->name("admin.shop.edit");
    Route::get("shop/examine/{id}","ShopController@examine")->name("admin.shop.examine");
    Route::get("shop/del/{id}","ShopController@del")->name("admin.shop.del");

    //活动管理
    Route::get("activity/index","ActivityController@index")->name("admin.activity.index");
    Route::any("activity/add","ActivityController@add")->name("admin.activity.add");
    Route::any("activity/edit/{id}","ActivityController@edit")->name("admin.activity.edit");
    Route::any("activity/del/{id}","ActivityController@del")->name("admin.activity.del");
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

    //商品分类
    Route::get("MenuCate/index","MenuCategoryController@index")->name("shop.MenuCate.index");
    Route::any("MenuCate/add","MenuCategoryController@add")->name("shop.menuCate.add");
    Route::any("MenuCate/edit/{id}","MenuCategoryController@edit")->name("shop.menuCate.edit");
    Route::get("MenuCate/del/{id}","MenuCategoryController@del")->name("shop.menuCate.del");
    Route::get("MenuCate/check/{id}","MenuCategoryController@check")->name("shop.menuCate.check");

    //菜单
    Route::get("Menu/index","MenuController@index")->name("shop.menu.index");
    Route::any("Menu/add","MenuController@add")->name("shop.menu.add");
    Route::any("Menu/upload","MenuController@upload")->name("shop.menu.upload");
    Route::any("Menu/edit/{id}","MenuController@edit")->name("shop.menu.edit");
    Route::any("Menu/del/{id}","MenuController@del")->name("shop.menu.del");

    Route::get("Menu/list","MenuController@list")->name("shop.menu.list");

    //活动
    Route::get("activity/index","ActivityController@index")->name("shop.activity.index");
    Route::get("activity/xq/{id}","ActivityController@xq")->name("shop.activity.xq");
});