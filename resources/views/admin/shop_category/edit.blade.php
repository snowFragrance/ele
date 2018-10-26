@extends("admin.layouts.main")
@section("title","商家分类列表")
@section("content")
    <form class="form-horizontal" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label"></label>
            <div class="col-sm-10">
                <img src="/{{$cate->img}}" alt="" height="80">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">分类名</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputEmail3" placeholder="分类名" name="name" value="{{$cate->name}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">图片</label>
            <div class="col-sm-10">
                <input type="file" class="form-control" id="inputPassword3" name="img">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">状态</label>
            <div class="col-sm-10">
                <input type="radio" placeholder="分类名" name="status" value="1" @if ($cate->status) checked @endif>显示
                <input type="radio" placeholder="分类名" name="status" value="0" @if (!$cate->status) checked @endif>隐藏
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">排序</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputEmail3" placeholder="排序" name="sort" value="{{$cate->sort}}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-success">编辑</button>
            </div>
        </div>
    </form>

@endsection