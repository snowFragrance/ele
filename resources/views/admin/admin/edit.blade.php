@extends("admin.layouts.main")
@section("title","编辑")
@section("content")
        <form class="form-horizontal" method="post">
            {{csrf_field()}}
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">姓名</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputEmail3" placeholder="姓名" name="name" value="{{$admin->name}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">邮箱</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="inputEmail3" placeholder="Email" name="email" value="{{$admin->email}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">角色</label>
                <div class="col-sm-10">
                    @foreach($roles as $role)
                        <input type="checkbox" id="inputEmail3" name="role[]" @if($admin->hasRole($role->name)) checked @endif value="{{$role->id}}">{{$role->name}}
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success">编辑</button>
                </div>
            </div>
        </form>
@endsection