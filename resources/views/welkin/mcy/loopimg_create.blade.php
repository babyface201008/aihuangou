@extends('welkin.layout')
@section('title','添加轮播')
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
                        <h5>添加轮播<small><a href="/welkin/mcy/loopimgs">返回轮播列表</a></small></h5>
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
                                                    <form class="form-horizontal no-margin" id="loopimg_create">
                                                        <div class="form-group">
                                                        <label class="col-lg-3 control-label">轮播缩略图</label>
                                                            <div class="col-lg-8">
                                                                <img width="250px" class="upload_pic" id="loopimg_img" src="{{ isset($loopimg->loopimg_img)?$loopimg->loopimg_img:'/images/plus.png'}}" onclick="return $('#ploopimg_img').click()">
                                                                <input type="file" id="ploopimg_img" name="welkin" style="display:none" accept="image" onchange="return uploadImageToServer('ploopimg_img','images', 'loopimg_img','{{csrf_token()}}')">
                                                            </div>
                                                        </div>        
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">轮播描述(可不填)</label>
                                                            <div class="col-lg-9">
                                                            <script type="text/plain" id="loopimg_desc" style="width:100%;min-height:240px; min-width:200px;">
                                                                </script>
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->
                                                        <div class="form-group">
                                                        <label class="control-label col-lg-3">排序</label>
                                                            <div class="col-lg-9">
                                                            <input type="number" value="0" class="form-control input-sm" placeholder="排序" datatype="*" name="sort" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->   

                                                        <div class="form-group">
                                                        <label class="control-label col-lg-3">是否展示</label>
                                                            <div class="col-lg-9">
                                                            <select name="status" data-placeholder="选择是否展示..." class="chosen-select" style="width:350px;">
                                                                    <option  value="0" hassubinfo="true">是</option>
                                                                    <option  value="1" hassubinfo="true">否</option>
                                                                </select>
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->                     
                                                        <div class="text-right m-top-md">
                                                            <button type="button" class="btn btn-info btn-loopimg-add">添加</button>
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
    var loopimg_desc = UE.getEditor('loopimg_desc');
    var imgs = $(".loopimg_loop_img"),loopimg_loog_imgs = [];
    for(var i = 0;i<imgs.length;i++){
        var tmp = $(imgs[i]).attr("src");
        if (tmp == '/images/plus.png')
        {

        }else{
            loopimg_loog_imgs.push(tmp);
        }
    }
    $(".btn-loopimg-add").on('click',function(){
        var data = $("#loopimg_create").serialize();
        $.ajax({
            type : 'post',
            url  : '/api/welkin/mcy/loopimg/create',
            dataType : 'json',
            data : {
                _token   : "{!! csrf_token() !!}",
                loopimg_url : ($("#loopimg_img").attr('src') == '/images/plus.png')?'':$("#loopimg_img").attr('src'),
                loopimg_desc : loopimg_desc.getContent(),
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
                location.href = '/welkin/mcy/loopimgs';
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