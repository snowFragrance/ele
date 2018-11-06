@extends("shop.layouts.main")
@section("title","商家分类列表")
@section("content")
    <h2>{{$activity->title}}</h2>
    <h5>开始时间：{{$activity->start_time}} &emsp;结束时间：{{$activity->end_time}}</h5>
    <pre>{!!$activity->content!!}</pre>
    <a class="btn btn-info" href="{{url()->previous()}}">返回</a>
@endsection