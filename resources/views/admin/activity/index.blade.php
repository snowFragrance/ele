@extends("admin.layouts.main")
@section("title","商家分类列表")
@section("content")
    <div class="form-inline pull-left"><a href="{{route("admin.activity.add")}}" class="btn btn-success">添加</a></div>
    <div class="row">
        <div class="col-md-8 pull-right">
            <form class="form-inline pull-right" method="get">
                <select name="select" id="" class="form-control">
                     <option value="">所有</option>
                     <option value="0">未开始</option>
                     <option value="1">进行中</option>
                     <option value="2">已结束</option>
                </select>
                <div class="form-group">
                    <input type="text" class="form-control"  placeholder="请输入关键字" name="keyword" value="{{request()->get('keyword')}}">
                </div>
                <button type="submit" class="btn btn-info">搜索</button>
            </form>
        </div>
    </div>
    <table class="table">
        <tr>
            <th>id</th>
            <th>活动标题</th>
            <th>活动详情</th>
            <th>开始时间</th>
            <th>结束时间</th>
            <th>操作</th>
        </tr>
        @foreach($activities as $activity)
        <tr>
            <td>{{$activity->id}}</td>
            <td>{{$activity->title}}</td>
            <td>{!! substr("$activity->content",0,9) !!}</td>
            <td>{{$activity->start_time}}</td>
            <td>{{$activity->end_time}}</td>
            <td>
                <a href="{{route("admin.activity.edit",$activity->id)}}" class="btn btn-success"><span class="glyphicon glyphicon-edit"></span></a>
                <a href="{{route("admin.activity.del",$activity->id)}}" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
            </td>
        </tr>
            @endforeach
    </table>
    {{$activities->appends($url)->links()}}
@endsection