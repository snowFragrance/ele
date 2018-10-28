@extends("shop.layouts.main")
@section("title","商品分类管理")
@section("content")
    <a href="{{route("shop.menuCate.add")}}" class="btn btn-success">添加</a>
    <table class="table">
        <tr>
            <th>id</th>
            <th>名称</th>
            <th>菜单编号</th>
            <th>描述</th>
            <th>默认分类</th>
            <th>操作</th>
        </tr>
        @foreach($gories as $gory)
        <tr>
            <td>{{$gory->id}}</td>
            <td>{{$gory->name}}</td>
            <td>{{$gory->number}}</td>
            <td>{{$gory->description}}</td>
            <td>
                @if($gory->is_selected) <span class="glyphicon glyphicon-ok-sign"></span> @endif
                @if(!$gory->is_selected)
                        <a href="{{route("shop.menuCate.check",$gory->id)}}">
                            <span class="glyphicon glyphicon-ok-circle"></span>
                        </a>
                @endif
            </td>
            <td>
                <a href="{{route("shop.menuCate.edit",$gory->id)}}" class="btn btn-success"><span class="glyphicon glyphicon-edit"></span></a>
                <a href="{{route("shop.menuCate.del",$gory->id)}}" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
            </td>
        </tr>
            @endforeach
    </table>

@endsection