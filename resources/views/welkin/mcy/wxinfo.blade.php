@extends('welkin.layout')
@section('title','公众号配置')
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
                        <h5>公众号配置<small></h5>
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
                                                    <form class="form-horizontal no-margin" id="wxinfo_update">
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">公众号名称</label>
                                                            <div class="col-lg-9">
                                                            <input type="text" class="form-control input-sm" placeholder="公众号名称" datatype="*" value="{{@$wxinfo->wx_name}}" name="wx_name"  >
                                                            <input type="hidden"  value="{{@$wxinfo->wxinfo_id}}" name="wxinfo_id"  >
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->
                                                       <div class="form-group">
                                                            <label class="control-label col-lg-3">公众号类型</label>
                                                            <div class="col-lg-9">
                                                            <select  name="wx_type" data-placeholder="选择类型..." class="chosen-select" style="width:350px;">
                                                                    <option value="0" @if (@$wxinfo->wx_type == 0) selected=selected @endif hassubinfo="true">订阅号</option>
                                                                    <option value="1" @if (@$wxinfo->wx_type == 1) selected=selected @endif hassubinfo="true">服务号</option>
                                                                </select>
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">APPID</label>
                                                            <div class="col-lg-9">
                                                            <input type="text" class="form-control input-sm" placeholder="appID" datatype="*" value="{{@$wxinfo->appid}}" name="appid"  >
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">APPSecret</label>
                                                            <div class="col-lg-9">
                                                            <input type="text" class="form-control input-sm" placeholder="APPSecret" datatype="*" value="{{@$wxinfo->appsecret}}" name="appsecret"  >
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->

                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">原始ID</label>
                                                            <div class="col-lg-9">
                                                            <input type="text" class="form-control input-sm" placeholder="原始ID" datatype="*" value="{{@$wxinfo->original_id}}" name="original_id"  >
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">商户号</label>
                                                            <div class="col-lg-9">
                                                            <input type="text" class="form-control input-sm" placeholder="商户号" datatype="*" value="{{@$wxinfo->mch_id}}" name="mch_id"  >
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">商户号密钥</label>
                                                            <div class="col-lg-9">
                                                            <input type="text" class="form-control input-sm" placeholder="商户号密钥" datatype="*" value="{{@$wxinfo->mch_secret}}" name="mch_secret"  >
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">备注</label>
                                                            <div class="col-lg-9">
                                                            <input type="text" class="form-control input-sm" placeholder="备注" datatype="*" value="{{@$wxinfo->remark}}" name="remark"  >
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->

                                                        <div class="text-right m-top-md">
                                                            <button type="button" class="btn btn-info btn-wxinfo-update">修改</button>
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
    $(".btn-wxinfo-update").on('click',function(){
        var data = $("#wxinfo_update").serialize();
        $.ajax({
            type : 'post',
            url  : '/api/welkin/mcy/wxinfo/update',
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
@endsection