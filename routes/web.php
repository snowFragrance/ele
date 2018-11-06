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
    return view('index');
});

Route::get("test",function (){
    $shopName="互联网学院";
    $to = '31629311818';//收件人
    $subject = $shopName.' 审核通知';//邮件标题
    \Illuminate\Support\Facades\Mail::send(
        'emails',//视图
        compact("shopName"),//传递给视图的参数
        function ($message) use($to, $subject) {
            $message->to($to)->subject($subject);
        }
    );
});

Route::domain("admin.ele.com")->namespace("Admin")->group(function (){
    //region 商户分类
    Route::get("shopCate/index","ShopCategoryController@index")->name("admin.shopCate.index");
    Route::any("shopCate/add","ShopCategoryController@add")->name("admin.shopCate.add");
    Route::any("shopCate/edit/{id}","ShopCategoryController@edit")->name("admin.shopCate.edit");
    Route::any("shopCate/del/{id}","ShopCategoryController@del")->name("admin.shopCate.del");
    //endregion

    //region 登录、注册、退出
    Route::any("admin/login","AdminController@login")->name("admin.admin.login");
    Route::any("admin/reg","AdminController@reg")->name("admin.admin.reg");
    Route::any("admin/logout","AdminController@logout")->name("admin.admin.logout");
    Route::any("admin/change/{id}","AdminController@change")->name("admin.admin.change");
    Route::get("admin/index","AdminController@index")->name("admin.admin.index");
    //endregion

    //region 员工管理
    Route::get("admin/list","AdminController@list")->name("admin.admin.list");
    Route::any("admin/edit/{id}","AdminController@edit")->name("admin.admin.edit");
    //endregion

    //region 商户管理
    Route::get("user/index","UserController@index")->name("admin.user.index");
    Route::any("user/add","UserController@add")->name("admin.user.add");
    Route::any("user/edit/{id}","UserController@edit")->name("admin.user.edit");
    Route::get("user/del/{id}","UserController@del")->name("admin.user.del");
    Route::get("user/reset/{id}","UserController@reset")->name("admin.user.reset");
    //endregion

    //region 店铺管理
    Route::get("shop/index","ShopController@index")->name("admin.shop.index");
    Route::any("shop/edit/{id}","ShopController@edit")->name("admin.shop.edit");
    Route::get("shop/examine/{id}","ShopController@examine")->name("admin.shop.examine");
    Route::get("shop/del/{id}","ShopController@del")->name("admin.shop.del");
    //endregion

    //region 活动管理
    Route::get("activity/index","ActivityController@index")->name("admin.activity.index");
    Route::any("activity/add","ActivityController@add")->name("admin.activity.add");
    Route::any("activity/edit/{id}","ActivityController@edit")->name("admin.activity.edit");
    Route::any("activity/del/{id}","ActivityController@del")->name("admin.activity.del");
    //endregion

    //region 权限
    Route::any("per/add","PerController@add")->name("admin.per.add");
    Route::get("per/list","PerController@list")->name("admin.per.list");
    Route::any("per/edit/{id}","PerController@edit")->name("admin.per.edit");

    Route::any("role/add","RoleController@add")->name("admin.role.add");
    Route::any("role/edit/{id}","RoleController@edit")->name("admin.role.edit");
    Route::get("role/list","RoleController@list")->name("admin.role.list");
    Route::any("role/edit/{id}","RoleController@edit")->name("admin.role.edit");
    //endregion
});

Route::domain("shop.ele.com")->namespace("Shop")->group(function (){
    //region 商户注册、登录、修改密码
    Route::any("user/reg","UserController@reg")->name("shop.user.reg");
    Route::any("user/login","UserController@login")->name("shop.user.login");
    Route::get("user/logout","UserController@logout")->name("shop.index.logout");
    Route::any("user/change","UserController@change")->name("shop.index.change");
    //endregion

    //region 商户首页,注册店铺
    Route::get("index/index","IndexController@index")->name("shop.index.index");
    Route::any("index/reg","ShopController@reg")->name("shop.reg");
    //endregion

    //region 商品分类
    Route::get("MenuCate/index","MenuCategoryController@index")->name("shop.MenuCate.index");
    Route::any("MenuCate/add","MenuCategoryController@add")->name("shop.menuCate.add");
    Route::any("MenuCate/edit/{id}","MenuCategoryController@edit")->name("shop.menuCate.edit");
    Route::get("MenuCate/del/{id}","MenuCategoryController@del")->name("shop.menuCate.del");
    Route::get("MenuCate/check/{id}","MenuCategoryController@check")->name("shop.menuCate.check");
    //endregion

    //region 菜单
    Route::get("Menu/index","MenuController@index")->name("shop.menu.index");
    Route::any("Menu/add","MenuController@add")->name("shop.menu.add");
    Route::any("Menu/upload","MenuController@upload")->name("shop.menu.upload");
    Route::any("Menu/edit/{id}","MenuController@edit")->name("shop.menu.edit");
    Route::any("Menu/del/{id}","MenuController@del")->name("shop.menu.del");

    Route::get("Menu/list","MenuController@list")->name("shop.menu.list");
    //endregion

    //region 活动
    Route::get("activity/index","ActivityController@index")->name("shop.activity.index");
    Route::get("activity/xq/{id}","ActivityController@xq")->name("shop.activity.xq");
    //endregion

    //region 订单
    Route::get("statistcs/day","OrderController@day")->name("shop.day");
    Route::get("statistcs/day/{id}","OrderController@details")->name("shop.details");
    Route::get("statistcs/fh/{id}","OrderController@fh")->name("shop.fh");
    Route::get("statistcs/cancel/{id}","OrderController@cancel")->name("shop.cancel");

    Route::get("statistcs/month","OrderController@month")->name("shop.month");
    Route::get("statistcs/total","OrderController@total")->name("shop.total");

    Route::get("statistcs/dx","OrderController@dx")->name("shop.dx");
    //endregion
});