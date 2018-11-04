<?php

namespace App\Http\Controllers\Api;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Mrgoon\AliSms\AliSms;

class MemberController extends Controller
{
    public function reg(Request $request)
    {
        //验证验证码是否匹配？
        $values = $request->post();
        if ($values['sms'] == Redis::get('tel_' . $values['tel'])) {
            $values['password'] = bcrypt($values['password']);
            if (Member::create($values)) {
                $data = [
                    "status" => "true",
                    "message" => "注册成功"
                ];
            }else{
                $data = [
                    "status" => "false",
                    "message" => "注册失败"
                ];
            }


        } else {
            $data = [
                "status" => "false",
                "message" => "验证码错误"
            ];
        }

        return $data;
    }

    public function sms(Request $request)
    {
        //接收参数：号码
        $tel = $request->get("tel");

        //生成随机数
        $code = mt_rand(1000, 9999);

        //将号码和随机数用redis保存
        Redis::setex("tel_" . $tel, 60 * 5, $code);

        //把验证码发给手机
        //TODO

        $data = [
            "status" => true,
            "message" => "获取短信验证码成功" . $code
        ];
        return $data;
    }

    public function login(Request $request)
    {
        //接收数据
        $data = $request->post();
        //判断用户名密码是否正确
        $user = Member::where("username","{$data['name']}")->first();
//        dd($user[0]['password']);
        if ($user){
            if (Hash::check("{$data['password']}","{$user['password']}")){
                $data = [
                    "status"=>"true",
                    "message"=>"登录成功",
                    "user_id"=>$user["id"],
                    "username"=>$data["name"]
                ];
            }else{
                $data = [
                    "status"=>"false",
                    "message"=>"密码错误",
                ];
            }
        }else{
            $data = [
                "status"=>"false",
                "message"=>"账号有误",
            ];
        }
        return $data;
    }

    public function forget(Request $request)
    {
        $data = $request->post();
        if ($data['sms'] == Redis::get('tel_' . $data['tel'])) {
            $user = Member::where("tel","{$data['tel']}")->first();
//            dd($user);
            $user['password'] = bcrypt($data['password']);
            if ($user->save()) {
                $data = [
                    "status" => "true",
                    "message" => "重置成功"
                ];
            }else{
                $data = [
                    "status" => "false",
                    "message" => "重置失败"
                ];
            }


        } else {
            $data = [
                "status" => "false",
                "message" => "验证码错误"
            ];
        }

        return $data;
    }

    public function detail(Request $request)
    {
        //将登录用户找到
        $user_id = $request->user_id;
        //查询登录用户的数据
        $data = Member::find($user_id);
        return [
            "status"=>"true",
            "message"=>"查询成功",
            "money"=>$data->money,
            "jifen"=>$data->jifen
        ];
    }

    public function change(Request $request)
    {
        $data = $request->post();
//        dd($data);
        $user = Member::find($data["id"]);
        if (Hash::check("{$data['oldPassword']}","$user->password")){
            $new = bcrypt($data['newPassword']);
            $user->password = $new;
            $user->save();
            return [
                "status"=> "true",
                "message"=> "修改成功"
            ];
        }else{
            return [
                "status"=> "false",
                "message"=> "旧密码错误"
            ];
        }
    }
}
