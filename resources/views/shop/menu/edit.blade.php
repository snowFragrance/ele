@extends("shop.layouts.main")

@section("content")
        <form class="form-horizontal" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    <img src="/{{$menu->goods_img}}" alt="" height="100">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">名称</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputEmail3" placeholder="菜名" name="goods_name" value="{{$menu->goods_name,old("goods_name")}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">所属分类</label>
                <div class="col-sm-10">
                    <select name="category_id" id="" class="form-control">
                        <option value="">---请选择分类---</option>
                        @foreach($cates as $cate)
                            <option value="{{$cate->id}}" @if($menu->category_id == $cate->id) selected @endif>{{$cate->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">价格</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputPassword3" placeholder="菜品价格" name="goods_price" value="{{$menu->goods_price,old("goods_price")}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">描述</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputPassword3" placeholder="菜品描述" name="description" value="{{$menu->description,old("description")}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">提示信息</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputPassword3" placeholder="提示" name="tips" value="{{$menu->tips,old("tips")}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">图片</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" id="inputPassword3" placeholder="图片" name="goods_img">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">状态</label>
                <div class="col-sm-10">
                    <input type="radio" id="inputPassword3" placeholder="状态" name="status" value="1" @if($menu->status) checked @endif>上架
                    <input type="radio" id="inputPassword3" placeholder="状态" name="status" value="0" @if(!$menu->status) checked @endif>下架
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <a class="btn btn-info" href="{{url()->previous()}}">返回</a>
                    <button type="submit" class="btn btn-success">编辑</button>
                </div>
            </div>
        </form>
@endsection