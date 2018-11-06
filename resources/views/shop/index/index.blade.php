@extends("shop.layouts.main")
@section("title","首页")
@section("content")

    <div class="row">
            @if($shop[0]->shop_id == 0 )

                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3></h3>

                            <p>注册店铺</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route("shop.reg")}}" class="small-box-footer">去注册<i class="fa fa-arrow-circle-right"></i></a>

                    </div>
                </div>


            @endif

            @if($shop[0]->shop_id != 0)
                    @if($shop[0]->status == 0)
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3></h3>

                                    <p>店铺正在审核中，请耐心等待...</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif

                    @if($shop[0]->status == -1)
                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-red">
                                    <div class="inner">
                                        <h3></h3>

                                        <p>店铺已禁用</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-pie-graph"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        @endif

                    @if($shop[0]->status != 0)
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3></h3>

                                <p>今日订单</p>
                                <p>{{$shop["num"][0]->num}} 份 &emsp;{{$shop["money"][0]->money}} ￥</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{route("shop.day")}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3></h3>

                                <p>今日销量</p>
                                <p>{{$shop["amount"]}} 份</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{route("shop.dx")}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->

                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3></h3>

                                        <p>月订单</p>
                                        <p>{{$shop["mn"][0]->num}} 份 &emsp;{{$shop["mm"][0]->money}} ￥</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-shopping-cart"></i>
                                    </div>
                                    <a href="{{route("shop.month")}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <!-- ./col -->
                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-maroon">
                                    <div class="inner">
                                        <h3></h3>

                                        <p>月销量</p>
                                        <p>{{$shop["m"]}} 份</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-gg"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->

                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3></h3>

                                <p>总订单数</p>
                                <p>{{$shop["cn"][0]->num}} 份 &emsp;{{$shop["cm"][0]->money}} ￥</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{route("shop.total")}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3></h3>

                                <p>总销量</p>
                                <p>{{$shop["total"]}} 份</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    @endif

                @endif
    </div>
@endsection

