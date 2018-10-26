@extends("admin.layouts.main")
@section("title","商家分类列表")
@section("content")
    <a href="{{route("admin.user.add")}}" class="btn btn-success">添加</a>
    <table class="table">
        <tr>
            <th>id</th>
            <th>店铺名称</th>
            <th>店铺类别</th>
            <th>店铺图片</th>
            <th>店铺评分</th>
            <th>店铺标签</th>
            <th>起送金额</th>
            <th>配送费</th>
            <th>店公告</th>
            <th>优惠信息</th>
            <th>操作</th>
        </tr>
        @foreach($shops as $shop)
        <tr>
            <td>{{$shop->id}}</td>
            <td>{{$shop->shop_category_id}}</td>
            <td>{{$shop->shop_name}}</td>
            <td><img src="/{{$shop->shop_img}}" alt="" height="80"></td>
            <td>{{$shop->shop_rating}}</td>
            <td></td>
            <td>{{$shop->start_send}}</td>
            <td>{{$shop->send_cost}}</td>
            <td>{{$shop->notice}}</td>
            <td>{{$shop->discount}}</td>
            <td>
                <a href="{{route("admin.user.edit",$shop->id)}}" class="btn btn-success"><span class="glyphicon glyphicon-edit"></span></a>
                <a href="{{route("admin.user.del",$shop->id)}}" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                <a href="{{route("admin.user.reset",$shop->id)}}" class="btn btn-info"><span class="glyphicon glyphicon-refresh"></span></a>
            </td>
        </tr>
            @endforeach
    </table>

@endsection