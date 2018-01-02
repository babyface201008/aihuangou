@extends('welkin.layout')
@section('title','充值活动配置')
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
                        <h5>充值活动配置<small></h5>
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
                                                    <form class="form-horizontal no-margin" id="activity_update">
                                                      <div class="form-group">
                                                        <input type="hidden"  value="{{@$activity->activity_status}}" name="activity_status"  >
                                                            <label class="control-label col-lg-3">是否启用</label>
                                                            <div class="col-lg-9">
                                                            <select  name="activity_status" data-placeholder="选择类型..." class="chosen-select" style="width:350px;">
                                                                    <option value="0" @if (@$activity->activity_status == 0) selected=selected @endif hassubinfo="true">启用</option>
                                                                    <option value="1" @if (@$activity->activity_status == 1) selected=selected @endif hassubinfo="true">停用</option>
                                                                </select>
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->
                                                       <div class="form-group">
                                                        <input type="hidden"  value="{{@$activity->activity_id}}" name="activity_id"  >
                                                            <label class="control-label col-lg-3">充值类型</label>
                                                            <div class="col-lg-9">
                                                            <select  name="activity_type" data-placeholder="选择类型..." class="chosen-select" style="width:350px;">
                                                                    <option value="0" @if (@$activity->activity_type == 0) selected=selected @endif hassubinfo="true">首冲</option>
                                                                    <option value="1" @if (@$activity->activity_type == 1) selected=selected @endif hassubinfo="true">冲满</option>
                                                                </select>
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">开始日期</label>
                                                            <div class="col-lg-3">
                                                                <input placeholder="开始日期" class="form-control layer-date" name="activity_start_time" id="activity_start_time" value="{{@$activity->activity_start_time}}">
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">结束日期</label>
                                                            <div class="col-lg-3">
                                                            <input placeholder="结束日期" class="form-control layer-date" name="activity_end_time" id="activity_end_time"  value="{{@$activity->activity_end_time}}">
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">充值多少</label>
                                                            <div class="col-lg-9">
                                                            <input type="text" class="form-control input-sm" placeholder="充值多少" datatype="*" value="{{@$activity->money_full}}" name="money_full"  >
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">送多少</label>
                                                            <div class="col-lg-9">
                                                            <input type="text" class="form-control input-sm" placeholder="送多少" datatype="*" value="{{@$activity->money_get}}" name="money_get"  >
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->

                                                        <div class="text-right m-top-md">
                                                            <button type="button" class="btn btn-info btn-activity-update">修改</button>
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
    <script src="/admin/js/plugins/layer/laydate/laydate.js"></script>
<script type="text/javascript">
        $(document).ready(function(){$(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",})});
    var start={elem:"#activity_start_time",format:"YYYY-MM-DD hh:mm:ss",max:"2099-06-16 23:59:59",istime:true,istoday:false,choose:function(datas){end.min=datas;end.start=datas}};var end={elem:"#activity_end_time",format:"YYYY-MM-DD hh:mm:ss",min:laydate.now(),max:"2099-06-16 23:59:59",istime:true,istoday:false,choose:function(datas){start.max=datas}};laydate(start);laydate(end);
    $(".btn-activity-update").on('click',function(){
        var data = $("#activity_update").serialize();
        $.ajax({
            type : 'post',
            url  : '/api/welkin/mcy/activity/update',
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