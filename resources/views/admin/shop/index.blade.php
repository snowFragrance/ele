@extends("admin.layouts.main")
@section("title","商家分类列表")
@section("content")
    <a href="{{route("admin.user.add")}}" class="btn btn-success">添加</a>
    <table class="table">
        <tr>
            <th>id</th>
            <th>店铺名称</th>
            <th>用户id</th>
            <th>店铺类别</th>
            <th>店铺图片</th>
            <th>店铺评分</th>
            <th>起送金额</th>
            <th>配送费</th>
            <th>店公告</th>
            <th>优惠信息</th>
            <th>操作</th>
        </tr>
        @foreach($shops as $shop)
        <tr>
            <td>{{$shop->id}}</td>
            <td>{{$shop->shop_name}}</td>
            <td>{{$shop->user_id}}</td>
            <td>{{$shop->name}}</td>
            <td><img src="/{{$shop->shop_img}}" alt="" height="80"></td>
            <td>{{$shop->shop_rating}}</td>
            <td>{{$shop->start_send}}</td>
            <td>{{$shop->send_cost}}</td>
            <td>{{$shop->notice}}</td>
            <td>{{$shop->discount}}</td>
            <td>
                <a href="{{route("admin.shop.edit",$shop->id)}}" class="btn btn-success"><span class="glyphicon glyphicon-edit"></span></a>
                <a href="{{route("admin.shop.del",$shop->id)}}" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                @if($shop->status == 0)
                    <a href="{{route("admin.shop.examine",$shop->id)}}" class="btn btn-info"><span class="glyphicon glyphicon-ok"></span></a>
                @endif
            </td>
        </tr>
            @endforeach
    </table>

@endsection