<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shop;
use App\Models\Shopcategory;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index()
    {
        $shop = New Shop();
        $shops = $shop->ss();
        return view("admin.shop.index",compact("shops"));
    }

    public function edit(Request $request,$id)
    {
        $shops = Shopcategory::all();
        $shop = Shop::find($id);
        $user = User::find($shop->user_id);
        if ($request->isMethod("post")){
            $data = $this->validate($request,[
                "shop_category_id"=>"required",
                "shop_name"=>"required",
                "shop_img"=>"image",
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

            if ($request->file()){
                @unlink($shop->shop_img);
                $data['shop_img']=$file->store("images","image");
            }
            $shop->update($data);
//            dd($data);
            //返回
            return redirect()->route("admin.shop.index")->with("success","修改成功");
        }
        return view("admin.shop.edit",compact("shops","shop","user"));
    }

    public function examine($id)
    {
        $shop=Shop::find($id);
        $shop["status"]=1;
        $user = User::find($shop->user_id);
        $shop->save();
        $shopName="{$shop->shop_name}";
        $to = "{$user->email}";//收件人
        $subject = $shopName.' 审核通知';//邮件标题
        \Illuminate\Support\Facades\Mail::send(
            'emails.shop',//视图
            compact("shopName"),//传递给视图的参数
            function ($message) use($to, $subject) {
                $message->to($to)->subject($subject);
            }
        );
        return redirect()->route("admin.shop.index")->with("success","审核成功");
    }

    public function del($id)
    {
        $shop = Shop::findOrFail($id);
        $user = User::find($shop->user_id);
        DB::transaction(function () use($shop,$user){
            @unlink($shop->shop_img);
            $shop->delete();
            $user->delete();
        });
        return redirect()->route("admin.shop.index")->with("success","删除成功");
    }
}
