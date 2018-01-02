@extends('welkin.layout')
@section('title','登录界面')
@section('my-css')
   <script>if(window.top !== window.self){ window.top.location = window.location;}</script>
@endsection
@section('content')
<div class="middle-box text-center loginscreen  animated fadeInDown">
  <div>
    <div>
      <h1 class="logo-name"><img src="/favicon.ico" /></h1>
    </div>
    <h3>{{$site->site_name}}-惊喜无限</h3>
    <form class="m-t" role="form" method="post" action="/api/welkin
loginCheck">
      <div class="form-group">
        <input type="text" name="username" class="form-control" placeholder="用户名" required="">
      </div>
      <div class="form-group">
        <input type="password" name="password" class="form-control" placeholder="密码" required="">
      </div>
        <input name="_token" type="hidden" value="{{csrf_token()}}">
      <button type="button" class="btn btn-success block full-width m-b btn-login">登 录</button>
      </p>
    </form>
    @if (isset($errmsg))
    <div class="alert alert-success">
        {{ $errmsg }}
    </div>
    @endif
    @if ((Session('errmsg')))
    <div class="alert alert-success">
      {{ Session('errmsg') }}
    </div>
    @endif
  </div>
</div>
@endsection
@section('my-js')
<script>
    $(".btn-login").on('click',function(){
        var username = $("input[name=username]").val(),
            password = $("input[name=password]").val();

        if (username == '' || password == '')
        {
            layer.msg('用户名或密码不能为空',{icon:2,time:2000});
            // alert('用户名或密码不能为空');
            return false;
        }

        $.ajax({
            type : 'post',
            url  : '/api/welkin/login',
            dataType : 'json',
            data : {
                _token   : "{!! csrf_token() !!}",
                username : username,
                password : hex_sha1(password)
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
                location.href = '/welkin';
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
