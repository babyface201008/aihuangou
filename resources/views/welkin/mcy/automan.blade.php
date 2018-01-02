@extends('welkin.layout')
@section('title','测试页面')
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
                        <!-- <h5>保存测试<small><a href="/welkin/mcy/automans">返回测试列表</a></small></h5> -->
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
                                                    <form class="form-horizontal no-margin" id="automan_create">
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">测试频率(s)</label>
                                                            <div class="col-lg-9">
                                                                <input type="number" value="{{@$automan->test_time}}" class="form-control input-sm" placeholder="测试频率" datatype="*" name="test_time" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->      
                                                        <div class="form-group">
                                                        <label class="control-label col-lg-3">选择类别</label>
                                                           <div class="col-lg-9">
                                                            <select name="category_id" data-placeholder="选择类别..." class="chosen-select" style="width:350px;">
                                                                @foreach($categorys as $category)
                                                                <option @if (@$automan->category_id == $category->category_id) selected="selected" @endif value="{{@$category->category_id}}" hassubinfo="true">{{@$category->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div><!-- /.col -->
                                                        </div><!-- /form-group -->     
                                                        <div class="form-group">
                                                        <label class="control-label col-lg-3">是否测试</label>
                                                           <div class="col-lg-9">
                                                            <select name="is_auto" data-placeholder="是否测试..." class="chosen-select" style="width:350px;">
                                                               <option value="0">否</option>
                                                               <option value="1">是</option>
                                                            </select>
                                                        </div><!-- /.col -->
                                                        </div><!-- /form-group -->    

                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">购买次数1</label>
                                                            <div class="col-lg-9">
                                                                <input type="number" value="{{@$automan->auto_s_count}}" class="form-control input-sm" placeholder="购买次数1" datatype="*" name="auto_s_count" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->   
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">购买次数2</label>
                                                            <div class="col-lg-9">
                                                                <input type="number" value="{{@$automan->auto_e_count}}" class="form-control input-sm" placeholder="购买次数2" datatype="*" name="auto_e_count" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->  
                                                        <div class="form-group">
                                                        <label class="control-label col-lg-3">中间频率</label>
                                                            <div class="col-lg-9">
                                                            <input type="number" value="{{@$automan->center_time}}" class="form-control input-sm" placeholder="中间频率" datatype="*" name="center_time" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->  
                                                        <div class="text-right m-top-md">
                                                            <button type="button" class="btn btn-info btn-automan-add">保存</button>
                                                            <a href="javascript:;"  class="btn btn-info btn-automan-test">测试</a>
                                                            <a href="" target="_blank" style="display: none;" class="btn btn-info btn-automan-run"><span>测试</span></a>
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
    $(".btn-automan-test").on('click',function(){
        // location = '/welkin/mcy/automan/run';
        var auto_s_count = $("input[name=auto_s_count]").val();
        var auto_e_count = $("input[name=auto_e_count]").val();
        var center_time = $("input[name=center_time]").val();
        var test_time = $("input[name=test_time]").val();
        var is_auto = $('select[name=is_auto]').val();
        if (parseInt(auto_s_count) > parseInt(auto_e_count))
        {
            layer.msg('购买次数2不能小于购买次数1');
            return false;
        }
        var href = '/welkin/mcy/automan/run?type=2&'+'go_type=welkin&category_id='+$('select[name=category_id]').val() + "&is_auto=" + is_auto + "&auto_s_count=" + auto_s_count + "&auto_e_count=" + auto_e_count+ "&test_time=" + test_time + "&center_time=" + center_time; 
        $(".btn-automan-run").attr('href',href);
        $(".btn-automan-run span").click();
    });
    $(".btn-automan-add").on('click',function(){
        var data = $("#automan_create").serialize();
        $.ajax({
            type : 'post',
            url  : '/api/welkin/mcy/automan/update',
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
                // location.href = '/welkin/mcy/automans';
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