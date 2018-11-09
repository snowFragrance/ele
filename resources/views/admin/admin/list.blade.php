@extends("admin.layouts.main")
@section('title','员工列表')
@section('content')
    <table class="table">
        <tr>
            <th>姓名</th>
            <th>邮箱</th>
            <th>角色</th>
            <th>编辑</th>
        </tr>
        @foreach($admins as $admin)
            <tr>
                <td>{{$admin->name}}</td>
                <td>{{$admin->email}}</td>
                <td>{{str_replace(["[","]",'"'],"",json_encode($admin->getRoleNames(),JSON_UNESCAPED_UNICODE))}}</td>
                <td>
                    <a href="{{route('admin.admin.edit',$admin->id)}}" class="btn btn-success">编辑</a>
                    <a href="{{route('admin.admin.del',$admin->id)}}" class="btn btn-danger">删除</a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection