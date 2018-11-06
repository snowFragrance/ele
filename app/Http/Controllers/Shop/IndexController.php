<?php

namespace App\Http\Controllers\Shop;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        //得到shop_id
        $shop_id = Auth::user()->shop_id;

        //查询今日订单和收入
        $now = date("Y-m-d");
        $shop["num"]=  Order::where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"),$now)
            ->select(DB::raw("COUNT(*) as num"))
            ->where("shop_id",$shop_id)
            ->get();

        $shop["money"]=  Order::where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"),$now)
            ->where("status",">",0)
            ->select(DB::raw("SUM(total) as money"))
            ->where("shop_id",$shop_id)
            ->get();

        //查询月订单和收入
        $month = date("Y-m");
        $shop["mn"]=  Order::where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"),$month)
            ->select(DB::raw("COUNT(*) as num"))
            ->where("shop_id",$shop_id)
            ->get();

        $shop["mm"]=  Order::where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"),$month)
            ->where("status",">",0)
            ->select(DB::raw("SUM(total) as money"))
            ->where("shop_id",$shop_id)
            ->get();

        //查询总订单和收入
        $shop["cn"] = Order::select(DB::raw('count(*) as num'))
            ->where("shop_id",$shop_id)
            ->get();

        $shop["cm"] = Order::select(DB::raw('SUM(total) as money'))
            ->where("status",">",0)
            ->where("shop_id",$shop_id)
            ->get();

        //查询今日销量
        $orders =  Order::where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"),$now)
            ->where("shop_id",$shop_id)
            ->get();
        $shop["amount"] = 0;
        foreach ($orders as $order){
            $date = OrderDetail::where("order_id",$order->id)->get();
            foreach ($date as $de){
                $shop['amount'] += $de->amount;
            }
        }
//        dd($shop["amount"]);

        //查询月销量
        $mos =  Order::where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"),$month)
            ->where("shop_id",$shop_id)
            ->get();
        $shop["m"] = 0;
        foreach ($mos as $mo){
            $date = OrderDetail::where("order_id",$mo->id)->get();
            foreach ($date as $d){
                $shop['m'] += $d->amount;
            }
        }

        //查询总销量
        $total = Order::where("shop_id",$shop_id)->get();
        $shop['total'] = 0;
        foreach ($total as $z){
            $date = OrderDetail::where("order_id",$z->id)->get();
            foreach ($date as $da){
                $shop['total'] += $da->amount;
            }
        }
        return view("shop.index.index",compact("shop"));
    }

}
