<!DOCTYPE html>
<html class=""><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>{{@$site->site_name}}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta content="telephone=no" name="format-detection">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">

<link href="/chyyg1/comm.css?v=20170925" rel="stylesheet" type="text/css">
<script src="/chyyg1/jquery-1.9.1.min.js" language="javascript" type="text/javascript"></script>
<script type="text/javascript" src="/chyyg1/jquery.cookie.js"></script>
<link href="/chyyg1/index.css" rel="stylesheet" type="text/css">
<link href="/chyyg1/swiper-3.3.1.min.css" rel="stylesheet" type="text/css">
<script src="/chyyg1/swiper-3.3.1.min.js" language="javascript" type="text/javascript"></script>
<link rel="stylesheet" href="/chyyg1/jquery.fancybox.css" type="text/css" media="screen">
<script src="https://cdn.bootcss.com/layer/3.0.1/layer.min.js"></script>
<script type="text/javascript" src="/chyyg1/jquery.fancybox.pack.js"></script>
<link href="https://cdn.bootcss.com/weui/1.1.2/style/weui.min.css" rel="stylesheet">
<script>
      function GetVerNum(){var D=new Date();return D.getFullYear().toString().substring(2,4)+'.'+(D.getMonth()+1)+'.'+D.getDate()+'.'+D.getHours()+'.'+(D.getMinutes()<10?'0':D.getMinutes().toString().substring(0,1))}
</script>
<link rel="stylesheet" href="/chyyg1/welkin.css?v=20170925" type="text/css" media="screen">
<script type="text/javascript" src="/chyyg1/welkin.js?v=27123127"></script>
<style>

    .app-icon-wrapper {
        background-color: #373B3E;
        padding: 8px;
        position: relative;
        width: 100%;
        box-sizing: border-box;
        overflow: hidden;
    }

    .app-icon-wrapper a {
        display: block;
    }

    .app-icon-wrapper a.info-icon {
        width: 100%;
    }

    .app-icon-wrapper .info-content {
        width: 100%;
        margin: 0 auto;
    }

    .app-icon-wrapper .info-icon .set-icon {
        border-radius: 20px;
        display: block;
        height: 30px;
        width: 30px;
        background: rgba(0, 0, 0, 0) url("http://yyg2.chkg99.com/images/weixin_logo.jpg") no-repeat scroll 0 0 / 30px auto;
        float: left;
    }

    .app-icon-wrapper .info-icon .info {
        float: left;
        line-height: 30px;
        color: #fff;
        font-size: 18px;
        width: calc(100% - 46px);
        text-align: center;
    }

    .app-icon-wrapper .close-icon {
        position: absolute;
        width: 16px;
        height: 30px;
        right: 8px;
        z-index: 1;
    }

    .app-icon-wrapper .close-icon:before {
        content: "\2715";
        font-size: 20px;
        line-height: 30px;
        color: #eee;
    }

    .btn-wrap {
        position: relative;
        margin: 10px 0 0;
        width: 100%;
    }

    .btn-wrap .buy-btn {
        display: block;
        width: 50%;
        height: 28px;
        line-height: 28px;
        text-align: center;
        border: 1px solid #dc332d;
        color: #dc332d;
        border-radius: 16px;
        margin: 0 20%;
    }

    .btn-wrap .gRate {
        display: block;
        width: 30px;
        height: 30px;
        position: absolute;
        top: 0;
        /*background-color: #dc332d;*/
        border-radius: 15px;
        right: 5%;
    }

    .btn-wrap .gRate s {
        display: inline-block;
        width: 100%;
        height: 100%;
        margin: -2px 0 0 -14px;
        background: url(/chyyg1/add_car.png);
        background-size: 35px 35px;
        /*background-size: 80px auto;*/
        /*background-position: -58px -29px;*/
    }

    .swiper-slide {
        text-align: center;
        justify-content: center;
        align-items: center;
        display: flex;
    }

    .swiper-slide img {
        height: auto;
        width: 100%;
        display: block;
    }

    .swiper-slide .swiper-lazy-preloader {
        margin-top: 50px;
    }

    .rolling-number {
        background: #fff;
        padding: 8px;
        text-align: center;
        border-bottom: 1px solid #CCC;
        font-size: 16px;
        clear: both;
    }

    .rolling-number .rolling-content ul {
        margin-top: 8px;
        color: #dc332d;
    }

    .rolling-number .rolling-content ul li {
        display: inline-block;
    }

    .rolling-number .rolling-content ul li.rolling-title {
        color: #999;
    }

    .rolling-number .rolling-content ul li.num {
        position: relative;
        border: 1px solid #CCC;
        display: inline-block;
        width: 18px;
        font-size: 16px;
        overflow: hidden;
        height: 22px;
        line-height: 22px;
    }

    .rolling-number .rolling-content ul li cite {
        width: 18px;
        position: absolute;
        left: 0;
        z-index: 1;
    }

    .rolling-number .rolling-content ul li cite em {
        width: 18px;
        display: block;
    }

    .rolling-number li i {
        border-top: 1px solid #ededed;
        height: 0;
        left: 0;
        position: absolute;
        top: 11px;
        width: 100%;
        z-index: 0;
    }

    #published .m-round {
        border: none;
        border-radius: 0;
        background: #fff;
        box-shadow: none;
    }

    .m-tt1 {
        margin: 0;
        background: #FFF;
        overflow: hidden;
        border-bottom: 1px solid rgba(246,246,246,0.8);
    }

    .m-tt1 a {
        width: 100%;
        display: block;
        color: #999;
        padding-left: 5px;
    }

    .m-tt1 h2 {
        width: 100%;
        margin: 0;
        line-height: 32px;
        font-size: 14px;
        font-weight: normal;
    }

    .m-tt1 .z-arrow {
        width: 8px;
        height: 8px;
        border-width: 1px 1px 0 0;
        float: right;
        margin-top: 10px;
        margin-right: 30px;
    }

    .m-lott-list {
        overflow: hidden;
    }

    .m-lott-list li {
        width: 50%;
        float: left;
        border-bottom: 1px solid #f5f5f5;
        border-right: 1px solid #f5f5f5;
        padding: 0 5px 5px;
        box-sizing: border-box;
    }

    .m-lott-list li:nth-child(n+3) {
        border-bottom: none;
    }

    .m-lott-list li .m-lott-text {
        float: left;
        width: 53%;
        margin: 1% 2%;
    }

    .m-lott-list li .m-lott-text p {
        color: #dc332d;
    }

    .m-lott-list li .m-lott-text a {
        color: #666;
        font-size: 12px;
        display: block;
        height: 32px;
        width: 100%;
        overflow: hidden;
    }

    .m-lott-list li .m-lott-pic {
        float: right;
        width: 42%;
        display: block;
    }

    .m-lott-list li .m-lott-pic a {
        width: 100%;
        height: 100%;
        display: block;
    }

    .m-lott-list li .m-lott-pic img {
        width: 200px;
        max-width: 100%;
        height: auto;
        float: right;
    }

    .m-lott-list .m-lott-state {
        clear: left;
        padding: 2px 0 0 1px;
    }

    .m-lott-list .m-lott-state .u-time {
        color: #dc332d;
        padding: 3px;
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        height: 30px;
        line-height: 30px;
    }

    .m-lott-list .m-lott-state .u-time em {
        padding-right: 3px;
    }

    .m-lott-list .m-lott-state .u-user {
        display: block;
        margin-top: 18px;
        width: 53%;
        white-space: nowrap;
        overflow: hidden;
        line-height: 12px;
    }

    /*.m-lott-list .m-lott-item {*/
        /*border: 1px solid #F4F4F4;*/
        /*border-bottom: 1px solid #F4F4F4 !important;*/
        /*}*/

        .m-lott-list .m-lott-item:nth-child(even) {
            border-left: none;
        }

        .m-lott-list .m-lott-item:nth-child(n+3) {
            border-top: none;
        }
        #published .lott-list{
            overflow: hidden;
        }
      
