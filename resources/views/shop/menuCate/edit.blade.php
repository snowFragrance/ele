@extends("shop.layouts.main")

@section("content")
        <form class="form-horizontal" method="post">
            {{csrf_field()}}
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">名称</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputEmail3" placeholder="分类名" name="name" value="{{$cate->name}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">编号</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputEmail3" placeholder="菜品编号" name="number" value="{{$cate->number}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">描述</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputPassword3" placeholder="描述" name="description" value="{{$cate->description}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">
                </label>
                <div class="col-sm-10">
                    <input type="checkbox"  name="is_selected" @if($cate->is_selected) checked @endif value="1">默认分类&nbsp;
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