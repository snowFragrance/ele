<?php

namespace App\Http\Controllers\Shop;

use App\Models\Shop;
use App\Models\Shopcategory;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShopController extends BaseController
{
    public function reg(Request $request)
    {
        $shops = Shopcategory::all();
        if (Auth::id() == 4){
            return redirect()->route("shop.user.login");
        }
        if ($request->isMethod("post")){
            $data = $this->validate($request,[
                "shop_category_id"=>"required",
                "shop_name"=>"required",
                "shop_img"=>"required|image",
                "start_send"=>"required",
                "send_cost"=>"required",
            ]);

            $data["notice"] = $request->post("notice");
            $data["discount"] = $request->post("discount");
            $file = $request->file("shop_img");
            $data['brand']=$request->has("brand")?1:0;
            $data['on_time']=$request->has("on_time")?1:0;
            $data['fengniao']=$request->has("fengniao")?1:0;
            $data['bao']=$request->has("bao")?1:0;
            $data['piao']=$request->has("piao")?1:0;
            $data['zhun']=$request->has("zhun")?1:0;
            $data['status']=0;
            $data['user_id']=Auth::id();
            $data['shop_img']=$file->store("images","image");
            Shop::create($data);
            $shop = DB::table('shops')
                ->orderBy('id', 'desc')
                ->first();
            $user = User::find($data['user_id']);
            $user["shop_id"] = $shop->id;
            DB::update('update users set shop_id= :shop_id where id= :id ',[$user["shop_id"],$data['user_id']]);
            //返回
            return redirect()->route("shop.index.index")->with("success","注册成功");
        }
        return view("shop.index.reg",compact("shops"));
    }

}
