<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $user_id = $request->post('user_id');
        $goodsList=$request->post('goodsList');
        $goodsCount=$request->post('goodsCount');
        foreach ($goodsList as $k=>$goods){
            $data=[
                'user_id'=>$user_id,
                'goods_id'=>$goods,
                'amount'=>$goodsCount[$k],
            ];
            Cart::create($data);
        }

            return [
                "status"=> "true",
                "message"=> "添加成功"
            ];
    }

    public function cart(Request $request)
    {
        $user_id = $request->get("user_id");
        $carts = Cart::where("user_id",$user_id)->get();
        //声明一个数组
        $goodsList = [];
        //声明总价
        $totalCost = 0;
//        dd($data);
        foreach ($carts as $k => $cart){
            $good = Menu::where('id', $cart->goods_id)->first();
            $good->amount = $cart->amount;
            //算总价
            $totalCost += $good->amount * $good->goods_price;
            $goodsList[] = $good;
        }
//        dd($goodsList);
        return [
            'goods_list' => $goodsList,
            'totalCost' => $totalCost
        ];
    }
}
