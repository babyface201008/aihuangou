<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
    <meta content="initial-scale=1, minimum-scale=1, user-scalable=no, maximum-scale=1, width=device-width" name="viewport" /> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> 
    <!-- 优先使用 IE 最新版本和 Chrome --> 
    <meta name="renderer" content="webkit" /> 
    <!-- 360浏览器切换极速模式 --> 
    <meta http-equiv="Cache-Control" content="no-siteapp" /> 
    <!-- 禁止百度手机转码 --> 
    <base href="." /> 
    <meta name="keywords" content="梦苍源的世界,梦苍源,asmcy,mcy,揭阳动漫,动漫,梦,二次元,coser,cos,cosplay,游玩,同人,小说,视频,同人绘画,绘画" /> 
    <meta name="rights" content="小苍" /> 
    <meta name="description" content="米图设计室是一家情感体验设计公司，专注网站设计、移动开发及界面设计服务。" /> 

    <title>梦苍源，一个望着苍天发呆的网站</title>
    <script>
        var _hmt = _hmt || [];
        (function() {
          var hm = document.createElement("script");
          hm.src = "https://hm.baidu.com/hm.js?86a20436b3fca4787008e593e2a2dc62";
          var s = document.getElementsByTagName("script")[0]; 
          s.parentNode.insertBefore(hm, s);
      })();
    </script>
    @yield('my-css')
</head>
<body>
@yield('content')
</body>
<script type="text/javascript" src="/js/libs/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="/js/libs/transition.js"></script>
<script type="text/javascript" src="/js/libs/zoom.js"></script>
@yield('my-js')
</html>