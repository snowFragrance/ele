@extends("shop.layouts.main")

@section("title","订单列表")

@section("content")
    <a class="btn btn-instagram" href="{{route("shop.index.index")}}">返回</a>

    <table class="table">
        <tr>
            <th>图片</th>
            <th>名称</th>
            <th>数量</th>
            <th>价格</th>
            <th>操作</th>
        </tr>
        @foreach($datas as $data)
        <tr>
            <td><img src="{{$data->goods_img}}" alt="" width="80"></td>
            <td>{{$data->goods_name}}</td>
            <td>{{$data->amount}}</td>
            <td>{{$data->goods_price}}</td>
            <td>
                <a href="{{route("shop.details",$data->id)}}" class="btn btn-success">详情</a>
            </td>
        </tr>
            @endforeach
    </table>

@endsection