<?php

namespace App\Http\Controllers\Shop;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends BaseController
{
    public function index(){
        $id =Auth::id();
        $id =$id?$id:4;
        $user = User::find($id);
        dd($user);
        if ($user == []){
            dd(11);
        }
        $shop = $user->us($id);

        return view("shop.index.index",compact("shop"));
    }

}
