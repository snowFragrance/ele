@extends("shop.layouts.main")
@section("title","活动详情")
@section("content")
    <h2>{{$event->title}}</h2>
    <h5>报名时间：{{$event->start}} — {{$event->end}} &emsp;开奖时间：{{$event->prize}}</h5>
    <pre>{!!$event->content!!}</pre>
    <a class="btn btn-info" href="{{url()->previous()}}">返回</a>
    <a class="btn btn-success" href="{{route('shop.activity.enroll',$event->id)}}">立即报名</a>
@endsection