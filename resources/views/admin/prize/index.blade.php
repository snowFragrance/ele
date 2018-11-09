@extends("admin.layouts.main")
@section("title","商家分类列表")
@section("content")
    <div class="form-inline pull-left"><a href="{{route("admin.prize.add")}}" class="btn btn-success">添加</a></div>
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
            <th>活动</th>
            <th>奖品名</th>
            <th>奖品详情</th>
            <th>中奖用户</th>
            <th>操作</th>
        </tr>
        @foreach($eps as $ep)
        <tr>
            <td>{{$ep->event}}</td>
            <td>{{$ep->name}}</td>
            <td>{!! $ep->description !!}</td>
            <td>@if($ep->user_id == 0) @endif {{$ep->user}}</td>
            <td>
                <a href="{{route("admin.prize.edit",$ep->id)}}" class="btn btn-success"><span class="glyphicon glyphicon-edit"></span></a>
                <a href="{{route("admin.prize.del",$ep->id)}}" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
            </td>
        </tr>
            @endforeach
    </table>
{{--    {{$events->appends($url)->links()}}--}}
@endsection