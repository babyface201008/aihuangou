<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>@yield('title')</title>
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    
    <link href="/chyyg/css/comm.css" rel="stylesheet" type="text/css">
    <link href="/chyyg/css/index.css" rel="stylesheet" type="text/css">
   <script src="/plugin/layer/layer.js"></script>
    <script src="/chyyg/js/jquery.js" language="javascript" type="text/javascript"></script>
    <script id="pageJS" data="https://skin.1yyg.net/v43/weixin/JS/Index.js?v=161012" language="javascript" type="text/javascript"></script>
    <script type="text/javascript">
        function GetVerNum() {
            var D = new Date();
            return D.getFullYear().toString().substring(2, 4) + '.' + (D.getMonth() + 1) + '.' + D.getDate() + '.' + D.getHours() + '.' + (D.getMinutes() < 10 ? '0' : D.getMinutes().toString().substring(0, 1));
        }
    </script>
    @yield('my-css')
</head>
<body fnav="1" class="g-acc-bg">

    <div class="marginB" id="loadingPicBlock">
        @yield('content')
        
        <div class="footer clearfix">
            <ul>
                <li class="f_home"><a href="/" class="hover"><i></i>云购</a></li>
                <li class="f_announced"><a href="/lottery"><i></i>最新揭晓</a></li>
                <li class="f_single"><a href="/shaidan"><i></i>晒单</a></li>
                <li class="f_car"><a id="btnCart" href="/cart"><i></i>购物车</a></li>
                <li class="f_personal"><a href="/mcy/user"><i></i>我的云购</a></li>
            </ul>
        </div>

        <div class="weixin-mask" style="display: none;"></div>
    </div>
    @yield('my-js')
</body>
</html>