</style>
@yield('my-css')

<body>
    @yield('content')
    @include("mcy.footer")

</div>
<style>
    #pageDialogBG {
        -webkit-border-radius: 5px;
        width: 255px;
        height: 45px;
        color: #fff;
        font-size: 16px;
        text-align: center;
        line-height: 45px;
    }
</style>
<div id="pageDialogBG" class="pageDialogBG">
    <div class="Prompt"></div>
</div>


</body>

<style type="text/css">.fancybox-margin{margin-right:0px;}</style>
<script>
  var Path = new Object();
  Path.Skin="{{Request::root()}}";  
  Path.Webpath = "{{Request::root()}}";
  Path.imgpath = "{{Request::root()}}";
  Path.remoteImg = "{{Request::root()}}";
  
  var Base={head:document.getElementsByTagName("head")[0]||document.documentElement,Myload:function(B,A){this.done=false;B.onload=B.onreadystatechange=function(){if(!this.done&&(!this.readyState||this.readyState==="loaded"||this.readyState==="complete")){this.done=true;A();B.onload=B.onreadystatechange=null;if(this.head&&B.parentNode){this.head.removeChild(B)}}}},getScript:function(A,C){var B=function(){};if(C!=undefined){B=C}var D=document.createElement("script");D.setAttribute("language","javascript");D.setAttribute("type","text/javascript");D.setAttribute("src",A);this.head.appendChild(D);this.Myload(D,B)},getStyle:function(A,B){var B=function(){};if(callBack!=undefined){B=callBack}var C=document.createElement("link");C.setAttribute("type","text/css");C.setAttribute("rel","stylesheet");C.setAttribute("href",A);this.head.appendChild(C);this.Myload(C,B)}}
  function GetVerNum(){var D=new Date();return D.getFullYear().toString().substring(2,4)+'.'+(D.getMonth()+1)+'.'+D.getDate()+'.'+D.getHours()+'.'+(D.getMinutes()<10?'0':D.getMinutes().toString().substring(0,1))}
  Base.getScript('{{Request::root()}}/chyyg1/Bottom.js?v='+GetVerNum());
</script>
@yield('my-js')

</html>