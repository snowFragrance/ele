@extends("admin.layouts.main")

@section("title","首页")

@section("content")
    <div class="row">
        <div class="col-md-8 pull-right">
            <form class="form-inline pull-right" method="get">
                <div class="form-group">
                    <select name="now" id="" class="form-control">
                        <option value="0">今日订单</option>
                        <option value="1">月订单</option>
                        <option value="2">总订单</option>
                    </select>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control"  placeholder="请输入店铺名称" name="keyword" value="{{request()->get('keyword')}}">
                </div>
                <button type="submit" class="btn btn-info">搜索</button>
            </form>
        </div>
    </div>
    <br>

    <table class="table">
        <tr>
            <th>店铺</th>
            <th>订单</th>
            <th>总金额</th>
            <th>销量</th>
        </tr>
        @foreach($shops as $k=>$shop)
            <tr>
                <td>{{$shop->shop_name}}</td>
                <td>{{$shop->num[0]->num}} 份</td>
                <td>￥ {{$shop->money[0]->money}}</td>
                <td>{{$shop->amount}} </td>
            </tr>
        @endforeach


    </table>
@endsection