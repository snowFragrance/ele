<?php

namespace App\Http\Controllers\Admin;

use App\Models\Nav;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;


class NavController extends BaseController
{
    public function navy(Request $request)
    {
        if ($request->isMethod('post')){
            $data = $this->validate($request,[
                "name"=>"required",
            ]);
            $data['sort'] = $request->post('sort')??100;
            Nav::create($data);
            return redirect()->route("admin.navy")->with("success", "添加成功");
        }

        return view('admin.nav.navy');
    }

    public function navt(Request $request)
    {
        $navy = Nav::where("pid",0)->get();
        //声明一个数组装路由名
        $urls = [];
        //得到所有路由
        $routes = Route::getRoutes();
        //循环得到单个路由
        foreach ($routes as $route){
            //判断命名空间是后台
            if (isset($route->action["namespace"]) && $route->action["namespace"] == 'App\Http\Controllers\Admin'){
                $urls[]=$route->action['as'];
            }
        }
        //从数据库取出已经存在的
        $pers=Nav::pluck("url")->toArray();
        //已经存在的从$urls中去掉
        $urls=array_diff($urls,$pers);
//        dd($urls);

        if ($request->isMethod('post')){
            $data = $this->validate($request,[
                "name"=>"required",
                "url"=>"required",
                "pid"=>"required",
            ]);
            $data['sort'] = $request->post('sort')??100;
//            dd($data);
            Nav::create($data);
            return redirect()->route("admin.navt")->with("success", "添加成功");
        }

        return view('admin.nav.navt',compact('navy','urls'));
    }
}
