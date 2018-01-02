@extends('welkin.layout')
@section('title','修改用户')
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
                        <h5>修改用户<small><a href="/welkin/mcy/users">返回用户列表</a></small></h5>
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
                                                    <form class="form-horizontal no-margin" id="user_update">
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">用户名称</label>
                                                            <div class="col-lg-9">
                                                                <input type="text"  value="{{@$user->username}}" class="form-control input-sm" placeholder="用户名称" datatype="*" name="username" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->            
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">昵称</label>
                                                            <div class="col-lg-9">
                                                                <input type="text"  value="{{@$user->nickname}}" class="form-control input-sm" placeholder="昵称" datatype="*" name="nickname" errmsg="昵称不能为空" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->    
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">邮箱</label>
                                                            <div class="col-lg-9">
                                                            <input type="text"  value="{{@$user->email}}" class="form-control input-sm" placeholder="邮箱" datatype="*" name="email" errmsg="邮箱不能为空" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->    
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">地址</label>
                                                            <div class="col-lg-9">
                                                            <input type="text"  value="{{@$user->ip_addr}}" class="form-control input-sm" placeholder="地址" datatype="*" name="ip_addr" errmsg="邮箱不能为空" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->    

                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">手机</label>
                                                            <div class="col-lg-9">
                                                            <input type="text"  value="{{@$user->mobile}}" class="form-control input-sm" placeholder="手机" datatype="*" name="mobile" errmsg="手机不能为空" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->    
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">余额</label>
                                                            <div class="col-lg-9">
                                                                <input type="number" value="{{@$user->money}}" class="form-control input-sm" placeholder="余额" datatype="*" name="money" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->    
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">积分数</label>
                                                            <div class="col-lg-9">
                                                                <input type="number" value="{{@$user->score}}" class="form-control input-sm" placeholder="积分数" datatype="*" name="score" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->    
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">经验值</label>
                                                            <div class="col-lg-9">
                                                                <input type="number" value="{{@$user->jingyan}}" class="form-control input-sm" placeholder="经验值" datatype="*" name="jingyan" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->    
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">佣金</label>
                                                            <div class="col-lg-9">
                                                                <input type="number" value="{{@$user->slave_money}}" class="form-control input-sm" placeholder="佣金" datatype="*" name="slave_money" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->       
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">上级ID</label>
                                                            <div class="col-lg-9">
                                                                <input type="number" value="{{@$user->master_id}}" class="form-control input-sm" placeholder="上级ID" datatype="*" name="master_id" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->    
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">微信openid</label>
                                                            <div class="col-lg-9">
                                                                <input type="text"  value="{{@$user->openid}}" class="form-control input-sm" placeholder="微信openid" datatype="*" name="openid" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->    
                                                        <div class="form-group">
                                                            <label class="col-lg-3 control-label">头像</label>
                                                            <div class="col-lg-8">
                                                                <img width="250px" class="avator_img" id="avator_img" src="{{ (isset($user->avator_img) && !(@$user->avator_img == ''))?$user->avator_img:'/images/plus.png'}}" onclick="return $('#pavator_img').click()">
                                                                <input type="file" id="pavator_img" name="welkin" style="display:none" accept="image" onchange="return uploadImageToServer('pavator_img','images', 'avator_img','{{csrf_token()}}')">
                                                            </div>
                                                        </div>                   
                                                        <div class="form-group">
                                                        <label class="control-label col-lg-3">性别</label>
                                                           <div class="col-lg-9">
                                                            <select name="sex" data-placeholder="选择性别..." class="chosen-select" style="width:350px;">
                                                                <option @if(@$user->sex == 1) selected="selected" @endif value="1" hassubinfo="true">男</option>
                                                                <option @if(@$user->sex == 0) selected="selected" @endif value="0" hassubinfo="true">其他</option>
                                                                <option @if(@$user->sex == 2) selected="selected" @endif value="2" hassubinfo="true">女</option>
                                                            </select>
                                                        </div><!-- /.col -->
                                                        </div><!-- /form-group -->    
                                                        <div class="text-right m-top-md">
                                                            <button type="button" class="btn btn-info btn-user-update">修改</button>
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
    $(".btn-user-update").on('click',function(){
      var data = $("#user_update").serialize();
        $.ajax({
            type : 'post',
            url  : '/api/welkin/mcy/user/update',
            dataType : 'json',
            data : {
                _token   : "{!! csrf_token() !!}",
                user_id  : {{@$user->mcy_user_id}},
                avator_img : ($("#avator_img").attr('src') == '/images/plus.png')?'':$("#avator_img").attr('src'),
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
                location.href = '/welkin/mcy/users';
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