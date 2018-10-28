@extends("shop.layouts.main")
@section("title","商家分类列表")
@section("content")
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
                <a href="{{route("shop.activity.xq",$activity->id)}}" class="btn btn-success">查看详情</a>
            </td>
        </tr>
            @endforeach
    </table>

@endsection