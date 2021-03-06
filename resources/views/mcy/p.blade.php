
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>
    {{@$product->product_name}}</title><meta content="app-id=518966501" name="apple-itunes-app" /><meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" /><meta content="yes" name="apple-mobile-web-app-capable" /><meta content="black" name="apple-mobile-web-app-status-bar-style" /><meta content="telephone=no" name="format-detection" />
<link href="/chyyg1/comm.css" rel="stylesheet" type="text/css" />
<link href="/chyyg1/goods.css?v=17061001" rel="stylesheet" type="text/css" />
<script src="/chyyg1/jquery190.js" language="javascript" type="text/javascript"></script>
    <script id="pageJS" data="/chyyg1/goodsInfo.js" language="javascript" type="text/javascript"></script>
</head>
<body>
<div class="h5-1yyg-v1" id="loadingPicBlock">

<!-- 栏目页面顶部 -->
<!-- 内页顶部 -->

    <header class="g-header">
        <div class="head-l">
            <a href="javascript:;" onclick="history.go(-1)" class="z-HReturn"><s></s><b>返回</b></a>
        </div>
                <h2>商品详情</h2>
        <!-- 栏目页面顶部 -->

        <div class="fr head-r">            
            <a id="btnCart" href="http://m.1yygbh.com/index.php/mobile/cart/cartlist" class="z-shop"></a>
        </div>          </header><!-- 内页顶部 -->

    <input name="hidGoodsID" type="hidden" id="hidGoodsID" value=""/>   <!--上期获奖者id-->
    <input name="hidCodeID" type="hidden" id="hidCodeID" value="{{@$product->product_id}}"/>     <!--本期商品id-->
    <section class="goodsCon pCon">
        <!-- 导航 -->
        <div id="divPeriod" class="pNav">
            <div class="loading"><b></b>正在加载</div>
            <ul class="slides">
               <!-- <li class="cur"><a href="javascript:;">第3943期</a><b></b></li> -->
               <!-- <li><a href="{{Request::root()}}/dataserver/4244562" >第3942期</a></li> -->
        </div>

                <!-- 产品图 -->
        <div class="pPic pPicBor">
            <div class="pPic2">
                <div id="sliderBox" class="pImg">
                    <div class="loading"><b></b>正在加载</div>
                    <ul class="slides">
                        @foreach($product->product_loop_imgs as $loopimg)
                        <li><img src="{{@$loopimg}}" /></li>
                        @endforeach
                    </ul>
                </div>
            </div>
                    </div>

        <!-- 商品信息 -->
        <div class="pDetails ">
                <b>(第{{@$product->go_now_qishu}}期){{@$product->product_name}} <span></span></b>
                <p class="price">
                    价值：<em class="arial gray">￥{{@$product->go_price}}</em>
                                    </p>
                            <div class="Progress-bar">
                    <p class="u-progress">
                        <span class="pgbar" style="width:{{@$product->has_go / @$product->go_number * 100}}%;">
                            <span class="pging"></span>
                        </span>
                    </p>
                    <ul class="Pro-bar-li">
                        <li class="P-bar01"><em>{{@$product->go_number - @$yungou_shop->shenyurenshu}}</em>已参与</li>
                        <li class="P-bar02"><em>{{@$product->go_number}}</em>总需人次</li>
                        <li class="P-bar03"><em>{{@$yungou_shop->shenyurenshu}}</em>剩余</li>
                    </ul>
                </div>
                            <div id="btnBuyBox" class="pBtn" codeid="{{@$product->product_id}}">
                <a href="javascript:;" class="fl buyBtn">立即快购</a>
                <a href="javascript:;" class="fl addBtn">加入购物车</a>
                <!-- <a href="javascript:;" class="fl collectBtn">收藏</a> -->
            </div>
                                    </div>
        <!-- 参与记录，商品详细，晒单导航 -->
        <div class="joinAndGet">
            <dl>
                <a href="{{Request::root()}}/buyrecords/{{@$product->product_id}}/3943"><b class="fr z-arrow"></b>所有快购记录</a>
                <a href="{{Request::root()}}/goodsdesc/{{@$product->product_id}}"><b class="fr z-arrow"></b>图文详情<em>（建议WIFI下使用）</em> </a>
                <a href="{{Request::root()}}/goodspost/{{@$product->product_id}}"><b class="fr z-arrow"></b>商品晒单</a>
            </dl>
            <!-- 上期获得者 -->
                    </div>
    </section>

