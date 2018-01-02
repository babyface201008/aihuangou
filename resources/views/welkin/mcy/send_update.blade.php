@extends('welkin.layout')
@section('title','修改发货管理')
@section('my-css')
    <link href="/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet"> 

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
                        <h5>修改发货管理<small></h5>
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
                                                    <form class="form-horizontal no-margin" id="article_update">
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">快递名称</label>
                                                            <div class="col-lg-9">
                                                                <input type="text" class="form-control input-sm" placeholder="快递名称" datatype="*" value="{{@$yungou->order_kd}}" name="order_kd" errmsg="" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">快递号</label>
                                                            <div class="col-lg-9">
                                                            <input type="text" class="form-control input-sm" placeholder="快递号" datatype="*" value="{{@$yungou->order_kd_number}}" name="order_kd_number"  >
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->
                                                       <div class="text-right m-top-md">
                                                       <button type="button" class="btn btn-info btn-order-update">修改</button>
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
    $(".btn-order-update").on('click',function(){
        var order_kd = $("input[name=order_kd]").val();
        var order_kd_number = $("input[name=order_kd_number]").val();
        $.ajax({
            type : 'post',
            url  : '/api/welkin/mcy/order/info/update',
            dataType : 'json',
            data : {
                _token   : "{!! csrf_token() !!}",
                order_kd: order_kd,
                order_kd_number: order_kd_number,
                yungou_id : {{@$yungou->yungou_id}},
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
                // location.href = '/order/wx/orders';
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