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
            return redirect()->route("admin.admin.index")->with('success', '创建' . $admin->name . '成功');
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
                return redirect()->intended(route("admin.shopCate.index"))->with("success","登录成功");
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

    public function index()
    {
        $shops = Shop::all();

        //今日订单
        $now = date("Y-m-d");
        foreach ($shops as $k=>$shop){
            $shops[$k]['num']=Order::where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"),$now)
                ->select(DB::raw("COUNT(*) as num"))
                ->where("shop_id",$shop->id)
                ->get();
        }

        foreach ($shops as $k=>$shop){
            $shops[$k]['dm']=Order::where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"),$now)
                ->where("status",">",0)
                ->select(DB::raw("SUM(total) as money"))
                ->where("shop_id",$shop->id)
                ->get();
        }

        //月订单
        $month = date("Y-m");
        foreach ($shops as $k=>$shop){
            $shops[$k]['month']=Order::where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"),$month)
                ->select(DB::raw("COUNT(*) as num"))
                ->where("shop_id",$shop->id)
                ->get();
        }

        foreach ($shops as $k=>$shop){
            $shops[$k]['mm']=Order::where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"),$month)
                ->where("status",">",0)
                ->select(DB::raw("SUM(total) as mon"))
                ->where("shop_id",$shop->id)
                ->get();
        }

        //总订单
        foreach ($shops as $k=>$shop){
            $shops[$k]['total']=Order::select(DB::raw("COUNT(*) as num"))
                ->where("shop_id",$shop->id)
                ->get();
        }

        //今日销量
        foreach ($shops as $k=>$shop){
            $shops[$k]['qm']=Order::where("status",">",0)
                ->select(DB::raw("SUM(total) as money"))
                ->where("shop_id",$shop->id)
                ->get();
        }

        foreach ($shops as $kk=>$shop){
            $orders =  Order::where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"),$now)
                ->where("shop_id",$shop->id)
                ->get();
            $shops[$kk]["amount"] = 0;
            foreach ($orders as $order){
                $date = OrderDetail::where("order_id",$order->id)->get();
                foreach ($date as $de){
                    $shops[$kk]['amount'] += $de->amount;
                }
            }
        }

        //月销量
        foreach ($shops as $k=>$shop){
            $shops[$k]['wm']=Order::where("status",">",0)
                ->select(DB::raw("SUM(total) as money"))
                ->where("shop_id",$shop->id)
                ->get();
        }

//        foreach ($shops as $kk=>$shop){
//            $orders =  Order::where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"),$month)
//                ->where("shop_id",$shop->id)
//                ->get();
//            $shops[$kk]["month"] = 0;
//            foreach ($orders as $order){
//                $date = OrderDetail::where("order_id",$order->id)->get();
//                foreach ($date as $de){
//                    $shops[$kk]['month'] += $de->amount;
//                }
//            }
//        }

//        dd($shops);
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
}
