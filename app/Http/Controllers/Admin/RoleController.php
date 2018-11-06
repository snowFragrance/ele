<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends BaseController
{
    public function add(Request $request)
    {
        if ($request->isMethod("post")){
            //接收参数 并处理数据
            $pers=$request->post('per');
            //添加角色
            $role=Role::create([
                "name"=>$request->post("name"),
                "guard_name"=>"admin"
            ]);
            //给角色同步权限
            if ($pers){
                $role->syncPermissions($pers);
            }
        }
        $pers = Permission::all();
        //引入视图
        return view("admin.role.add",compact('pers'));
    }

    public function list()
    {
        $roles = Role::all();

        return view('admin.role.list',compact('roles'));
    }

    public function edit(Request $request,$id)
    {
        $role = Role::find($id);
        if ($request->isMethod("post")){
            //接收参数 并处理数据
            $pers=$request->post('per');
            //添加角色
            $role->update([
                "name"=>$request->post("name"),
            ]);
            //给角色同步权限
            if ($pers){
                $role->syncPermissions($pers);
            }
            return redirect()->route("admin.role.list")->with("success","修改成功");
        }
        $pers = Permission::all();
        return view('admin.role.edit',compact('role',"pers"));
    }
}
