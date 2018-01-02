@extends('mcy.layout')
@section('title','个人资料')
@section('my-css')
    <link href="/chyyg1/static/member.css" rel="stylesheet" type="text/css">
    <script src="/chyyg1/static/jquery190.js" language="javascript" type="text/javascript"></script>
    <style>
    .fr input {
        width: 100%;
        text-align: right;
        height: 20px;
    }
    .create_shaidan {
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
    .sub_nav a {
        height: auto !important;
    }
    .shaidan_content {
        /*width: 90%;*/
        width: 100%;
        border: solid 1px gray;
    }
    .shidan_title {
        width: 100%;
        min-width: 250px;
        /*border: solid 1px darkgray;*/
    }
    </style>
@endsection
@section('content')
    <div class="sub_nav">
        <div class="link-wrapper">
            <a href="#"><em>晒单标题</em><span class="fr"><input type="text" name="title" class="shidan_title" value="{{@$shaidan->title}}"></span></a>
        </div>
        <div class="link-wrapper">
            <a href="#"><em>晒单图</em><span class="fr"> 
            <img width="120px" class="upload_pic" id="shaidan_img" src="{{ isset($shaidan->shaidan_img)?$shaidan->shaidan_img:'/images/plus.png'}}" onclick="return $('#pshaidan_img').click()">
            <input type="file" id="pshaidan_img" name="welkin" style="display:none" accept="image" onchange="return uploadImageToServer('pshaidan_img','images', 'shaidan_img','{{csrf_token()}}')"></span></a>
        </div>
        <div class="link-wrapper">
            <a href="#"><em>晒单内容</em><span class="fr"> <textarea class="shaidan_content" id="shaidan_content" rows=10 cols=50>{{@$shaidan->shaidan_content}}</textarea></span></a>
        </div>

        <bottom href="javascript:;"  class="btn btn-sm btn-primary create_shaidan">晒单</bottom>
    </div>
@endsection
@section('my-js')
<script src="/js/mcy/upload.js?v=20170906321"></script>
 <script>
 // $(".upload_pic").on('click',function(){
 //    layer.load(0, {shade: false});
 // });
$(".create_shaidan").on('click',function(){
     if ( $("#shaidan_img").attr('src') == '/admin/js/plugins/layer/skin/default/loading-2.gif')
     {
        alert('图片正在上传，请稍候');
        return false;
     }else{}
     $.ajax({
             url : '/api/mcy/user/create/fshaidan',
             type : 'post',
             async : false,
             dataType : 'json',
             data : {
                 _token : "{!! csrf_token() !!}",
                 yungou_id: {{@$yungou_id}},
                 shaidan_img : $("#shaidan_img").attr('src'),
                 shaidan_content : $(".shaidan_content").val(),
                 title : $(".shidan_title").val(),
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
                    location.reload();
                 },400);
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