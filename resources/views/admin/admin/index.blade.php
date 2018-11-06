@extends("admin.layouts.main")

@section("title","首页")

@section("content")
    <table class="table">
        <tr><th>今日订单</th></tr>
        @foreach($shops as $k=>$shop)
            <tr>
                <td>{{$shop->shop_name}}</td>
                <td>{{$shop->num[0]->num}} 份</td>
                <td>￥ {{$shop->dm[0]->money}}</td>
                <td>{{$shop->amount}} 份</td>
            </tr>
        @endforeach

        <th></th>

        <tr><th>月订单</th></tr>
        @foreach($shops as $shop)
            <tr>
                <td>{{$shop->shop_name}}</td>
                <td>{{$shop->month[0]->num}} 份</td>
{{--                <td>￥ {{$shop->mm[0]->mon}}</td>--}}
{{--                <td>{{$shop->month}} 份</td>--}}
            </tr>
        @endforeach

        <th></th>

        <tr><th>总计</th></tr>
        @foreach($shops as $shop)
            <tr>
                <td>{{$shop->shop_name}}</td>
                <td>{{$shop->total[0]->num}} 份</td>
{{--                <td>￥ {{$shop->tm[0]->money}}</td>--}}
            </tr>
        @endforeach
    </table>
@endsection