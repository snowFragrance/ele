@extends("shop.layouts.main")
@section("title","菜品列表")
@section("content")
    <a href="{{route("shop.menu.add")}}" class="btn btn-success">添加</a>
    <table class="table">
        <tr>
            <th>id</th>
            <th>名称</th>
            <th>图片</th>
            <th>分类</th>
            <th>价格</th>
            <th>描述</th>
            <th>月销量</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        @foreach($menus as $menu)
        <tr>
            <td>{{$menu->id}}</td>
            <td>{{$menu->goods_name}}</td>
            <td><img src="{{env("ALIYUN_OSS_URL").$menu->goods_img}}" alt="" height="50"></td>
            <td>{{$menu->category_id}}</td>
            <td>{{$menu->goods_price}}</td>
            <td>{{$menu->description}}</td>
            <td>{{$menu->month_sales}}</td>
            <td>
                @if($menu->status) 上架 @endif
                @if(!$menu->status) 下架 @endif
            </td>
            <td>
                <a href="{{route("shop.menu.edit",$menu->id)}}" class="btn btn-success"><span class="glyphicon glyphicon-edit"></span></a>
                <a href="{{route("shop.menu.del",$menu->id)}}" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
            </td>
        </tr>
            @endforeach
    </table>

@endsection