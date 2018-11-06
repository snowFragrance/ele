<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class PerController extends BaseController
{
    public function add(Request $request)
    {
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
        $pers=Permission::pluck("name")->toArray();
        //已经存在的从$urls中去掉
        $urls=array_diff($urls,$pers);

        if ($request->isMethod("post")){
            //接收参数
            $data = $request->post();
//            dd($data);
            //设置守卫
            $data['guard_name'] = 'admin';
            //创建权限
            Permission::create($data);
        }
        return view('admin.per.add',compact('urls'));
    }

    public function list()
    {
        $pers = Permission::all();
        return view("admin.per.list",compact("pers"));
    }

    public function edit(Request $request,$id)
    {
        $per = Permission::find($id);
        if ($request->isMethod("post")){
            $data = $request->post();
            $per->update($data);
            return redirect()->route("admin.per.list")->with("success","编辑成功");
        }

//        dd($per);
        return view("admin.per.edit",compact('per'));
    }
}
