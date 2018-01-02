@extends('welkin.layout')
@section('title','添加晒单')
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
                        <h5>添加晒单<small><a href="/welkin/mcy/shaidan">返回晒单列表</a></small></h5>
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
                                                    <form class="form-horizontal no-margin" id="shaidan_create">
                                                        <div class="form-group">
                                                        <label class="col-lg-3 control-label">晒单图</label>
                                                            <div class="col-lg-8">
                                                                <img width="250px" class="upload_pic" id="shaidan_img" src="{{ isset($shaidan->shaidan_img)?$shaidan->shaidan_img:'/images/plus.png'}}" onclick="return $('#pshaidan_img').click()">
                                                                <input type="file" id="pshaidan_img" name="welkin" style="display:none" accept="image" onchange="return uploadImageToServer('pshaidan_img','images', 'shaidan_img','{{csrf_token()}}')">
                                                            </div>
                                                        </div>        
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">晒单内容</label>
                                                            <div class="col-lg-9">
                                                              <textarea class="shaidan_content" id="shaidan_content" rows=10 cols=50></textarea>
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->
                                                        <div class="form-group">
                                                        <label class="control-label col-lg-3">晒单人ID</label>
                                                            <div class="col-lg-9">
                                                            <input type="number" value="{{@$mcy_user->mcy_user_id}}" class="form-control input-sm" placeholder="晒单人" datatype="*" name="mcy_user_id" style="width:300px;">
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->   
                                                        <div class="text-right m-top-md">
                                                            <button type="button" class="btn btn-info btn-shaidan-add">添加</button>
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
    $(".btn-shaidan-add").on('click',function(){
        var data = $("#shaidan_create").serialize();
        $.ajax({
            type : 'post',
            url  : '/api/welkin/mcy/shaidan/create',
            dataType : 'json',
            data : {
                _token   : "{!! csrf_token() !!}",
                shaidan_img : ($("#shaidan_img").attr('src') == '/images/plus.png')?'':$("#shaidan_img").attr('src'),
                yungou_id : {{@$yungou_id}},
                shaidan_content : $(".shaidan_content").val(),
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
                location.href = '/welkin/mcy/shaidan';
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