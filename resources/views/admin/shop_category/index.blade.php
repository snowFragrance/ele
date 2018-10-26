@extends("admin.layouts.main")
@section("title","商家分类列表")
@section("content")
    <a href="{{route("admin.shopCate.add")}}" class="btn btn-success">添加</a>
    <table class="table">
        <tr>
            <th>id</th>
            <th>分类名</th>
            <th>分类图片</th>
            <th>排序</th>
            <th>分类状态</th>
            <th>操作</th>
        </tr>
        @foreach($cates as $cate)
        <tr>
            <td>{{$cate->id}}</td>
            <td>{{$cate->name}}</td>
            <td><img src="/{{$cate->img}}" alt="" height="50"></td>
            <td>{{$cate->sort}}</td>
            <td>@if($cate->status) <span class="glyphicon glyphicon-eye-open"></span>@endif
                @if(!$cate->status) <span class="glyphicon glyphicon-eye-close"></span>@endif
            </td>
            <td>
                <a href="{{route("admin.shopCate.edit",$cate->id)}}" class="btn btn-success"><span class="glyphicon glyphicon-edit"></span></a>
                <a href="{{route("admin.shopCate.del",$cate->id)}}" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
            </td>
        </tr>
            @endforeach
    </table>

@endsection