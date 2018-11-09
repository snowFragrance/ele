@extends("admin.layouts.main")
@section('title','一级导航添加')
@section('content')
    <form class="form-horizontal" action="" method="post">
        {{csrf_field()}}
        <div class="form-group">
            <label class="col-sm-2 control-label">名称</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">路由</label>
            <div class="col-sm-10">
                <select name="url" id="">
                    @foreach($urls as $url)
                        <option value="{{$url}}">{{$url}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">排序</label>
            <div class="col-sm-10">
                <input type="text" name="sort" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">父级</label>
            <div class="col-sm-10">
                <select name="pid" id="">
                    @foreach($navy as $nav)
                        <option value="{{$nav->id}}">{{$nav->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">提交</button>
            </div>
        </div>
    </form>
@endsection