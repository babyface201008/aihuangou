@extends('welkin.layout')
@section('title','添加支付')
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
                        <h5>添加支付<small><a href="/welkin/mcy/payinfos">返回支付列表</a></small></h5>
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
                                                    <form class="form-horizontal no-margin" id="payinfo_create">
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">支付名称</label>
                                                            <div class="col-lg-9">
                                                                <input type="text" class="form-control input-sm" placeholder="支付名称" datatype="*" name="pay_name" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->      
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">支付账号</label>
                                                            <div class="col-lg-9">
                                                                <input type="text" class="form-control input-sm" placeholder="支付账号" datatype="*" name="pay_account" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">产品类型</label>
                                                            <div class="col-lg-9">
                                                                <input type="text" class="form-control input-sm" placeholder="产品类型" datatype="*" name="product_type" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">支付密码</label>
                                                            <div class="col-lg-9">
                                                               <input type="text" class="form-control input-sm" placeholder="" datatype="*" name="pay_secret">
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">排序</label>
                                                            <div class="col-lg-9">
                                                                <input type="number" value="0" class="form-control input-sm" placeholder="排序" datatype="*" name="sort" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->    
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">支付函数方法</label>
                                                            <div class="col-lg-9">
                                                                <input type="text" class="form-control input-sm" placeholder="支付函数方法" datatype="*" name="method" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->    
                                                        <div class="form-group">
                                                            <label class="col-lg-3 control-label">图标</label>
                                                            <div class="col-lg-8">
                                                                <img width="100px" class="pay_logo" id="pay_logo" src="{{ isset($payinfo->pay_logo)?$payinfo->pay_logo:'/images/plus.png'}}" onclick="return $('#ppay_logo').click()">
                                                                <input type="file" id="ppay_logo" name="welkin" style="display:none" accept="image" onchange="return uploadImageToServer('ppay_logo','images', 'pay_logo','{{csrf_token()}}')">
                                                            </div>
                                                        </div>                 
                                                        <div class="form-group">
                                                        <label class="control-label col-lg-3">是否启用</label>
                                                           <div class="col-lg-9">
                                                            <select name="status" data-placeholder="选择是否启用..." class="chosen-select" style="width:350px;">
                                                                <option value="0" hassubinfo="true">启用</option>
                                                                <option value="1" hassubinfo="true">不启用</option>
                                                            </select>
                                                        </div><!-- /.col -->
                                                        </div><!-- /form-group -->    

                                                     
                                                        <div class="text-right m-top-md">
                                                            <button type="button" class="btn btn-info btn-payinfo-add">添加</button>
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
<script type="text/javascript">
    $(".btn-payinfo-add").on('click',function(){
        var data = $("#payinfo_create").serialize();
        $.ajax({
            type : 'post',
            url  : '/api/welkin/mcy/payinfo/create',
            dataType : 'json',
            data : {
                _token   : "{!! csrf_token() !!}",
                pay_logo : ($("#pay_logo").attr('src') == '/images/plus.png')?'':$("#pay_logo").attr('src'),
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
                location.href = '/welkin/mcy/payinfos';
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