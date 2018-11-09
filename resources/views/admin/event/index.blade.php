@extends("admin.layouts.main")
@section("title","商家分类列表")
@section("content")
    <a href="{{route("admin.event.add")}}" class="btn btn-success">添加</a>
    <table class="table">
        <tr>
            <th>标题</th>
            <th>详情</th>
            <th>报名开始时间</th>
            <th>报名结束时间</th>
            <th>开奖时间</th>
            <th>人数限制</th>
            <th>开奖情况</th>
            <th>操作</th>
        </tr>
        @foreach($events as $event)
        <tr>
            <td>{{$event->title}}</td>
            <td>{!! substr("$event->content",0,27) !!}</td>
            <td>{{$event->start}}</td>
            <td>{{$event->end}}</td>
            <td>{{$event->prize}}</td>
            <td>{{$event->num}}</td>
            <td>
                @if($event->is_prize == 1) 未开奖 @endif
                @if($event->is_prize < 1) 已开奖 @endif
            </td>
            <td>
                @if($event->is_prize == 1 && $event->prize <= now())
                    <a href="{{route("admin.event.lottery",$event->id)}}" class="btn btn-success"><span class="glyphicon glyphicon-gift"></span></a>
                @endif
                <a href="{{route("admin.event.edit",$event->id)}}" class="btn btn-success"><span class="glyphicon glyphicon-edit"></span></a>
                <a href="{{route("admin.event.del",$event->id)}}" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
            </td>
        </tr>
            @endforeach
    </table>
{{--    {{$events->appends($url)->links()}}--}}
@endsection