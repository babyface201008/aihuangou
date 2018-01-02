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
    <meta name="description" content="梦苍源起源广东揭阳，来着二次元的宅男，准备奔向那条彩虹桥" /> 
    <meta charset="utf-8" name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            ]); ?>
        </script>
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
    <link rel="stylesheet" href="/css/index2.css">
    <style type="text/css">
        .header{
            height: 40px;
            clear: both;
            position: relative;
            /*margin-bottom:20px ;*/
            /*margin-bottom: 40px;*/
        }
        .title_name {
            height: 28px;
        }

        .sub_nav_title {
            width: 100%;
            height: 40px;
            line-height: 18px;
            text-align: center;
            font-size: 18px;
            color: #ff9000;
            position: relative;
            /*display: none;*/
        }
        .sub_nav_title li {
            list-style-type: none;
            height: 40px;
            opacity: 0.8;
            background-color:#333;
            line-height: 40px;;
            position: relative;
        }
    </style>

    @yield('my-css')
</head>
<body>


@yield('content')
</body>
<script src="/js/libs/jquery-2.2.3.min.js"></script>
<script src="/js/libs/layer/layer.js"></script>
<script type="text/javascript">
    $(document).on('click','.title_name',function(){
        // $(".sub_nav_title").toggle(1000);
        location.href = '/';
    })
    $(window).scroll(function(){  
        var top = $(window).scrollTop()
        if (top > 40)
        {
            $(".header").css('position','fixed');
        }else{
            $(".header").css('position','relative');
        }
    })
</script>
@yield('my-js')
</html>
