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
                @auth("admin")
                <li class="active"><a href="{{route("admin.admin.index")}}">首页 <span class="sr-only">(current)</span></a></li>
                @foreach(\App\Models\Nav::navs1() as $k1 => $v1)
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{$v1->name}} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @foreach(\App\Models\Nav::where("pid",$v1->id)->get() as $k2=>$v2)
                                @if(\Illuminate\Support\Facades\Auth::guard('admin')->user()->can($v2->url) || \Illuminate\Support\Facades\Auth::guard("admin")->user()->id==1)
                                <li><a href="{{route($v2->url)}}">{{$v2->name}}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">导航 <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route("admin.navy")}}">一级导航</a></li>
                        <li><a href="{{route("admin.navt")}}">二级导航</a></li>
                    </ul>
                </li>
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