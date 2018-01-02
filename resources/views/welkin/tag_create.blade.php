@extends('welkin.layout')
@section('title','添加标签')
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
                        <h5>添加标签<small><a href="/welkin/tag">返回标签列表</a></small></h5>
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
                                                    <form class="form-horizontal no-margin" id="article_create" action="/api/welkin/tag/create">
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">标签名称</label>
                                                            <div class="col-lg-9">
                                                                <input type="text" class="form-control input-sm" placeholder="标签名称" datatype="*" name="tag_name" errmsg="标签名称不能为空" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->                              
                                                        <div class="text-right m-top-md">
                                                            <button type="submit" class="btn btn-info btn-tag-add">添加</button>
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
<script type="text/javascript">
    document.onkeydown=function(event){
       var e = event || window.event || arguments.callee.caller.arguments[0];
              if(e && e.keyCode==13){ 
                $(".btn-tag-add").click();
              }
    }; 
    $(".btn-tag-add").on('click',function(e){
        tag_name = $("input[name=tag_name]").val();
        e.preventDefault();
        $.ajax({
            type : 'post',
            url  : '/api/welkin/tag/create',
            dataType : 'json',
            data : {
                _token   : "{!! csrf_token() !!}",
                tag_name: tag_name,
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
                location.href = '/welkin/tag';
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
</script>
@endsection