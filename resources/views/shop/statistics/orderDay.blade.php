@extends("shop.layouts.main")

@section("title","订单列表")

@section("content")
    <a class="btn btn-instagram" href="{{route("shop.index.index")}}">返回</a>

    <table class="table">
        <tr>
            <th>订单编号</th>
            <th>客户名</th>
            <th>配送姓名</th>
            <th>电话号码</th>
            <th>详细地址</th>
            <th>下单时间</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        @foreach($datas as $data)
        <tr>
            <td>{{$data->order_code}}</td>
            <td>{{$data->username}}</td>
            <td>{{$data->name}}</td>
            <td>{{$data->tel}}</td>
            <td>{{$data->address}}</td>
            <td>{{$data->created_at}}</td>
            <td>{{$data->status}}</td>
            <td>
                <a href="{{route("shop.details",$data->id)}}" class="btn btn-success">详情</a>
                @if($data->status == "待发货")
                    <a href="{{route("shop.fh",$data->id)}}" class="btn btn-success">发货</a>
                    <a href="{{route("shop.cancel",$data->id)}}" class="btn btn-danger">取消</a>
                @endif
                @if($data->status == "待确认")
                    <a href="{{route("shop.fh",$data->id)}}" class="btn btn-success">确认</a>
                @endif
            </td>
        </tr>
            @endforeach
    </table>

@endsection