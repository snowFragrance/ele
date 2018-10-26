<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shop;
use App\Models\ShopCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopCategoryController extends BaseController
{
    //
    public function index()
    {
        $cates = Shopcategory::all();

        return view("admin.shop_category.index",compact("cates"));
    }

    public function add(Request $request)
    {
        if ($request->isMethod("post")){
            //验证
            $data = $this->validate($request, [
                "name"=> "required",
                "img" => "required|image",
                "status"=>"required",
                "sort"=> "required",
            ]);
            $data['img']=$request->file("img")->store("images","image");
            Shopcategory::create($data);
            //3. 跳转
            return redirect()->route("admin.shopCate.index")->with("success", "添加成功");
        }
        return view("admin.shop_category.add");
    }

    public function edit(Request $request,$id)
    {
        $cate = Shopcategory::find($id);
        if ($request->isMethod("post")){
            $data = $this->validate($request, [
                "name"=> "required",
                "img" => "image",
                "status"=>"required",
                "sort"=> "required",
            ]);
            //判断是否接收到图片，如果接收到图片就将原图删除
            if ($request->file()){
                @unlink($cate["img"]);
                $data["img"]=$request->file("img")->store("images","image");
            }
            $cate->update($data);
            return redirect()->route("admin.shopCate.index")->with("success","编辑成功");
        }

        return view("admin.shop_category.edit",compact("cate"));
    }

    public function del($id)
    {
        $cate = Shopcategory::findOrFail($id);
        @unlink($cate["img"]);
        $cate->delete($cate);
        return redirect()->route("admin.shopCate.index")->with("success","删除成功");
    }
}
