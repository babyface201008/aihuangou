@extends('welkin.layout')
@section('title','后台商品管理')
@section('my-css')
    <link href="/admin/css/plugins/iCheck/custom.css" rel="stylesheet"> 
    <style type="text/css">
        
    </style>
@endsection
@section('content')
 
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>商品管理 <small> <a class="btn btn-sm btn-success" href="/welkin/mcy/product/create">添加商品</a>
                        </small>全部共{{@$products->total()}}件商品，当前页面{{@$products->currentPage()}}页</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-refresh refresh"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-2 m-b-xs">
                                <input placeholder="开始日期" class="form-control layer-date" name="starttime" id="starttime" value="{{@$_GET['starttime']}}">
                            </div>
                            <div class="col-sm-2 m-b-xs ">
                                <input placeholder="结束日期" class="form-control layer-date" name="endtime" id="endtime"  value="{{@$_GET['endtime']}}">
                            </div>
                            <div class="col-sm-1 m-b-xs">
                                <button type="button" class="btn btn-sm btn-primary btnsearch"> 搜索</button> 
                            </div>
                            <div class="col-sm-2">
                                <select name="product_type" id="product_type" data-placeholder="选择性别..." class="chosen-select" style="width:120px;">
                                    <option @if(@$product_type == 0) selected="selected" @endif value="0" hassubinfo="true">普通商品</option>
                                    <option @if(@$product_type == 1) selected="selected" @endif value="1" hassubinfo="true">云购商品</option>
                                    <option @if(@$product_type == 2) selected="selected" @endif value="2" hassubinfo="true">促销商品</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                            <select name="category_id" id="category_id" data-placeholder="选择性别..." class="chosen-select" style="width:120px;">
                                    <option value="0" hassubinfo="true">所有商品</option>
                                    @foreach($categorys as $category)
                                    <option @if(@$category_id == $category->category_id) selected="selected" @endif value="{{@$category->category_id}}" hassubinfo="true">{{@$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-2">
                                <div class="input-group">
                                    <input type="text" placeholder="请输入名称" name="searchtext" value="{{@$searchtext}}" class="input-sm form-control"> <span class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-primary btnsearch"> 搜索</button> </span>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>

                                        <!-- <th></th> -->
                                        <th>产品ID</th>
                                        <th>产品名称</th>
                                        <th>产品价格</th>
                                        <th>产品类型</th>
                                        <th>产品归属</th>
                                        <th>创建时间</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr class="uid{{@$product->product_id}}">
                                 <!--  <td>
                                            <input type="checkbox" checked class="i-checks" name="input[]">
                                        </td> -->
                                        <td>{{@$product->product_id}}</td>
                                        <td>{{@$product->product_name}}</td>
                                        <td>{{@$product->product_price}}</td>
                                        <td>
                                        @if (@$product_type == 0)
                                        普通商品
                                        @elseif(@$product_type == 1)
                                        云购商品
                                        @elseif(@$product_type == 2)
                                        促销商品
                                        @endif
                                        </td>
                                        <td>{{@$product->category_name}}</td>
                                        <td>{{@$product->created_at}}</td>
                                        <td>
                                        @if ($product->sort == 0)
                                        <a class="btn btn-sm btn-info setsort" href="javascript:;" sort="{{@$product->sort}}" productid="{{@$product->product_id}}">置顶</a>
                                        @else
                                        <a class="btn btn-sm btn-danger setsort" href="javascript:;" sort='welkin' productid="{{@$product->product_id}}">取消置顶</a>
                                        @endif
                                        @if ($product->hot == 0)
                                        <a class="btn btn-sm btn-info sethot" href="javascript:;" hot="{{@$product->hot}}" productid="{{@$product->product_id}}">标记人气</a>
                                        @else
                                        <a class="btn btn-sm btn-danger sethot" href="javascript:;" hot="{{@$product->hot}}" productid="{{@$product->product_id}}">取消人气</a>
                                        @endif
                                        <a class="btn btn-sm btn-info updateproduct" href="/welkin/mcy/product/update?product_id={{@$product->product_id}}">修改</a>
                                        <a class="btn btn-sm btn-primary updateproduct" target="_blank" href="/welkin/mcy/orders?productid={{@$product->product_id}}">查看购物详情</a>
                                        <button type="button" class="btn btn-sm btn-danger deleteproduct" uname="{{@$product->productname}}" uid="{{@$product->product_id}}" >删除</button>
                                        <button type="button" class="btn btn-sm btn-danger setproduct" uname="{{@$product->productname}}" uid="{{@$product->product_id}}" >下架</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$products->appends(['searchtext'=>$searchtext,'starttime'=>@$_GET['starttime'],'endtime'=>@$_GET['endtime'],'category_id'=>@$category_id,'product_type'=>@$product_type])->links()}}
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@section('my-js')
    <script src="/admin/js/plugins/layer/laydate/laydate.js"></script>
    <script src="/admin/js/plugins/peity/jquery.peity.min.js"></script>
    <script src="/admin/js/demo/peity-demo.min.js"></script>
    <script>
        $(document).ready(function(){$(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",})});
    var start={elem:"#starttime",format:"YYYY-MM-DD",max:"2099-06-16 23:59:59",istime:true,istoday:false,choose:function(datas){end.min=datas;end.start=datas}};var end={elem:"#endtime",format:"YYYY-MM-DD",min:laydate.now(),max:"2099-06-16 23:59:59",istime:true,istoday:false,choose:function(datas){start.max=datas}};laydate(start);laydate(end);
    $(".btnsearch").on('click',function(){
        var searchtext = $("input[name=searchtext]").val(),
            starttime = $("input[name=starttime]").val(),
            endtime = $("input[name=endtime]").val();
            product_type = $("#product_type").val();
            category_id = $("#category_id").val();
        location.href = '/welkin/mcy/products?searchtext='+ searchtext + '&starttime=' + starttime + '&category_id=' + category_id + '&product_type=' + product_type + '&endtime='+ endtime;
    });

    $('.deleteproduct').on('click',function(){
        var uid = $(this).attr('uid'),
            name = $(this).attr('uname');
        parent.layer.confirm('确定删除名称为' + name + '的商品?',function(){
           $.ajax({
            url : '/api/welkin/mcy/product/delete',
              type : 'post',
              async : false,
              dataType : 'json',
              data : {
                _token : "{!! csrf_token() !!}",
                product_id : uid
            },
            success: function(data) {
                console.log(data);
                if(data == null) {
                  layer.msg('服务端错误', {icon:2, time:2000});
                  return;
              }
              if(data.ret != 0) {
                  layer.msg(data.msg, {icon:2, time:2000});
                  return;
              }
              layer.msg(data.msg,{icon:1,time:2000});
              $(".uid"+data.product_id).hide();
              parent.layer.closeAll();

          },
          error: function(xhr, ret, error) {
            console.log(xhr);
            console.log(ret);
            console.log(error);
            layer.msg('ajax error', {icon:2, time:2000});
        },
        beforeSend: function(xhr){
            layer.load(0, {shade: false});
        },
        complete: function(){
            layer.closeAll('loading');
        },
    });
       });
    });
    $('.setproduct').on('click',function(){
        var uid = $(this).attr('uid'),
            name = $(this).attr('uname');
        parent.layer.confirm('确定下架名称为' + name + '的商品?',function(){
           $.ajax({
            url : '/api/welkin/mcy/product/delete',
              type : 'post',
              async : false,
              dataType : 'json',
              data : {
                _token : "{!! csrf_token() !!}",
                product_id : uid
            },
            success: function(data) {
                console.log(data);
                if(data == null) {
                  layer.msg('服务端错误', {icon:2, time:2000});
                  return;
              }
              if(data.ret != 0) {
                  layer.msg(data.msg, {icon:2, time:2000});
                  return;
              }
              layer.msg(data.msg,{icon:1,time:2000});
              $(".uid"+data.product_id).hide();
              parent.layer.closeAll();

          },
          error: function(xhr, ret, error) {
            console.log(xhr);
            console.log(ret);
            console.log(error);
            layer.msg('ajax error', {icon:2, time:2000});
        },
        beforeSend: function(xhr){
            layer.load(0, {shade: false});
        },
        complete: function(){
            layer.closeAll('loading');
        },
    });
       });
    });
    $(".sethot").on('click',function(){
        var product_id =  $(this).attr('productid');
        var hot =  $(this).attr('hot');
        var _this = $(this);
        $.ajax({
            type : 'post',
            url  : '/api/welkin/mcy/product/set/hot',
            dataType : 'json',
            data : {
                _token   : "{!! csrf_token() !!}",
                product_id: product_id,
                hot: hot
            },
            success: function(data) {
                console.log(data);
                if(data == null) {
                layer.msg('服务端错误', {icon:2, time:2000});
                  return;
                }
                if(data.ret != 0) {
                layer.msg(data.msg, {icon:2, time:2000});
                  return;
                }
                if (data.hot)
                {
                    _this.removeClass('btn-info');
                    _this.addClass('btn-danger');
                    _this.text('取消人气');
                    _this.attr('hot',data.hot);
                }else{
                     _this.removeClass('btn-danger');
                    _this.addClass('btn-info');
                    _this.text('标记人气');
                    _this.attr('hot',data.hot);
                }
                layer.msg(data.msg, {icon:1, time:2000});
            },
            error: function(xhr, ret, error) {
                console.log(xhr);
                console.log(ret);
                console.log(error);
                layer.msg('ajax error', {icon:2, time:2000});
            },
            beforeSend: function(xhr){
                layer.load(0, {shade: false});
            },
            complete: function(){
                layer.closeAll('loading');
            }
        });
    });
   $(".setsort").on('click',function(){
        var product_id =  $(this).attr('productid');
        var sort =  $(this).attr('sort');
        var _this = $(this);
        $.ajax({
            type : 'post',
            url  : '/api/welkin/mcy/product/set/sort',
            dataType : 'json',
            data : {
                _token   : "{!! csrf_token() !!}",
                product_id: product_id,
                sort: sort
            },
            success: function(data) {
                console.log(data);
                if(data == null) {
                layer.msg('服务端错误', {icon:2, time:2000});
                  return;
                }
                if(data.ret != 0) {
                layer.msg(data.msg, {icon:2, time:2000});
                  return;
                }
                if (!(data.sort == 0))
                {
                    _this.removeClass('btn-info');
                    _this.addClass('btn-danger');
                    _this.text('取消置顶');
                    _this.attr('sort',0);
                }else{
                     _this.removeClass('btn-danger');
                    _this.addClass('btn-info');
                    _this.text('置顶');
                    _this.attr('sort',data.sort);
                }
                layer.msg(data.msg, {icon:1, time:2000});
                setTimeout(function(){
                    location.reload();
                },400);
            },
            error: function(xhr, ret, error) {
                console.log(xhr);
                console.log(ret);
                console.log(error);
                layer.msg('ajax error', {icon:2, time:2000});
            },
            beforeSend: function(xhr){
                layer.load(0, {shade: false});
            },
            complete: function(){
                layer.closeAll('loading');
            }
        });
    });
    $(".chosen-select").chosen({disable_search_threshold: 10});

    </script>

@endsection