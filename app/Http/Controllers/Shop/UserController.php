<?php

namespace App\Http\Controllers\Shop;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    //
    public function index()
    {
        return view("shop.user.index");
    }

    public function reg(Request $request){
        if ($request->isMethod("post")){
            //验证
            $data = $this->validate($request,[
                "name"=>"required",
                "password" => "required|min:6|confirmed",
                "email"=>"email"
            ]);
            $data['password'] = bcrypt($data['password']);
            User::create($data);
            return redirect()->route("shop.user.login");
        }
        return view("shop.user.reg");
    }

    public function login(Request $request)
    {
        if (Auth::user()){
            return redirect()->intended(route("shop.index.index"));
        }

        if ($request->isMethod("post")){
            //1. 验证
            $data = $this->validate($request, [
                "name" => "required",
                "password" => "required"
            ]);

            if (Auth::attempt($data,$request->has("remember"))){
                //登录成功
                return redirect()->intended(route("shop.index.index"))->with("success","登录成功");
            }else{
                //登录失败
                return redirect()->back()->withInput()->with("danger","账号或密码错误");
            }

        }

        return view("shop.user.login");
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route("shop.user.login");
    }

    public function change(Request $request)
    {
        $id = Auth::id();
        $user = User::find($id);
        if ($request->isMethod("post")){
            $data = $this->validate($request,[
                "password" => "required|min:6|confirmed",
                "captcha"=>"required|captcha"
            ]);
            $data["password"]= bcrypt($data['password']);
            $user->update($data);
            return redirect()->route("shop.index.index")->with("success","修改成功");
        }
        return view("shop.user.change",compact("user"));
    }
}
