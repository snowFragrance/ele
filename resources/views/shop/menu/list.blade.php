@extends("shop.layouts.main")
@section("title","菜单")
@section("content")
    <div class="row">
        <div class="col-md-8 pull-right">
            <form class="form-inline pull-right" method="get">
                <div class="form-group">
                    <input type="text" class="form-control"  placeholder="最低价" size="5" name="min" value="{{request()->get('min')}}">
                </div>
                -
                <div class="form-group">
                    <input type="text" class="form-control"  placeholder="最高价" size="5" name="max" value="{{request()->get('max')}}">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control"  placeholder="请输入名称" name="keyword" value="{{request()->get('keyword')}}">
                </div>
                <button type="submit" class="btn btn-success">搜索</button>
            </form>
        </div>
    </div>

    @foreach($cates as $cate)
        @foreach($menus as $menu)
        @if($menu->category_id == $cate->id)
                    <ul class="sidebar-menu" data-widget="tree">
                        <li class="treeview">
                            <a href="#"><i class="fa fa-pie-chart"></i> <span>{{$cate->name}}</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route("shop.menu.list")}}"><i class="fa fa-circle-o"></i> {{$menu->goods_name}}</a></li>
                            </ul>
                        </li>
                    </ul>
        @endif
        @if($menu->category_id != $cate->id)
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="treeview">
                        <a href="#"><i class="fa fa-pie-chart"></i> <span>{{$cate->name}}</span>
                            <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                    </li>
                </ul>
        @endif
        @endforeach
    @endforeach

@endsection