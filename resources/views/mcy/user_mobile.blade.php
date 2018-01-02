@extends('mcy.layout')
@section('title','手机验证')
@section('my-css')
    <link href="/chyyg1/static/security.css" rel="stylesheet" type="text/css">
 
@endsection
@section('content')
<section>
    <div class="authentication-con clearfix">
        <ul>
            <li class="pd20">
                <li class="enter-word">
                    <input id="txtMobile" maxlength="11" type="text" placeholder="请输入手机号码" class="rText">
                </li>                
                <li class="enter-word">
                    <input id="txtCode" maxlength="6" type="text" placeholder="请输入6位验证码" class="rText">
                    <a id="btnSend" href="javascript:;" class="orgBtn">获取验证码</a>
                </li>
                <li><a id="btnSubmit" href="javascript:;" class="orgBtn grayBtn">确认</a></li>
                <li class="gray9">换了手机号或遗失？请致电客服申诉解除绑定<br>
                </li>
            </ul>
        </div>
    </section>
    @endsection
@section('my-js')
 <script type="text/javascript">
    var c = 1;
    var a = 1;
     $("#btnSend").on('click',function(){
        if (a == 1) {

        }else{
            return false;
        }
        a = 2;
        var mobile = $("#txtMobile").val();
        var is_check = checkPhone();
        if (is_check)
        {
            $.ajax({
                type : 'post',
                url  : '/api/mcy/user/send/sms',
                dataType : 'json',
                data : {
                    _token   : "{!! csrf_token() !!}",
                    mobile : mobile
                },
                success: function(data) {
                    console.log(data);
                    if(data == null) {
                    layer.msg('服务器繁忙,请稍候再试', {icon:2, time:2000});
                      return;
                    }
                    if(data.ret != 0) {
                        layer.msg(data.msg, {icon:2, time:2000});
                         $("#btnSubmit").removeClass('grayBtn');
                        c = 2;
                        return;
                    }
                    c = 2;
                    $("#btnSubmit").removeClass('grayBtn');
                    layer.msg(data.msg, {icon:1, time:2000});
                },
                error: function(xhr, ret, error) {
                    console.log(xhr);
                    console.log(ret);
                    console.log(error);
                    layer.msg('服务器繁忙,请稍候再试', {icon:2, time:2000});
                    a = 1;
                },
                beforeSend: function(xhr){
                    layer.load(0, {shade: false});
                },
                complete: function(){
                    layer.closeAll('loading');
                    a = 1;
                }
            });
        }else{

        }

     });
     $("#btnSubmit").on('click',function(){
        var mobile = $("#txtMobile").val();
        if (c == 1){
            return false;
        }else{}
        var code = $("#txtCode").val();
        $.ajax({
            type : 'post',
            url  : '/api/mcy/user/mobile/add',
            dataType : 'json',
            data : {
                _token   : "{!! csrf_token() !!}",
                mobile : mobile,
                code : code
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
                setTimeout(function(){
                    location.href('/mcy/user');
                },500);
            },
            error: function(xhr, ret, error) {
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
     function checkPhone(){ 
        var phone = document.getElementById('txtMobile').value;
        if(!(/^1(3|4|5|7|8)\d{9}$/.test(phone))){ 
            layer.msg("手机号码有误，请重填")
            // alert("手机号码有误，请重填");  
            a = 1;            
            return false; 
        }else{
            return true;
        }
    }
 </script>
@endsection

