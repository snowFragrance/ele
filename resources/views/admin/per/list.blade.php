@extends("admin.layouts.main")
@section("title","权限添加")
@section("content")
    <a href="{{route("admin.per.add")}}" class="btn btn-info">添加</a>
    <table class="table">
        <tr>
            <th>名称</th>
            <th>描述</th>
            <th>操作</th>
        </tr>
        @foreach($pers as $per)
            <tr>
                <td>{{$per->name}}</td>
                <td>{{$per->intro}}</td>
                <td>
                    <a href="{{route("admin.per.edit",$per->id)}}" class="btn btn-success">编辑</a>
                    <a href="#" class="btn btn-danger">删除</a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection