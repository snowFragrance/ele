@extends("shop.layouts.main")

@section("content")
        <form class="form-horizontal" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">店铺分类</label>
                <div class="col-sm-10">
                    <select name="shop_category_id" id="inputEmail3" class="form-control">
                        <option value="">----请选择分类----</option>
                        @foreach($shops as $shop)
                        <option value="{{$shop->id}}">{{$shop->name}}</option>
                            @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">店铺名</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputEmail3" placeholder="店铺名" name="shop_name" value="{{old("shop_name")}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">店铺图片</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" id="inputPassword3" name="shop_img">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">起送金额
                </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="起送金额" name="start_send" value="{{old("start_send")}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">配送费
                </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="配送费" name="send_cost" value="{{old("send_cost")}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">店公告
                </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="店公告" name="notice" value="{{old("notice")}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">优惠信息
                </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="优惠信息" name="discount"  value="{{old("discount")}}">
                </div>
            </div>

            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">
                </label>
                <div class="col-sm-10">
                    <input type="checkbox"  name="brand" >品牌连锁店&nbsp;
                    <input type="checkbox"  name="on_time"  >准时送达&nbsp;
                    <input type="checkbox"  name="fengniao"  >蜂鸟配送&nbsp;
                    <input type="checkbox"  name="bao"   >保&nbsp;
                    <input type="checkbox"  name="piao"  >票&nbsp;
                    <input type="checkbox"  name="zhun"  >准
                </div>
            </div>

        <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success">注册</button>
                </div>
            </div>
        </form>
@endsection