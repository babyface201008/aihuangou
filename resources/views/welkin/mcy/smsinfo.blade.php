@extends('welkin.layout')
@section('title','短信配置')
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
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>短信配置<small></h5>
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
                                                    <form class="form-horizontal no-margin" id="sms_update">
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">短信账户</label>
                                                            <div class="col-lg-9">
                                                            <input type="text" class="form-control input-sm" placeholder="短信账户" datatype="*" value="{{@$sms->sms_account}}" name="sms_account"  >
                                                            <input type="hidden"  value="{{@$sms->sms_id}}" name="sms_id"  >
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->

                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">短信签名</label>
                                                            <div class="col-lg-9">
                                                                <input type="text" class="form-control input-sm" placeholder="短信签名" datatype="*" value="{{@$sms->sms_name}}" name="sms_name"  >

                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">短信密码</label>
                                                            <div class="col-lg-9">
                                                            <input type="text" class="form-control input-sm" placeholder="短信密码" datatype="*" value="{{@$sms->sms_password}}" name="sms_password"  >
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">短信令牌</label>
                                                            <div class="col-lg-9">
                                                            <input type="text" class="form-control input-sm" placeholder="短信令牌" datatype="*" value="{{@$sms->sms_token}}" name="sms_token"  >
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->
                                                       <div class="form-group">
                                                        <label class="control-label col-lg-3">短信商</label>
                                                        <div class="col-lg-9">
                                                            <select name="sms_type" data-placeholder="短信商..." class="chosen-select" style="width:350px;">
                                                                <option @if (@$sms->sms_type == 0) selected="selected" @endif value="0" hassubinfo="true">短信宝</option>
                                                                <option @if (@$sms->sms_type == 1) selected="selected" @endif value="1" hassubinfo="true">阿里云</option>
                                                                <option @if (@$sms->sms_type == 2) selected="selected" @endif value="2" hassubinfo="true">其他</option>
                                                            </select>
                                                        </div><!-- /.col -->
                                                    </div><!-- /form-group -->    
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-3">是否启用</label>
                                                        <div class="col-lg-9">
                                                            <select name="status" data-placeholder="是否启用..." class="chosen-select" style="width:350px;">
                                                                <option @if (@$sms->status == 0) selected="selected" @endif value="0" hassubinfo="true">启用</option>
                                                                <option @if (@$sms->status == 1) selected="selected" @endif value="1" hassubinfo="true">不启用</option>
                                                            </select>
                                                        </div><!-- /.col -->
                                                    </div><!-- /form-group -->    
                                                        <div class="text-right m-top-md">
                                                            <button type="button" class="btn btn-info btn-sms-update">修改</button>
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
    $(".btn-sms-update").on('click',function(){
        var data = $("#sms_update").serialize();
        $.ajax({
            type : 'post',
            url  : '/api/welkin/mcy/sms/update',
            dataType : 'json',
            data : {
                _token   : "{!! csrf_token() !!}",
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
                // location.href = '/shop/wx/shops';
                location.reload();
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
<script src="/js/mcy/upload.js"></script>
@endsection