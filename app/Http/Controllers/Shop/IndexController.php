<?php

namespace App\Http\Controllers\Shop;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends BaseController
{
    public function index(){
        $id =Auth::id();
        if ($id == null){
            return redirect()->route("shop.user.login")->with("danger","您还没登录");
        }
        $user = User::find($id);
        if ($user->shop_id == 0){
            $shop[0]=$user;
        }else{
            $shop = $user->us($id);
        }
        return view("shop.index.index",compact("shop"));
    }

}
