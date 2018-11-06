@extends("admin.layouts.main")
@section("title","权限添加")
@section("content")
    <form class="form-horizontal" action="" method="post">
        {{csrf_field()}}
        <div class="form-group">
            <label class="col-sm-2 control-label">角色</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" value="{{$role->name}}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">权限</label>
            <div class="col-sm-10">
                @foreach($pers as $per)
                <input type="checkbox" name="per[]" value="{{$per->id}}" @if($role->hasPermissionTo($per->name)) checked @endif>{{$per->intro}}
                    @endforeach
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">提交</button>
            </div>
        </div>
    </form>
@endsection