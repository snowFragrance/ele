@extends("admin.layouts.main")
@section("title","商家分类列表")
@section("content")
    <form class="form-horizontal" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">标题</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputEmail3" placeholder="标题" name="title" value="{{old("title")}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">详情</label>
            <div class="col-sm-10">
                <script id="container"  name="content" type="text/plain">{{old("content")}}</script>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">报名开始时间</label>
            <div class="col-sm-10">
                <input type="datetime-local" class="form-control" placeholder="报名开始时间" name="start" value="{{old("start")}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">报名结束时间</label>
            <div class="col-sm-10">
                <input type="datetime-local" class="form-control" id="inputEmail3" placeholder="报名结束时间" name="end" value="{{old("end")}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">开奖时间</label>
            <div class="col-sm-10">
                <input type="datetime-local" class="form-control" id="inputEmail3" placeholder="开奖时间" name="prize" value="{{old("prize")}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">报名人数</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="inputEmail3" placeholder="允许报名人数" name="num" value="{{old("num")}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">是否已开奖</label>
            <div class="col-sm-10">
                <input type="radio" id="inputEmail3" name="is_prize" value="0">是
                <input type="radio" id="inputEmail3" name="is_prize" value="1">否
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <a class="btn btn-info" href="{{url()->previous()}}">返回</a>
                <button type="submit" class="btn btn-success">添加</button>
            </div>
        </div>
    </form>

@endsection