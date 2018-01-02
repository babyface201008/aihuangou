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
    .set_default {
        position: fixed;
        bottom: 108px;
        background-color: #333;
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
            <a href="#"><em>发货地址</em><span class="fr"><input type="text" placeholder="点击填写信息" class="order_addr" value="{{@$mcy_user->order_addr}}"></span></a>
        </div>
        <div class="link-wrapper">
            <a href="#"><em>联系方式</em><span class="fr"><input type="text" placeholder="点击填写信息" class="order_mobile" value="{{@$mcy_user->order_mobile}}"></span></a>
        </div>        
        <div class="link-wrapper">
            <a href="#"><em>联系人</em><span class="fr"><input type="text" placeholder="点击填写信息" class="order_people" value="{{@$mcy_user->order_people}}"></span></a>
        </div>
         <div class="link-wrapper">
            <a href="#"><em>备注</em><span class="fr"><input type="text" placeholder="点击填写信息" class="order_desc" value="{{@$mcy_user->order_desc}}"></span></a>
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
        <bottom href="javascript:;"  class="btn btn-sm btn-primary set_default">使用默认地址信息</bottom>
        <bottom href="javascript:;"  class="btn btn-sm btn-primary profile_button">提交快递信息</bottom>
    </div>
@endsection
@section('my-js')
 <script>
$(".profile_button").on('click',function(){
     $.ajax({
             url : '/api/mcy/user/update/order/addr',
             type : 'post',
             async : false,
             dataType : 'json',
             data : {
                 _token : "{!! csrf_token() !!}",
                 yungou_id : {{@$yungou->yungou_id}},
                 order_addr : $(".order_addr").val(),
                 order_mobile : $(".order_mobile").val(),
                 order_people : $(".order_people").val(),
                 order_desc : $(".order_desc").val(),
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
                    location.href = '/mcy/user/huode_list/';
                },500);
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

$(".set_default").on('click',function(){
     $.ajax({
             url : '/api/mcy/user/get/default/address',
             type : 'post',
             async : false,
             dataType : 'json',
             data : {
                 _token : "{!! csrf_token() !!}",
                 yungou_id : {{@$yungou->yungou_id}},
                 mcy_user_id : {{@$mcy_user->mcy_user_id}},
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
                $(".order_addr").val(data.address_name),
                $(".order_mobile").val(data.address_mobile),
                $(".order_people").val(data.address_people),
                $(".order_desc").val(data.remark),
                 layer.msg(data.msg,{icon:1,time:2000});
                
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
@endsection