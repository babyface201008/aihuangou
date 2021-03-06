
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<title>jQuery手机端3D立体图片切换效果DEMO演示</title>
<link href="/demo/css/basic.css" rel="stylesheet" type="text/css">

<!--主要样式-->
<link href="/demo/css/hot.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="/demo/js/jquery.js"></script>
<script type="text/javascript" src="/demo/js/modernizr.custom.53451.js"></script>
<script type="text/javascript" src="/demo/js/jquery.gallery.js"></script>
<script type="text/javascript" src="/demo/js/jquery.mobile-1.3.2.min.js"></script>
</head>
<body>

    <!--3d相册开始-->
    <div class="hot_3dalbum">

        <div class="container">
            <section id="dgContainer" class="dg_container">
                <div class="dg_wrapper">
                    <a href="#">
                        <img src="/demo/images/1.jpg" alt="image01">
                        <!--<div></div>-->
                    </a>
                    <a href="#">
                        <img src="/demo/images/2.jpg" alt="image02">
                        <!--<div> </div>-->
                    </a>
                    <a href="#">
                        <img src="/demo/images/3.jpg" alt="image03">
                        <!--<div></div>-->
                    </a>                </div>
                <nav>
                    <span class="dg_prev">&nbsp;</span>
                    <span class="dg_next">&nbsp;</span>                </nav>
                <div class="float_layer">
                    <div class="dg_float">
                        <div class="dg_float_con">
                            <p>凤凰古城</p>

                            <p class="hot_price"><span>&yen;</span>5999</p>
                        </div>
                        <strong></strong>                    </div>
                    <div class="dg_float">
                        <div class="dg_float_con">
                            <p>江南小镇</p>

                            <p class="hot_price"><span>&yen;</span>6999</p>
                        </div>
                        <strong></strong>                    </div>
                    <div class="dg_float">
                        <div class="dg_float_con">
                            <p>落日余辉</p>

                            <p class="hot_price"><span>&yen;</span>2999</p>
                        </div>
                        <strong></strong>                    </div>
                </div>
            </section>
        </div>
    </div>
    <!--3d相册结束-->

<script type="text/javascript">

        $('#dgContainer').gallery({
            autoplay: true,
            interval: 3000
        });
</script>


</body>
</html>