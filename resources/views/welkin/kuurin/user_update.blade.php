@extends('welkin.layout')
@section('title','修改用户')
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
                        <h5>修改用户<small><a href="/welkin/kuurin/users">返回用户列表</a></small></h5>
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
                                                    <form class="form-horizontal no-margin" id="article_create">
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">用户名称</label>
                                                            <div class="col-lg-9">
                                                                <input type="text"  value="{{@$user->username}}" class="form-control input-sm" placeholder="用户名称" datatype="*" name="username" errmsg="用户名称不能为空" >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->                              
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">登录密码</label>
                                                            <div class="col-lg-9">
                                                                 <input type="password"   class="form-control input-sm" placeholder="密码不能少于6个" datatype="*" name="password" errmsg="登录密码不能为空，且密码不能少于6个" >
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
<script type="text/javascript">
    $(".btn-user-update").on('click',function(){
        var username = $("input[name=username]").val(),
            password = $("input[name=password]").val();
        if (username == '' || password == '')
        {
            layer.msg("用户名称或密码不能为空",{icon:2,time:2000});
            return false;
        }else{}
        if (password.length < 6)
        {
            layer.msg('密码不能少于6个',{icon:2,time:2000});
            return false;
        }else{}
        $.ajax({
            type : 'post',
            url  : '/api/welkin/kuurin/user/update',
            dataType : 'json',
            data : {
                _token   : "{!! csrf_token() !!}",
                user_id  : {{@$user->kuurin_user_id}},
                username: username,
                password: hex_sha1(password)
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
                location.href = '/welkin/kuurin/users';
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