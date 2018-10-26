<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends BaseController
{
    //
    public function reg(Request $request)
    {
        if ($request->isMethod("post")){
            //验证
            $data = $this->validate($request,[
                "name"=>"required",
                "password" => "required|min:6|confirmed",
                "email"=>"email"
            ]);
            $data['password'] = bcrypt($data['password']);
            Admin::create($data);
            return redirect()->route("admin.admin.login");
        }
        return view("admin.admin.reg");
    }
    
    public function login(Request $request){
        if ($request->isMethod("post")){
            //1. 验证
            $data = $this->validate($request, [
                "name" => "required",
                "password" => "required"
            ]);
            if (Auth::guard("admin")->attempt($data,$request->has("remember"))){

                //登录成功
                return redirect()->intended(route("admin.shopCate.index"))->with("success","登录成功");
            }else{
                //登录失败
                return redirect()->back()->withInput()->with("danger","账号或密码错误");
            }
        }

        return view("admin.admin.login");
    }

    public function logout()
    {
        Auth::guard("admin")->logout();
        return redirect()->route("admin.admin.login");
    }

    public function change(Request $request,$id)
    {
        $admin = Admin::find($id);
        if ($request->post()){
            $data = $this->validate($request,[
                "password" => "required|min:6|confirmed",
            ]);
            $data["password"]= bcrypt($data['password']);
            $admin->update($data);
            return redirect()->route("admin.shopCate.index")->with("success","修改成功");
        }
        return view("admin.admin.change",compact("admin"));
    }
}
