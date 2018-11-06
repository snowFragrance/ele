<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">pq</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="{{route("admin.admin.index")}}">首页 <span class="sr-only">(current)</span></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">员工管理 <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route("admin.admin.reg")}}">添加员工</a></li>
                        <li><a href="{{route("admin.admin.list")}}">员工列表</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">权限管理 <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route("admin.per.add")}}">添加权限</a></li>
                        <li><a href="{{route("admin.role.add")}}">添加角色</a></li>
                        <li><a href="{{route("admin.per.list")}}">权限列表</a></li>
                        <li><a href="{{route("admin.role.list")}}">角色列表</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">商铺管理 <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route("admin.shopCate.index")}}">分类管理</a></li>
                        <li><a href="{{route("admin.user.index")}}">账号管理</a></li>
                        <li><a href="{{route("admin.shop.index")}}">店铺管理</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">活动管理 <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route("admin.activity.index")}}">活动列表</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @auth("admin")
                <li><a href="#">Link</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{\Illuminate\Support\Facades\Auth::guard("admin")->user()->name}} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">个人资料</a></li>
                        <li><a href="{{route("admin.admin.change",\Illuminate\Support\Facades\Auth::guard("admin")->user()->id)}}">修改密码</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{route("admin.admin.logout")}}">退出</a></li>
                    </ul>
                </li>
                @endauth

                @guest("admin")
                    <li><a href="{{route("admin.admin.login")}}">登录</a></li>
                    {{--<li><a href="{{route("admin.admin.reg")}}">注册</a></li>--}}
                @endguest
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>