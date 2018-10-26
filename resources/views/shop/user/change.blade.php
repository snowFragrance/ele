@extends("shop.layouts.main")

@section("content")
        <form class="form-horizontal" method="post">
            {{csrf_field()}}
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">姓名</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputEmail3" name="name" value="{{$user->name}}" disabled>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">密码</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputPassword3" placeholder="请输入密码" name="password">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">确认密码</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputPassword3" placeholder="请确认密码" name="password_confirmation">
                </div>
            </div>
            <div class="form-group">
                <label  class="col-sm-2 control-label">验证码</label>
                <div class="col-sm-10">
                    <input id="captcha" class="form-control" name="captcha" >
                    <img class="thumbnail captcha" src="{{captcha_src('flat')}}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success">修改</button>
                </div>
            </div>
        </form>
@endsection