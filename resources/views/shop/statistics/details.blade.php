@extends("shop.layouts.main")

@section("title","今日订单")

@section("content")
    <table class="table">
        <tr><th>{{$order->username}}</th></tr>
        @foreach($details as $detail)
            <tr>
                <td><img src="{{$detail->goods_img}}" alt="" width="80"></td>
                <td>{{$detail->goods_name}}</td>
                <td>{{$detail->amount}}</td>
                <td>￥{{$detail->goods_price}}</td>
            </tr>
        @endforeach
        <th></th>
        <tr><th>配送信息</th></tr>
        <tr>
            <td>收货名</td>
            <td>{{$order->name}}</td>
        </tr>
        <tr>
            <td>电话号码</td>
            <td>{{$order->tel}}</td>
        </tr>
        <tr>
            <td>收货地址</td>
            <td>{{$order->provence.$order->city.$order->area.$order->address}}</td>
        </tr>
        <th></th>

        <tr><th>订单信息</th></tr>
        <tr>
            <td>订单号</td>
            <td>{{$order->order_code}}</td>
        </tr>
        <tr>
            <td>下单时间</td>
            <td>{{$order->created_at}}</td>
        </tr>
    </table>
    <a class="btn btn-info" href="{{url()->previous()}}">返回</a>
@endsection