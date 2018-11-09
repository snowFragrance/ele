@extends("admin.layouts.main")
@section("title","商家分类列表")
@section("content")
    <form class="form-horizontal" method="post">
        {{csrf_field()}}
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">活动</label>
            <div class="col-sm-10">
                <select name="event_id" class="form-control" id="inputEmail3">
                    @foreach($events as $event)
                        <option value="{{$event->id}}" @if($ep->event_id == $event->id) selected @endif>{{$event->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">奖品</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputEmail3" placeholder="奖品名称" name="name" value="{{$ep->name,old("name")}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">详情</label>
            <div class="col-sm-10">
                <script id="container"  name="description" type="text/plain">{!! $ep->description !!}{{old("description")}}</script>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">用户</label>
            <div class="col-sm-10">
                <select name="user_id" class="form-control" id="inputEmail3">
                    <option value="0">--请选择--</option>
                    @foreach($users as $user)
                        <option value="{{$user->id}}" @if($ep->user_id == $user->id) selected @endif>{{$user->name}}</option>
                    @endforeach
                </select>
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