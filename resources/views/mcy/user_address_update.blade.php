@extends('mcy.layout')
@section('title','个人资料')
@section('my-css')
    <link href="/chyyg1/static/member.css" rel="stylesheet" type="text/css">
    <script src="/chyyg1/static/jquery190.js" language="javascript" type="text/javascript"></script>
    <style>
    .fr input {
        text-align: right;
    }
    .create_address {
        position: fixed;
        bottom: 108px;
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
    .delete_address {
        position: fixed;
        bottom: 54px;
        background-color: red;
        width: 100%;
        border-radius: 5px;
        text-align: center;
        line-height: 50px;
        font-size: 20px;
        color: white;
    }
    .is_set {
        position: absolute;
        color: #666;
        text-align: right;
        padding-top: 16px;
        right: 20px;
        width: 20%;
    }
    </style>
@endsection
@section('content')
    <div class="sub_nav">
        <div class="link-wrapper">
            <a href="#"><em>详细地址</em><span class="fr"><input type="text" placeholder="详细地址,点击填写" class="address_name" value="{{@$address->address_name}}"></span></a>
        </div>
        <div class="link-wrapper">
            <a href="#"><em>联系方式</em><span class="fr"><input type="text" placeholder="联系方式,点击填写" class="address_mobile" value="{{@$address->address_mobile}}"></span></a>
        </div>
        <div class="link-wrapper">
            <a href="#"><em>联系人</em><span class="fr"><input type="text" placeholder="联系人,点击填写" class="address_people" value="{{@$address->address_people}}"></span></a>
        </div>
        <div class="link-wrapper">
            <a href="#"><em>备注</em><span class="fr"><input type="text" placeholder="备注,点击填写" class="remark" value="{{@$address->remark}}"></span></a>
        </div>
        <div class="link-wrapper">
            <a href="javascript:;"><em>是否设置为默认地址</em><i></i><select id="is_set" class="is_set">
            @if ($address->is_set == 0)
            <option value="0">否</option>
            <option value="1">是</option>
            @else
            <option value="1">是</option>
            <option value="0">否</option>
            @endif
            </select></a>
        </div>
<!--         <div class="link-wrapper">
            <a href="#"><em>现居地</em><i></i><span class="fr"></span></a>
            <a href="#"><em>家乡</em><i></i><span class="fr"></span></a>
        </div> -->
        <bottom href="javascript:;"  class="btn btn-sm btn-primary create_address">修改收货地址</bottom>
        <bottom href="javascript:;"  class="btn btn-sm btn-primary delete_address">删除地址</bottom>
    </div>
@endsection
@section('my-js')
 <script>
$(".create_address").on('click',function(){
     $.ajax({
             url : '/api/mcy/user/update/address',
             type : 'post',
             async : false,
             dataType : 'json',
             data : {
                 _token : "{!! csrf_token() !!}",
                 address_name : $(".address_name").val(),
                 is_set : $(".is_set").val(),
                 address_mobile : $(".address_mobile").val(),
                 address_id : {{@$address->address_id}},
                 address_people : $(".address_people").val(),
                 remark : $(".remark").val(),
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
                    location.href = '/mcy/user/address';
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
$(".delete_address").on('click',function(){
    parent.layer.confirm('确定删除该地址?',function(){
     $.ajax({
             url : '/api/mcy/user/delete/address',
             type : 'post',
             async : false,
             dataType : 'json',
             data : {
                 _token : "{!! csrf_token() !!}",
                 address_id : {{@$address->address_id}},
             },
             success: function(data) {
                 console.log(data);
                 if(data == null) {
                     parent.layer.msg('服务端错误', {icon:2, time:2000});
                     return;
                 }
                 if(data.ret != 0) {
                     parent.layer.msg(data.msg, {icon:2, time:2000});
                     return;
                 }
                 parent.layer.msg(data.msg,{icon:1,time:2000});
                setTimeout(function(){
                    location.href = '/mcy/user/address';
                },500);
             },
             error: function(xhr, ret, error) {
                 console.log(xhr);
                 console.log(ret);
                 console.log(error);
                 parent.layer.msg('ajax error', {icon:2, time:2000});
             },
             beforeSend: function(xhr){
                 parent.layer.load(0, {shade: false});
             },
             complete: function(){
                 parent.layer.closeAll('loading');

             },
         });
    });
});
 </script>
@endsection