@extends('welkin.layout')
@section('title','添加商品')
@section('my-css')
    <link href="/admin/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet"> 
    <style type="text/css">
    .label {display: inline-block;margin: 5px;cursor: pointer;}
    .label:hover {background: #FD8894;}
    .area_category_select:hover {background: #ed5565;}
    </style>
@endsection
@section('content')
 
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>添加商品<small><a href="/welkin/mcy/products">返回商品列表</a></small></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-refresh refresh"></i>
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="main-container">
                            <div class="padding-md">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="smart-widget widget-purple">
                                            <div class="smart-widget-inner">
                                                <div class="smart-widget-body">
                                                    <form class="form-horizontal no-margin" id="product_create">
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">商品名称</label>
                                                            <div class="col-lg-9">
                                                                <input type="text" class="form-control input-sm" placeholder="商品名称" datatype="*" name="product_name" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->    
                                                        <div class="form-group">
                                                        <label class="col-lg-3 control-label">商品缩略图</label>
                                                            <div class="col-lg-8">
                                                                <img width="50px" class="upload_pic" id="product_img" src="{{ isset($product->product_img)?$product->product_img:'/images/plus.png'}}" onclick="return $('#pproduct_img').click()">
                                                                <input type="file" id="pproduct_img" name="welkin" style="display:none" accept="image" onchange="return uploadImageToServer('pproduct_img','images', 'product_img','{{csrf_token()}}')">
                                                            </div>
                                                        </div>        
                                                        <div class="form-group">
                                                        <label class="col-lg-3 control-label">商品轮播图片</label>
                                                            <div class="col-lg-8">
                                                                @for($i=1;$i <= 5;$i++)
                                                                <span style="display: none;">{{@$inumber= 'product_loop_img'.$i }}</span>
                                                                <img width="50px" class="product_loop_img" id="product_loop_img{{@$i}}" src="{{ isset($product->$inumber)?$product->$inumber:'/images/plus.png'}}" onclick="return $('#plogoimg{{@$i}}').click()">
                                                                <input type="file" id="plogoimg{{@$i}}" name="welkin" style="display:none" accept="image" onchange="return uploadImageToServer('plogoimg{{@$i}}','images', 'product_loop_img{{@$i}}','{{csrf_token()}}')">
                                                                @endfor
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                        <label class="control-label col-lg-3">商品价格</label>
                                                            <div class="col-lg-9">
                                                            <input type="number" value="0" class="form-control input-sm" placeholder="商品价格" datatype="*" name="product_price" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->   
                                                        <div class="form-group">
                                                        <label class="control-label col-lg-3">商品描述</label>
                                                            <div class="col-lg-9">
                                                                <script type="text/plain" id="product_desc" style="width:100%;min-height:240px; min-width:200px;">
                                                                </script>
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">商品类型</label>
                                                            <div class="col-lg-9">
                                                                <select name="product_type" data-placeholder="选择商品类型..." class="chosen-select" style="width:350px;">
                                                                    <option value="0" hassubinfo="true">普通商品</option>
                                                                    <option value="1" hassubinfo="true">云购商品</option>
                                                                    <option value="2" hassubinfo="true">促销商品</option>
                                                                </select>
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->    
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">产品归类</label>
                                                            <div class="col-lg-9">
                                                                <select name="category_id" data-placeholder="选择产品归类..." class="chosen-select" style="width:350px;">
                                                                　@foreach($categorys as $category)
                                                                    <option value="{{@$category->category_id}}" hassubinfo="true">{{@$category->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->    
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">云购人次数</label>
                                                            <div class="col-lg-9">
                                                                <input type="number" value="0" class="form-control input-sm" placeholder="云购人次数" datatype="*" name="go_number" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->    
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">云购期数</label>
                                                            <div class="col-lg-9">
                                                                <input type="number" value="999999999" class="form-control input-sm" placeholder="云购期数" datatype="*" name="go_qishu" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->  
                                                        <div class="form-group">
                                                        <label class="control-label col-lg-3">是否自动进入下一期</label>
                                                            <div class="col-lg-9">
                                                            <select name="go_auto" data-placeholder="选择是否自动进入下一期..." class="chosen-select" style="width:350px;">
                                                                    <option value="0" hassubinfo="true">是</option>
                                                                    <option value="1" hassubinfo="true">否</option>
                                                                </select>
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->                   
                                                        <div class="form-group">
                                                        <label class="control-label col-lg-3">是否限购</label>
                                                            <div class="col-lg-9">
                                                            <select name="is_xiangou" data-placeholder="是否限购..." class="chosen-select" style="width:350px;">
                                                                    <option value="0" hassubinfo="true">否</option>
                                                                    <option value="1" hassubinfo="true">是</option>
                                                                </select>
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->   
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">限购次数</label>
                                                            <div class="col-lg-9">
                                                                <input type="number" value="100" class="form-control input-sm" placeholder="限购次数" datatype="*" name="xiangou_count" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->      
                                                        <div class="text-right m-top-md">
                                                            <button type="button" class="btn btn-info btn-product-add">添加</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div><!-- ./smart-widget-inner -->
                                        </div><!-- ./smart-widget -->
                                    </div><!-- /.col-->
                                </div><!-- /.row -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('my-js')
<script src="/js/mcy/upload.js"></script>
<!-- 配置文件 -->
<script type="text/javascript" src="/admin/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="/admin/ueditor/ueditor.all.js"></script>
<script type="text/javascript">
    var product_desc = UE.getEditor('product_desc');

    $(".btn-product-add").on('click',function(){
        var imgs = $(".product_loop_img"),product_loop_imgs = [];
        for(var i = 0;i<imgs.length;i++){
            var tmp = $(imgs[i]).attr("src");
            if (tmp == '/images/plus.png')
            {

            }else{
                product_loop_imgs.push(tmp);
            }
        }
        var data = $("#product_create").serialize();
        $.ajax({
            type : 'post',
            url  : '/api/welkin/mcy/product/create',
            dataType : 'json',
            data : {
                _token   : "{!! csrf_token() !!}",
                product_img : ($("#product_img").attr('src') == '/images/plus.png')?'':$("#product_img").attr('src'),
                product_loop_imgs : product_loop_imgs.toString(),
                product_desc : product_desc.getContent(),
                data : data,
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
                layer.msg(data.msg, {icon:1, time:2000});
                location.href = '/welkin/mcy/products';
            },
            error: function(xhr, ret, error) {
                console.log(xhr);
                console.log(ret);
                console.log(error);
                layer.msg('服务器出错', {icon:2, time:2000});
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