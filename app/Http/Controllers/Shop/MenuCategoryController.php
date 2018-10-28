<?php

namespace App\Http\Controllers\Shop;

use App\Models\MenuCategory;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuCategoryController extends BaseController
{
    public function index()
    {
        $gories = MenuCategory::all();
        return view("shop.menuCate.index",compact("gories"));
    }

    public function add(Request $request)
    {
        if ($request->isMethod("post")){
            $data = $this->validate($request,[
                "name"=>"required",
                "number"=>"required",
            ]);
            $user_id = Auth::id();
            $shop_id = User::find($user_id)->shop_id;
            $data["shop_id"]= $shop_id;
            $data["description"] = $request->post("description");
            if ($request->post("is_selected")){
                $cates =MenuCategory::all();
                foreach ($cates as $cate){
                    $cate->is_selected = 0;
                    $cate->save();
                }
                $data["is_selected"]= 1;
            }
//            dd($data);
            MenuCategory::create($data);
            return redirect()->route("shop.MenuCate.index")->with("success","添加成功");
        }

        return view("shop.menuCate.add");
    }

    public function edit(Request $request,$id)
    {
        $cate = MenuCategory::find($id);
        if ($request->isMethod("post")){
            $data = $this->validate($request,[
                "name"=>"required",
                "number"=>"required",
            ]);

            $data["description"] = $request->post("description");
            if ($cate->is_selected != 1){
                DB::table('menu_categories')->update(['is_selected'=>0]);
                $data['is_selected']=1;
            }

            $cate->update($data);
            return redirect()->route("shop.MenuCate.index")->with("success","编辑成功");
        }

        return view("shop.menuCate.edit",compact("cate"));
    }

    public function del($id)
    {
        $cate = MenuCategory::findOrFail($id);
        if ($cate->is_selected == 0){
            $cate->delete();
            return back()->with("success","删除成功");
        }else{
            return back()->with("danger","此为默认分类不能删除");
        }
    }

    public function check($id)
    {
        $cate = MenuCategory::findOrFail($id);
        if ($cate->is_selected != 1){
            DB::table('menu_categories')->update(['is_selected'=>0]);
            $data['is_selected']=1;
        }
        $cate->update($data);
        return back();
    }
}
