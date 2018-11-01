#   Day01

##    开发任务

- 平台端

- 商家分类管理

- 商家管理

- 商家审核

- 商户端

- 商家注册

- 要求

- 商家注册时，同步填写商家信息，商家账号和密码

- 商家注册后，需要平台审核通过，账号才能使用

- 平台可以直接添加商家信息和账户，默认已审核通过



##    实现步骤

1. 下载laravel 

   ```
   composer create-project --prefer-dist laravel/laravel ele0620 "5.5.*" -vvv
   ```

2. 


#   Day04
## 开发任务
- 优化 - 将网站图片上传到阿里云OSS对象存储服务，以减轻服务器压力(https://github.com/jacobcyl/Aliyun-oss-storage) - 使用webuploder图片上传插件，提升用户上传图片体验

- 平台 - 平台活动管理（活动列表可按条件筛选 未开始/进行中/已结束 的活动） - 活动内容使用ueditor内容编辑器(https://github.com/overtrue/laravel-ueditor)

- 商户端 - 查看平台活动（活动列表和活动详情） - 活动列表不显示已结束的活动

## 实现步骤

### oss

- 注册阿里云，实名认证，领取半年oss
- 安装oss 

    ```composer require jacobcyl/ali-oss-storage -vvv```

- 修改 filesystems.php 文件
    ```php
    'oss' => [
            'driver'        => 'oss',
            'access_id'     => env('ALIYUNU_ACCESS_ID'),//账号
            'access_key'    => env('ALIYUNU_ACCESS_KEY'),//密钥
            'bucket'        => env('ALIYUNU_OSS_BUCKET'),//空间名称
            'endpoint'      => env('ALIYUNU_OSS_ENDPOINT'), // OSS 外网节点或自定义外部域名
    
        ],
    ```
- 修改 .env文件
    ```php
    FILESYSTEM_DRIVER=oss
    ALIYUN_OSS_URL=http://elepq.oss-cn-shenzhen.aliyuncs.com/
    ALIYUNU_ACCESS_ID=LTAIF4GAGWXvsSxa
    ALIYUNU_ACCESS_KEY=2HI5yWMqNIOLTX9em34Dio4zSi4leG
    ALIYUNU_OSS_BUCKET=elepq
    ALIYUNU_OSS_ENDPOINT=oss-cn-shenzhen.aliyuncs.com
    ```

- 下载 https://github.com/fex-team/webuploader/releases/download/0.1.5/webuploader-0.1.5.zip 解压

- 将解压后的文件夹复制到public目录

- main文件中分别引入css和js文件
    ```php
     <!--引入CSS-->
        <link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css">
        
     <!--引入JS-->
     <script type="text/javascript" src="/webuploader/webuploader.js"></script>
     
      @yield("js")
    ```

- 视图中添加HTML代码
    ```html
    <div class="form-group">
         <label>图像</label>
         <input type="hidden" name="goods_img" value="" id="img">
         <!--dom结构部分-->
         <div id="uploader-demo">
         <!--用来存放item-->
         <div id="fileList" class="uploader-list"></div>
         <div id="filePicker">选择图片</div>
        </div>
    </div>
    ```
- js代码
    ```php
    @section("js")
        <script>
            // 图片上传demo
            jQuery(function () {
                var $ = jQuery,
                    $list = $('#fileList'),
                    // 优化retina, 在retina下这个值是2
                    ratio = window.devicePixelRatio || 1,
    
                    // 缩略图大小
                    thumbnailWidth = 100 * ratio,
                    thumbnailHeight = 100 * ratio,
    
                    // Web Uploader实例
                    uploader;
    
                // 初始化Web Uploader
                uploader = WebUploader.create({
    
                    // 自动上传。
                    auto: true,
    
                    formData: {
                        // 这里的token是外部生成的长期有效的，如果把token写死，是可以上传的。
                        _token:'{{csrf_token()}}'
                    },
    
    
                    // swf文件路径
                    swf: '/webuploader/Uploader.swf',
    
                    // 文件接收服务端。
                    server: '{{route("shop.menu.upload")}}',
    
                    // 选择文件的按钮。可选。
                    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                    pick: '#filePicker',
    
                    // 只允许选择文件，可选。
                    accept: {
                        title: 'Images',
                        extensions: 'gif,jpg,jpeg,bmp,png',
                        mimeTypes: 'image/*'
                    }
                });
    
                // 当有文件添加进来的时候
                uploader.on('fileQueued', function (file) {
                    var $li = $(
                        '<div id="' + file.id + '" class="file-item thumbnail">' +
                        '<img>' +
                        '<div class="info">' + file.name + '</div>' +
                        '</div>'
                        ),
                        $img = $li.find('img');
    
                    $list.html($li);
    
                    // 创建缩略图
                    uploader.makeThumb(file, function (error, src) {
                        if (error) {
                            $img.replaceWith('<span>不能预览</span>');
                            return;
                        }
    
                        $img.attr('src', src);
                    }, thumbnailWidth, thumbnailHeight);
                });
    
                // 文件上传过程中创建进度条实时显示。
                uploader.on('uploadProgress', function (file, percentage) {
                    var $li = $('#' + file.id),
                        $percent = $li.find('.progress span');
    
                    // 避免重复创建
                    if (!$percent.length) {
                        $percent = $('<p class="progress"><span></span></p>')
                            .appendTo($li)
                            .find('span');
                    }
    
                    $percent.css('width', percentage * 100 + '%');
                });
    
                // 文件上传成功，给item添加成功class, 用样式标记上传成功。
                uploader.on('uploadSuccess', function (file,data) {
                    $('#' + file.id).addClass('upload-state-done');
    
                    $("#img").val(data.url);
                });
    
                // 文件上传失败，现实上传出错。
                uploader.on('uploadError', function (file) {
                    var $li = $('#' + file.id),
                        $error = $li.find('div.error');
    
                    // 避免重复创建
                    if (!$error.length) {
                        $error = $('<div class="error"></div>').appendTo($li);
                    }
    
                    $error.text('上传失败');
                });
    
                // 完成上传完了，成功或者失败，先删除进度条。
                uploader.on('uploadComplete', function (file) {
                    $('#' + file.id).find('.progress').remove();
                });
            });
        </script>
    @stop
    ```

- 创建路由、方法来上传图片
    ```php
    public function upload(Request $request)
        {
            //处理上传
            //dd($request->file("file"));
          
            $file=$request->file("file");
    
            if ($file){
                //上传
                $url=$file->store("menu");
              
                // var_dump($url);
              
                //得到真实地址,加 http的地址,可要可不要
                $url=Storage::url($url);
                $data['url']=$url;
                return $data;
            }
        }
    ```
    > 得到真是路径无法删除图片，但在视图中可以不用加前缀
- css样式

    ```html
     #picker {
         display: inline-block;
         line-height: 1.428571429;
         vertical-align: middle;
         margin: 0 12px 0 0;
     }
     #picker .webuploader-pick {
         padding: 6px 12px;
         display: block;
     }
     
     
     #uploader-demo .thumbnail {
         width: 110px;
         height: 110px;
     }
     #uploader-demo .thumbnail img {
         width: 100%;
     }
     .uploader-list {
         width: 100%;
         overflow: hidden;
     }
     .file-item {
         float: left;
         position: relative;
         margin: 0 20px 20px 0;
         padding: 4px;
     }
     .file-item .error {
         position: absolute;
         top: 4px;
         left: 4px;
         right: 4px;
         background: red;
         color: white;
         text-align: center;
         height: 20px;
         font-size: 14px;
         line-height: 23px;
     }
     .file-item .info {
         position: absolute;
         left: 4px;
         bottom: 4px;
         right: 4px;
         height: 20px;
         line-height: 20px;
         text-indent: 5px;
         background: rgba(0, 0, 0, 0.6);
         color: white;
         overflow: hidden;
         white-space: nowrap;
         text-overflow : ellipsis;
         font-size: 12px;
         z-index: 10;
     }
     .upload-state-done:after {
         content:"\f00c";
         font-family: FontAwesome;
         font-style: normal;
         font-weight: normal;
         line-height: 1;
         -webkit-font-smoothing: antialiased;
         -moz-osx-font-smoothing: grayscale;
         font-size: 32px;
         position: absolute;
         bottom: 0;
         right: 4px;
         color: #4cae4c;
         z-index: 99;
     }
     .file-item .progress {
         position: absolute;
         right: 4px;
         bottom: 4px;
         height: 3px;
         left: 4px;
         height: 4px;
         overflow: hidden;
         z-index: 15;
         margin:0;
         padding: 0;
         border-radius: 0;
         background: transparent;
     }
     .file-item .progress span {
         display: block;
         overflow: hidden;
         width: 0;
         height: 100%;
         background: #d14 url(../images/progress.png) repeat-x;
         -webit-transition: width 200ms linear;
         -moz-transition: width 200ms linear;
         -o-transition: width 200ms linear;
         -ms-transition: width 200ms linear;
         transition: width 200ms linear;
         -webkit-animation: progressmove 2s linear infinite;
         -moz-animation: progressmove 2s linear infinite;
         -o-animation: progressmove 2s linear infinite;
         -ms-animation: progressmove 2s linear infinite;
         animation: progressmove 2s linear infinite;
         -webkit-transform: translateZ(0);
     }
     @-webkit-keyframes progressmove {
         0% {
             background-position: 0 0;
         }
         100% {
             background-position: 17px 0;
         }
     }
     @-moz-keyframes progressmove {
         0% {
             background-position: 0 0;
         }
         100% {
             background-position: 17px 0;
         }
     }
     @keyframes progressmove {
         0% {
             background-position: 0 0;
         }
         100% {
             background-position: 17px 0;
         }
     }
     
     a.travis {
       position: relative;
       top: -4px;
       right: 15px;
     }
    ```

- 修改之前需要上传图片的方法，在方法中图片不用接收，用post将图片路径保存在数据库

- 前端显示图片
    ```html 
      //图片路径完整
     <img src="{{$menu->goods_img}}" alt="" height="50">
     
     // 不完整,? 后面为缩略图
     <img src="{{env("ALIYUN_OSS_URL").$menu->goods_img}}?x-oss-process=image/resize,m_fill,w_80,h_80">
    ```

- 删除图片,完整路径无法删除图片
    ```html 
     Storage::delete(图片);
    ```

### ueditor

- 安装,照着文档走,将配置第二步改为

  ```
  php artisan vendor:publish
  ```

- 选择  [9 ] Provider: Overtrue\LaravelUEditor\UEditorServiceProvider

### 活动

##### 后台

- 创建模型

  ```sh
  PHP artisan make:model MOdels/Activity -m
  ```

- 配置数据

  ```php
  public function up()
      {
          Schema::create('activities', function (Blueprint $table) {
              $table->increments('id');
              $table->string("title")->comment("活动标题");
              $table->text("content")->comment("活动详情");
              $table->dateTime("start_time")->comment("活动开始时间");
              $table->dateTime("end_time")->comment("活动结束时间");
              $table->timestamps();
          });
      }
  ```

- 数据迁移  `PHP artisan migrate`

- 配置路由 admin.activity.index

- 创建控制器

  ```
  PHP artisan make:controller Admin/ActivityController
  ```

- 修改继承，继承BaseController

- 创建index方法

  ```php
  public function index(Request $request)
      {
          $url=$request->query();
  //        dd($url);
          $select =$request->get("select");
          $keyword=$request->get("keyword");
          //得到当前时间
          $time = Carbon::now();
          $activities = Activity::orderBy("id","desc");
      	//关键字不为空
          if ($keyword !== null){
              $activities->where("title","like","%{$keyword}%");
          }
  
          //活动进行中
          if ($select == 1){
              $activities->where("end_time",">",$time);
          }
  
          //活动未开始
          if ($select == 0){
              $activities->where("start_time","<",$time);
          }
  
          //活动已结束
          if ($select == 2){
              $activities->where("end_time",">",$time);
          }
          $activities=$activities->paginate(1);
  //        dd($activities);
          return view("admin.activity.index",compact("activities","url"));
      }
  ```

- 将`@include('vendor.ueditor.assets')`引入到main

- 将config/app.php中`'timezone' => 'UTC'`修改为`'timezone' => 'PRC'`

- 将config/ueditor.php中`'disk' => 'public'`改为`'disk' => 'oss'`

- 创建视图

  ```html
  @extends("admin.layouts.main")
  @section("title","商家分类列表")
  @section("content")
  	{{--收索--}}
      <div class="form-inline pull-left"><a href="{{route("admin.activity.add")}}" class="btn btn-success">添加</a></div>
      <div class="row">
          <div class="col-md-8 pull-right">
              <form class="form-inline pull-right" method="get">
                  <select name="select" id="" class="form-control">
                       <option value="">所有</option>
                       <option value="0">未开始</option>
                       <option value="1">进行中</option>
                       <option value="2">已结束</option>
                  </select>
                  <div class="form-group">
                      <input type="text" class="form-control"  placeholder="请输入关键字" name="keyword" value="{{request()->get('keyword')}}">
                  </div>
                  <button type="submit" class="btn btn-info">搜索</button>
              </form>
          </div>
      </div>
  
  	{{--显示视图--}}
      <table class="table">
          <tr>
              <th>id</th>
              <th>活动标题</th>
              <th>活动详情</th>
              <th>开始时间</th>
              <th>结束时间</th>
              <th>操作</th>
          </tr>
          @foreach($activities as $activity)
          <tr>
              <td>{{$activity->id}}</td>
              <td>{{$activity->title}}</td>
              <td>{!! substr("$activity->content",0,9) !!}</td>
              <td>{{$activity->start_time}}</td>
              <td>{{$activity->end_time}}</td>
              <td>
                  <a href="{{route("admin.activity.edit",$activity->id)}}" class="btn btn-success"><span class="glyphicon glyphicon-edit"></span></a>
                  <a href="{{route("admin.activity.del",$activity->id)}}" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
              </td>
          </tr>
              @endforeach
      </table>
      {{$activities->appends($url)->links()}}
  @endsection
  ```

- 做对应的增删改查

  ```html
  @extends("admin.layouts.main")
  @section("title","商家分类列表")
  @section("content")
      <form class="form-horizontal" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">标题</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputEmail3" placeholder="标题" name="title" value="{{old("title")}}">
              </div>
          </div>
          <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">详情</label>
              <div class="col-sm-10">
                  <script id="container" name="content" type="text/plain">{{old("content")}}</script>
              </div>
          </div>
          <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">开始时间</label>
              <div class="col-sm-10">
                  <input type="datetime-local" class="form-control" placeholder="活动开始时间" name="start_time" value="{{old("start_time")}}">
              </div>
          </div>
          <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">结束时间</label>
              <div class="col-sm-10">
                  <input type="datetime-local" class="form-control" id="inputEmail3" placeholder="活动结束时间" name="end_time" value="{{old("end_time")}}">
              </div>
          </div>
          <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                  <a class="btn btn-info" href="{{url()->previous()}}">返回</a>
                  <button type="submit" class="btn btn-success">添加</button>
              </div>
          </div>
      </form>
  
  @endsection
  ```



#### 商户端

- 设置路由

- 创建控制器

- 修改继承，创建index方法

  ```php
  public function index()
      {
      //获取当前时间
          $time = Carbon::now();
      //按条件查询
          $activities = Activity::all()->where("end_time",">","$time");
          return view("shop.activity.index",compact("activities"));
      }
  ```

- 详情

  ```php
  public function xq($id)
      {
          $activity = Activity::find($id);
          return view("shop.activity.xq",compact("activity"));
      }
  ```

- 详情视图

  ```html
  @extends("admin.layouts.main")
  @section("title","商家分类列表")
  @section("content")
      <h2>{{$activity->title}}</h2>
      <h5>开始时间：{{$activity->start_time}} &emsp;结束时间：{{$activity->end_time}}</h5>
      <pre>{!!$activity->content!!}</pre>
      <a class="btn btn-info" href="{{url()->previous()}}">返回</a>
  @endsection
  ```



# Day05

## 开发任务

接口开发

- 商家列表接口(支持商家搜索)
- 获取指定商家接口

## 实现步骤



# Day06

## 开发任务

接口开发

- 用户注册
- 用户登录
- 忘记密码
- 发送短信 要求
- 创建会员表
- 短信验证码发送成功后,保存到redis,并设置有效期5分钟
- 用户注册时,从redis取出验证码进行验证