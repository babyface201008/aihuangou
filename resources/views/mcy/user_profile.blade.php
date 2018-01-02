@extends('mcy.layout')
@section('title','个人资料')
@section('my-css')
    <link href="/chyyg1/static/member.css" rel="stylesheet" type="text/css">
    <script src="/chyyg1/static/jquery190.js" language="javascript" type="text/javascript"></script>
    <style>
    .fr input {
        text-align: right;
    }
    .profile_button {
        position: fixed;
        bottom: 54px;
        background-color: #dc332d;
        width: 100%;
        border: 1px solid #fff;
        text-align: center;
        line-height: 50px;
        color: white;
        font-size: 20px;
        min-height: 50px;
        border-radius: 5px;
    }

    </style>
@endsection
@section('content')
    <div class="sub_nav">
        <div class="link-wrapper">
            <a href="#"><em>昵称</em><span class="fr"><input type="text" class="profile_username" value="{{@$mcy_user->username}}"></span></a>
        </div>
        <div class="link-wrapper">
            <a href="#"><em style="display: block;float: left;padding-right: 10px">修改头像</em>
                <img src="
                        @if($mcy_user->avator_img=='')
                        /images/plus.png
                        @else
                           {{$mcy_user->avator_img}}
                        @endif" id="avator_img" border="0/" style="width: 50px;height: 50px" onclick="return $('#avatorimg').click()">
                <span class="fr">
                    <input type="file" id="avatorimg" name="welkin" accept="image"
    onchange="return uploadImageToServer('avatorimg','avatorimg', 'avator_img','{{csrf_token()}}')">
</span></a>
        </div>
<!--         <div class="link-wrapper">
            <a href="javascript:;"><em>性别</em><i></i><span class="fr">保密</span><select id="selSex" class="sex"><option value="2">男</option><option value="1">女</option><option value="3">保密</option></select></a>
            <a href="javascript:;"><em>生日</em><strong>一年之内只能修改一次</strong><i></i><span class="fr"></span><input id="dateBirth" type="date" value="" min="1952-01-01" max="2012-06-16" class="date"></a>
            <a href="#"><em>电话</em><strong>备用联系信息不作公开</strong><i></i><span class="fr"></span></a>
        </div>
        <div class="link-wrapper">
            <a href="#"><em>现居地</em><i></i><span class="fr"></span></a>
            <a href="#"><em>家乡</em><i></i><span class="fr"></span></a>
        </div> -->
        <bottom href="javascript:;"  class="btn btn-sm btn-primary profile_button">修改昵称</bottom>
    </div>
@endsection
@section('my-js')
 <script>
$(".profile_button").on('click',function(){

     $.ajax({
             url : '/api/mcy/user/update/username',
             type : 'post',
             async : false,
             dataType : 'json',
             data : {
                 _token : "{!! csrf_token() !!}",
                 username : $(".profile_username").val(),
                 avator_img : ($.trim($("#avator_img").attr('src')) == '/images/plus.png')?'':$("#avator_img").attr('src'),

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
                 layer.msg(data.msg,{icon:1,time:2000});
                 setTimeout(function(){
                     window.location.href=Gobal.Webpath+"/mcy/user";
                 },2000);
                 return ;

                
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
             },
         });
});
 </script>
 <script src="/js/mcy/upload.js"></script>
@endsection