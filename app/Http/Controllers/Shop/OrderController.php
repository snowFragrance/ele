<?php

namespace App\Http\Controllers\Shop;

use App\Models\Member;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends BaseController
{
    //
    public function day()
    {
        $shop_id = Auth::user()->shop_id;
        $now = date("Y-m-d");
        $datas=Order::where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"),$now)
            ->where("shop_id",$shop_id)
            ->get();

        foreach ($datas as $k=>$data){
            $datas[$k]["username"] = Member::find($datas[$k]->user_id)->username;
            $datas[$k]['status'] = $data->order_status;
        }
//        dd($datas);

        //引入视图
        return view("shop/statistics/orderDay",compact("datas"));
    }

    public function details(Request $request,$id)
    {
        //查询一条数据
        $order = Order::find($id);
        $order["username"] = Member::find($order->user_id)->username;
        $details = OrderDetail::where("order_id",$order->id)->get();
//        dd($order,$detail);
        //引入视图
        return view("shop/statistics/details",compact("order","details"));
    }

    public function fh($id)
    {
        $order = Order::find($id);
        //状态 +1
        $order->where('id',$id)->increment('status');
        return redirect()->route("shop.day");
    }

    public function cancel($id)
    {
        $order = Order::find($id);
        //状态 +1
        $order->where('id',$id)->decrement('status',2);
        return redirect()->route("shop.day");
    }

    public function month()
    {
        $shop_id = Auth::user()->shop_id;
        $now = date("Y-m");
        $datas=Order::where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"),$now)
            ->where("shop_id",$shop_id)
            ->get();

        foreach ($datas as $k=>$data){
            $datas[$k]["username"] = Member::find($datas[$k]->user_id)->username;
            $datas[$k]['status'] = $data->order_status;
        }
//        dd($datas);

        //引入视图
        return view("shop/statistics/orderDay",compact("datas"));
    }

    public function total()
    {
        $shop_id = Auth::user()->shop_id;
        $datas = Order::where("shop_id",$shop_id)->get();
        foreach ($datas as $k=>$data){
            $datas[$k]["username"] = Member::find($datas[$k]->user_id)->username;
            $datas[$k]['status'] = $data->order_status;
        }
        //引入视图
        return view("shop/statistics/orderDay",compact("datas"));
    }

    public function dx()
    {
//        $shop_id = Auth::user()->shop_id;
//        $now = date("Y-m-d");
//        $orders =  Order::where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"),$now)
//            ->where("shop_id",$shop_id)
//            ->get();
//        $amount = 0;
//        foreach ($orders as $k=>$order){
//            $data[$k] = OrderDetail::select(DB::raw("goods_name,SUM(amount) as count"))
//                ->where("order_id",$order->id)
//                ->groupBy("goods_id")
//                ->get();
//        }
//        dd($data);
//        return view("shop/statistics/volume",compact("datas"));
    }
}
