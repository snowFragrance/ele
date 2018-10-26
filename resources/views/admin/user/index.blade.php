@extends("admin.layouts.main")
@section("title","商家分类列表")
@section("content")
    <a href="{{route("admin.user.add")}}" class="btn btn-success">添加</a>
    <table class="table">
        <tr>
            <th>id</th>
            <th>姓名</th>
            <th>邮箱</th>
            <th>店铺id</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->shop_id}}</td>
            <td>{{$user->created_at}}</td>
            <td>
                <a href="{{route("admin.user.edit",$user->id)}}" class="btn btn-success"><span class="glyphicon glyphicon-edit"></span></a>
                <a href="{{route("admin.user.del",$user->id)}}" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                <a href="{{route("admin.user.reset",$user->id)}}" class="btn btn-info"><span class="glyphicon glyphicon-refresh"></span></a>
            </td>
        </tr>
            @endforeach
    </table>

@endsection