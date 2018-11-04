<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    public function add(Request $request)
    {
        $data = $request->post();
        if (Address::create($data)){
            return [
                "status" => "true",
                "message" => "添加成功"
            ];
        }else{
            return [
                "status" => "false",
                "message" => "添加失败"
            ];
        }
    }

    public function list(Request $request)
    {
        //得到用户id
        $user_id = $request->get("user_id");
        //找到用户对应的地址
        $address = Address::all()->where("user_id",$user_id);
        //返回数据
        return $address;
    }

    public function address(Request $request)
    {
        //得到id
        $id = $request->get("id");
        //找到对应数据
        $data = Address::find($id);
        return $data;
    }

    public function edit(Request $request)
    {
        $data = $request->post();
        //找到对应数据
        $row = Address::find($data["id"]);
        if ($row->update($data)){
            return [
                "status" => "true",
                "message" => "修改成功"
            ];
        }else{
            return [
                "status" => "false",
                "message" => "修改失败"
            ];
        }
    }
}
