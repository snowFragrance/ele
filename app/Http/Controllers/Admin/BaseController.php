<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
//use Illuminate\Routing\Controller ;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware("auth:admin",[
            "except"=>["login","reg"]
        ]);

        $this->middleware(function ($request,\Closure $next){
            //得到当前访问地址的路由
            $route = Route::currentRouteName();

            //设置白名单z
            $allow=[
                "admin.admin.login",
                "admin.admin.logout"
            ];
            //判断当前登录用户有没有权限
            //保证在白名单并且有权限并且id==1
            if (!in_array($route,$allow) && !Auth::guard("admin")->user()->can($route) && Auth::guard("admin")->id()!=1){
                exit(view("admin.UsrLMT"));
            }
            return $next($request);
        });
    }

}
