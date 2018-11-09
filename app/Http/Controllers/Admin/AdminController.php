<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Member;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AdminController extends BaseController
{
    //
    public function reg(Request $request)
    {
        if ($request->isMethod("post")){
            //验证
            $data = $this->validate($request,[
                "name"=>"required",
                "password" => "required|min:6|confirmed",
                "email"=>"email"
            ]);
            $data['password'] = bcrypt($data['password']);
            $admin=Admin::create($data);
            //给管理员添加角色并同步角色
            $admin->syncRoles($request->post('role'));
            return redirect()->route("admin.admin.list")->with('success', '创建' . $admin->name . '成功');
        }
        //得到所有角色
        $roles=Role::all();
        return view("admin.admin.reg",compact("roles"));
    }
    
    public function login(Request $request){
        if ($request->isMethod("post")){
            //1. 验证
            $data = $this->validate($request, [
                "name" => "required",
                "password" => "required"
            ]);
            if (Auth::guard("admin")->attempt($data,$request->has("remember"))){
                //登录成功
                return redirect()->intended(route("admin.admin.index"))->with("success","登录成功");
            }else{
                //登录失败
                return redirect()->back()->withInput()->with("danger","账号或密码错误");
            }
        }

        return view("admin.admin.login");
    }

    public function logout()
    {
        Auth::guard("admin")->logout();
        return redirect()->route("admin.admin.login");
    }

    public function change(Request $request,$id)
    {
        $admin = Admin::find($id);
        if ($request->post()){
            $data = $this->validate($request,[
                "password" => "required|min:6|confirmed",
            ]);
            $data["password"]= bcrypt($data['password']);
            $admin->update($data);
            return redirect()->route("admin.shopCate.index")->with("success","修改成功");
        }
        return view("admin.admin.change",compact("admin"));
    }

    public function index(Request $request)
    {
        $shops = Shop::all();

        $select =$request->get("now");
        $keyword=$request->get("keyword");

        //总订单
        if ($select == 2){
            foreach ($shops as $e=>$shop){
                $shops[$e]['num']=Order::select(DB::raw("COUNT(*) as num"))
                    ->where("shop_id",$shop->id)
                    ->get();
            }

            //总金额
            foreach ($shops as $r=>$shop){
                $shops[$r]['money']=Order::where("status",">",0)
                    ->select(DB::raw("SUM(total) as money"))
                    ->where("shop_id",$shop->id)
                    ->get();
            }

            //销量
            foreach ($shops as $rr=>$shop){
                $orders =  Order::where("status",">",0)
                    ->where("shop_id",$shop->id)
                    ->get();
                $shops[$rr]["amount"] = 0;
                foreach ($orders as $order){
                    $date = OrderDetail::where("order_id",$order->id)->get();
                    foreach ($date as $de){
                        $shops[$rr]['amount'] += $de->amount;
                    }
                }
            }
            return view("admin/admin/index",compact("shops"));
        }

        //今日订单
        if ($select == 0){
            $now = date("Y-m-d");
            $ymd = '%Y-%m-%d';
        }

        //月订单
        if ($select == 1){
            $now = date("Y-m");
            $ymd = '%Y-%m';
        }

        /**
         * num:订单数量
         * money：总金额
         * amount:销量
         */

        foreach ($shops as $k=>$shop){
            $shops[$k]['num']=Order::where(DB::raw("DATE_FORMAT(created_at, '".$ymd."')"),$now)
                ->select(DB::raw("COUNT(*) as num"))
                ->where("shop_id",$shop->id)
                ->get();
        }

        foreach ($shops as $kk=>$shop){
            $shops[$kk]['money']=Order::where(DB::raw("DATE_FORMAT(created_at, '".$ymd."')"),$now)
                ->where("status",">",0)
                ->select(DB::raw("SUM(total) as money"))
                ->where("shop_id",$shop->id)
                ->get();
        }



        foreach ($shops as $rr=>$shop){
            $orders =  Order::where(DB::raw("DATE_FORMAT(created_at, '".$ymd."')"),$now)
                ->where("shop_id",$shop->id)
                ->get();
            $shops[$rr]["amount"] = 0;
            foreach ($orders as $order){
                $date = OrderDetail::where("order_id",$order->id)->get();
                foreach ($date as $de){
                    $shops[$rr]['amount'] += $de->amount;
                }
            }
        }

        return view("admin/admin/index",compact("shops"));
    }

    public function list()
    {
        $admins = Admin::all();
        return view('admin.admin.list',compact('admins'));
    }

    public function edit(Request $request,$id)
    {
        $admin = Admin::find($id);
        if ($request->isMethod('post')){
            //验证
            $data = $this->validate($request,[
                "name"=>"required",
                "email"=>"email"
            ]);
            $role = $request->post('role');
//            dd($data,$role);
            $admin->update($data);
            //给管理员添加角色并同步角色
            $admin->syncRoles($request->post('role'));
            return redirect()->route("admin.admin.list")->with('success', '修改成功');
        }
        $roles=Role::all();
//        dd($roles);
        return view('admin.admin.edit',compact('admin','roles'));
    }

    public function del($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return redirect()->route("admin.admin.list")->with('success', '删除成功');
    }
}