<footer class="footer">
    <span id="btnTop" class="z-top" title="返回顶部"><b class="z-arrow"></b></span>
    <div class="u-ft-nav">
        <ul>
            <li class="f_home"><a href="{{Request::root()}}/init"><i></i>首页</a></li>
            <li class="f_allgoods"><a href="{{Request::root()}}/glist"><i></i>所有商品</a></li>
            <li class="f_announced"><a href="{{Request::root()}}/lottery"><i></i>最新揭晓</a></li>
            <li class="f_car"><a id="btnCart" href="http://m.1yygbh.com/index.php/mobile/cart/cartlist"><i></i>购物车</a></li>
            <li class="f_personal"><a href="http://m.1yygbh.com/index.php/mobile/home"><i></i>我的主面</a></li>
        </ul>
    </div>
    <!--置顶按钮滚动特效-->
    <script src="/chyyg1/topHovertree.js" language="javascript" type="text/javascript"></script>
    <script>
        $(".f_allgoods > a").addClass("hover");
        initTopHoverTree("btnTop",500,1,58);
    </script>
</footer>

<!--开启全站微信分享自定义-->
<script type="text/javascript" src="http://m.1yygbh.com/statics/templates/ffxiang/js/jquery.cookie.js"></script>
<!--end-->
<script language="javascript" type="text/javascript">
  var Path = new Object();
  Path.Skin = "http://m.1yygbh.com/statics/templates/ffxiang";
  Path.Webpath = "http://m.1yygbh.com/index.php";
  Path.imgpath = "http://m.1yygbh.com/statics/uploads";
  Path.remoteImg = "http://yyygbh.oss-cn-shenzhen.aliyuncs.com";

var Base = {
    head: document.getElementsByTagName("head")[0] || document.documentElement,
    Myload: function(B, A) {
        this.done = false;
        B.onload = B.onreadystatechange = function() {
            if (!this.done && (!this.readyState || this.readyState === "loaded" || this.readyState === "complete")) {
                this.done = true;
                A();
                B.onload = B.onreadystatechange = null;
                if (this.head && B.parentNode) {
                    this.head.removeChild(B)
                }
            }
        }
    },
    getScript: function(A, C) {
        var B = function() {};
        if (C != undefined) {
            B = C
        }
        var D = document.createElement("script");
        D.setAttribute("language", "javascript");
        D.setAttribute("type", "text/javascript");
        D.setAttribute("src", A);
        this.head.appendChild(D);
        this.Myload(D, B)
    },
    getStyle: function(A, B) {
        var B = function() {};
        if (callBack != undefined) {
            B = callBack
        }
        var C = document.createElement("link");
        C.setAttribute("type", "text/css");
        C.setAttribute("rel", "stylesheet");
        C.setAttribute("href", A);
        this.head.appendChild(C);
        this.Myload(C, B)
    }
}
function GetVerNum() {
    var D = new Date();
    return D.getFullYear().toString().substring(2, 4) + '.' + (D.getMonth() + 1) + '.' + D.getDate() + '.' + D.getHours() + '.' + (D.getMinutes() < 10 ? '0': D.getMinutes().toString().substring(0, 1))
}
Base.getScript('/chyyg1/Bottom.js');


</script>

<script>
$(function(){
  $(".blue").click(function(){
     window.location.href="{{Request::root()}}/userindex/" + $("#prevPeriod").attr("uweb");
  });

    // 揭晓倒计时
    var divLotteryTime = $('#divLotteryTime');
    if ( divLotteryTime.size() > 0 ) {
        var id = divLotteryTime.attr('data-id');
        var minute = divLotteryTime.find('b.minute');
        var second = divLotteryTime.find('b.second');
        var millisecond = divLotteryTime.find('b.millisecond');
        var tips = minute.parent().prev();
        var times = (new Date().getTime()) + 1000 * divLotteryTime.attr('data-endtime');
        var timer = setInterval(function(){
            var time = times - (new Date().getTime());
            if ( time < 1 ) {
                clearInterval(timer);
                tips.css('line-height', '35px').css('color','#dc332d').html('正在玩命揭晓中……');
                minute.parent().remove();
                second.parent().remove();
                millisecond.parent().remove();

                var checker = setInterval(function () {
                    $.getJSON(Gobal.Webpath+"/api/getshop/lottery_huode_shop",{'oid':id},function(info){
                        if ( !info.error ) {
                            clearInterval(checker);
                            tips.html('揭晓成功！三秒后自动刷新...');
                            setTimeout(function(){
                                location.reload();
                            },3000);
                        }
                    });
                }, 3000);
                return;
            }

            i =  parseInt((time/1000)/60);
            s =  parseInt((time/1000)%60);
            ms =  String(Math.floor(time%1000));
            ms = parseInt(ms.substr(0,2));
            if(i<10)i='0'+i;
            if(s<10)s='0'+s;
            if(ms<10)ms='0'+ms;
            minute.html(i);
            second.html(s);
            millisecond.html(ms);
        }, 41);
    }

    var collectBtn=$(".collectBtn");
    collectBtn.click(function(){
        var codeid=$(this).parent().attr("codeid");
        addCollect(codeid);
    })

    function addCollect(codeid)
    {
        $.getJSON("{{Request::root()}}/addcollect",{codeid:codeid},function(json){
            $.PageDialog.ok(json.tip);
        })
    }

})

</script>
</div>
</body>
</html>
