<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;

class UserController extends BaseController
{
    public function index(){
        $user = New User();
        $users =$user->all();
//        dd($users);
        return view("admin.user.index",compact("users"));
    }

    public function add(Request $request)
    {
        if ($request->isMethod("post")){
            //验证
            $data = $this->validate($request,[
                "name"=>"required",
                "password" => "required|min:6|confirmed",
                "email"=>"email"
            ]);
            $data['password'] = bcrypt($data['password']);
            User::create($data);
            return redirect()->route("admin.user.index");
        }
        return view("admin.user.add");
    }

    public function edit(Request $request,$id)
    {
        $user = User::find($id);
        if ($request->isMethod("post")){
            $data = $this->validate($request,[
                "name"=>"required",
                "email"=>"email"
            ]);
            $user->update($data);
            return redirect()->route("admin.user.index")->with("success","修改成功");
        }

        return view("admin.user.edit",compact("user"));
    }

    public function del($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route("admin.user.index")->with("success","删除成功");
    }

    public function reset($id)
    {
        $user = User::find($id);
        $user["password"] = bcrypt("123456");
//        dd($user["password"]);
        $user->save();
        return redirect()->route("admin.user.index")->with("success","密码重置成功，重置密码为：123456");
    }
}
