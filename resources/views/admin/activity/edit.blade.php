@extends("admin.layouts.main")
@section("title","商家分类列表")
@section("content")
    <form class="form-horizontal" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">标题</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputEmail3" placeholder="标题" name="title" value="{{$activity->title}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">详情</label>
            <div class="col-sm-10">
                <script id="container" name="content" type="text/plain">{!!$activity->content!!}</script>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">开始时间</label>
            <div class="col-sm-10">
                <input type="datetime-local" class="form-control" placeholder="活动开始时间" name="start_time" value="{{$activity->start_time}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">结束时间</label>
            <div class="col-sm-10">
                <input type="datetime-local" class="form-control" id="inputEmail3" placeholder="活动结束时间" name="end_time" value="{{$activity->end_time}}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <a class="btn btn-info" href="{{url()->previous()}}">返回</a>
                <button type="submit" class="btn btn-success">编辑</button>
            </div>
        </div>
    </form>

@endsection