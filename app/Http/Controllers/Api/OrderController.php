<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Member;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class OrderController extends Controller
{
    public function add(Request $request)
    {
        //接收用户id和地址id
        $user_id = $request->post("user_id");
        $address_id = $request->post("address_id");
        //根据地址id找出相应的地址
        $address = Address::find($address_id);
        if ($address === null) {
            return [
                "status" => "false",
                "message" => "地址选择不正确"
            ];
        }
        //根据用户id找出购物车里面的商品id
        $goods = Cart::where("user_id",$user_id)->get();
        //总价
        $total = 0;
        foreach ($goods as $k => $good){
            //根据商品id找出店铺id
            $shop_id = Menu::find($good->goods_id)->shop_id;
            //根据商品找出对应价格
            $total += Menu::find($good->goods_id)->goods_price * $good->amount;
        }
        //根据店铺id找出配送费,并将它加入总价
        $data["total"] = $total+Shop::find($shop_id)->send_cost;
        //订单编号
        $data["order_code"] = date("ymdHis").rand(1000,9999);
        //状态
        $data["status"] = 0;
        //将数据追加到data中
        $data["user_id"] = $user_id;
        $data["shop_id"] = $shop_id;
        $data["provence"] = $address->provence;
        $data["city"] = $address->city;
        $data["area"] = $address->area;
        $data["address"] = $address->detail_address;
        $data["tel"] = $address->tel;
        $data["name"] = $address->name;
//        dd($data);

        //订单商品表

        /**
         * 订单id
         * 商品id
         * 商品数量
         * 商品信息 名字、图片、价格
         */
        DB::beginTransaction();
        try{
            //订单入库
            $order = Order::create($data);
            //商品
            foreach ($goods as $kk => $cart){
                //得到当前菜品
                $menu = Menu::find($cart->goods_id);
                //判断库存是否充足
                if ($cart->amount>$menu->stock){
                    //抛出异常
                    throw  new \Exception($menu->goods_name." 库存不足");
                }
                //减去库存
                $menu->stock=$menu->stock-$cart->amount;
                //保存
                $menu->save();
                OrderDetail::insert([
                    'order_id'=>$order->id,
                    'goods_id'=>$cart->goods_id,
                    'amount'=>$cart->amount,
                    'goods_name'=>$menu->goods_name,
                    'goods_img'=>$menu->goods_img,
                    'goods_price'=>$menu->goods_price
                ]);
            }

            //清空购物车
            Cart::where("user_id",$request->post('user_id'))->delete();
            //提交事务
            DB::commit();
        }catch (\Exception $exception){
            //回滚
            DB::rollBack();
            return [
                "status" => "false",
                "message" => $exception->getMessage(),
            ];
        }

        return [
            "status" => "true",
            "message" => "添加成功",
            "order_id" => $order->id
        ];
    }

    public function order(Request $request)
    {
        $order = Order::find($request->input('id'));
        $data['id'] = $order->id;
        $data['order_code'] = $order->order_code;
        $data['order_birth_time'] = (string)$order->created_at;
        $data['order_status'] = $order->order_status;
        $data['shop_id'] = $order->shop_id;
        $data['shop_name'] = $order->shop->shop_name;
        $data['shop_img'] = $order->shop->shop_img;
        $data['order_price'] = $order->total;
        $data['order_address'] = $order->provence . $order->city . $order->area . $order->detail_address;
        $data['goods_list'] = $order->goods;
        //接收参数：号码
        $tel = Member::find($order->user_id)->tel;
//        dd($tel);
        //生成随机数
        $code = '下单成功';

        //将号码和随机数用redis保存
//        Redis::setex("tel_" . $tel, 60 * 5, $code);

        //把验证码发给手机
        //TODO

        $data['d'] = [
            "status" => true,
            "message" => $code
        ];
        return $data;
    }

    public function pay(Request $request)
    {
        // 得到订单
        $order = Order::find($request->post('id'));
        //得到用户
        $member = Member::find($order->user_id);
        //判断钱够不够
        if ($order->total > $member->money) {
            return [
                'status' => 'false',
                "message" => "用户余额不够，请充值"
            ];
        }
        //否则扣钱
        $member->money = $member->money - $order->total;
        $member->save();
        //更改订单状态
        $order->status = 1;
        $order->save();
        return [
            'status' => 'true',
            "message" => "支付成功"
        ];
    }

    public function list(Request $request)
    {
        $orders = Order::where("user_id", $request->input('user_id'))->get();
        $datas=[];
        foreach ($orders as $order) {
            $data['id'] = $order->id;
            $data['order_code'] = $order->order_code;
            $data['order_birth_time'] = (string)$order->created_at;
            $data['order_status'] = $order->order_status;
            $data['shop_id'] = (string)$order->shop_id;
            $data['shop_name'] = $order->shop->shop_name;
            $data['shop_img'] = $order->shop->shop_img;
            $data['order_price'] = $order->total;
            $data['order_address'] = $order->provence . $order->city . $order->area . $order->detail_address;
            $data['goods_list'] = $order->goods;
            $datas[] = $data;
        }
//        dd($datas);
        return $datas;
    }
}
