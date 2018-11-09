@extends("shop.layouts.main")
@section("title","商家分类列表")
@section("content")
    <table class="table">
        <tr>
            <th>活动标题</th>
            <th>活动详情</th>
            <th>开始时间</th>
            <th>结束时间</th>
            <th>操作</th>
        </tr>
        @foreach($activities as $activity)
        <tr>
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

    <table class="table">
        <tr>
            <th>活动标题</th>
            <th>活动详情</th>
            <th>报名开始时间</th>
            <th>报名结束时间</th>
            <th>开奖时间</th>
            <th>操作</th>
        </tr>

        @foreach($events as $event)
            <tr>
                <td>{{$event->title}}</td>
                <td>{!! substr("$event->content",0,27) !!}</td>
                <td>{{$event->start}}</td>
                <td>{{$event->end}}</td>
                <td>{{$event->prize}}</td>
                <td>
                    <a href="{{route("shop.activity.event",$event->id)}}" class="btn btn-success">查看详情</a>
                    <a href="{{route('shop.activity.enroll',$event->id)}}" class="btn btn-success">立即报名</a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection