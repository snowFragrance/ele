<?php

namespace App\Http\Controllers\Shop;

use App\Models\Menu;
use App\Models\MenuCategory;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MenuController extends BaseController
{
    public function index()
    {
        $menus = Menu::all();
        return view("shop.menu.index",compact("menus"));
    }

    public function add(Request $request)
    {
        $cates = MenuCategory::all();
//        dd($cates[0]->id);
        if ($request->isMethod("post")){
//            dd($request->post());
            $data = $this->validate($request,[
                "goods_name"=>"required",
                "category_id"=>"required",
                "goods_price"=>"required",
//                "goods_img"=>"image"
            ]);
            $data["description"]= $request->post("description");
            $data["tips"]= $request->post("tips");
            $data["status"]= $request->post("status");
            $id = Auth::id();
            $user = User::find($id);
            $data["shop_id"]=$user->shop_id;
            $data['goods_img']=$request->post("goods_img");
            Menu::create($data);
            return redirect()->back("shop.menu.index")->with("success","编辑成功");
        }
        return view("shop.menu.add",compact("cates"));
    }

    public function edit(Request $request,$id)
    {
        $menu = Menu::find($id);
        $cates = MenuCategory::all();
        if ($request->isMethod("post")){
            $data = $this->validate($request,[
                "goods_name"=>"required",
                "category_id"=>"required",
                "goods_price"=>"required",
            ]);
            $data["description"]= $request->post("description");
            $data["tips"]= $request->post("tips");
            $data["status"]= $request->post("status");
            if ($request->post("goods_img")){
                //删除图片
                Storage::delete($menu->goods_img);
                $data["goods_img"]= $request->post("goods_img");
            }
            $menu->update($data);
            return redirect()->route("shop.menu.index")->with("success","修改成功");
        }

        return view("shop.menu.edit",compact("menu","cates"));
    }

    public function del($id)
    {
        $menu = Menu::findOrFail($id);
        DB::transaction(function () use($menu){
            Storage::delete($menu->goods_img);
            $menu->delete();
        });
        return back()->with("success","删除成功");
    }

    public function list(Request $request)
    {
        //得到登录的用户id
        $user_id = Auth::id();
        //判断是否用户是否登录
        if (!$user_id){
            return redirect()->route("shop.user.login")->with("danger","您还没登录呢");
        }
        //根据用户id找到shop_id
        $shop_id = User::find($user_id)->shop_id;
        //找到shop下面的商品分类
        $cates = MenuCategory::all()->where("shop_id",$shop_id);
        //找到所有菜品
        $menus = Menu::all();

        //可以得到所有get的参数，并以数组
        $url=$request->query();
        $min = $request->get("min");
        $max = $request->get("max");
        $keyword = $request->get("keyword");
        if ($keyword!==null){

            $menus->where("name","like","%{$keyword}%");
        }

//        if ($cateId!==null){
//            $query->where("cate_id",$cateId);
//        }
        if ($max!==null){

            $menus->where("goods_price","<=",$max);
        }
        if ($min!==null){

            $menus->where("price",">=",$min);
        }

        return view("shop.menu.list",compact("cates","menus"));
    }

    public function upload(Request $request)
    {
        //处理上传
//        dd($request->file("file"));
        $file=$request->file("file");

        if ($file){
            //上传
            $url=$file->store("menu");
//             var_dump($url);
            //得到真实地址  加 http的址
//            $url=Storage::url($url);
            $data['url']=$url;
            return $data;
            ///var_dump($url);
        }
    }
}
