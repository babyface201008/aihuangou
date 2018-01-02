<!DOCTYPE html>
<!-- saved from url=(0046)http://weixin.1yyg.com/v40/MorePeriod-23559.do -->
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>获得者</title>
    <meta content="app-id=518966501" name="apple-itunes-app">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <link href="./static/comm.css" rel="stylesheet" type="text/css">
    <link href="./static/goods.css" rel="stylesheet" type="text/css">
    <script src="./static/jquery190.js" language="javascript" type="text/javascript"></script>

</head>

<body class="g-acc-bg" id="loadingPicBlock" fnav="1" style="zoom: 1;">

    <!--触屏版内页头部-->
    <div class="m-block-header" id="div-header" style="display: block;">
        <strong id="m-title">获得者</strong>
        <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
        <a href="/index.htm" class="m-index-icon"><i class="m-public-icon"></i></a>
    </div>
    <script>
        if (navigator.userAgent.toLowerCase().match(/MicroMessenger/i) != "micromessenger") {
            document.getElementById('div-header').style.display = 'block';
        }
        document.getElementById('m-title').innerText = document.title;

    </script>

    <input name="hidGoodsID" type="hidden" id="hidGoodsID" value="23559">
    <div class="g-winner-con clearfix">
        <div class="m-search gray9">
            <span class="fl">直达第</span>
            <span class="fr"><a id="btnGo" href="javascript:;">云<i class="z-set"></i></a></span>
            <div class="f-search-text">
                <input id="txtPeriod" type="text" value="请输入数字" maxlength="8">
            </div>
        </div>
        <div class="m-win-list clearfix">
            <ul id="winList">
                <li codeid="12492905"><cite>第485云</cite>
                    <dl class="gray9">
                        <dt><img src="./static/20170601224351423.jpg"></dt>
                        <dd class="win-name"><a href="/searchResult.htm" class="blue">王国田45岁广西农村人</a></dd>
                        <dd class="z-font-size">幸运码：<em class="orange">10000553</em></dd>
                        <dd class="z-font-size"> 参与人次：<em class="orange">3000</em></dd>
                        <dd class="colorbbb">06月08日 20:58</dd>
                    </dl>
                </li>
                <li codeid="12492904"><cite>第484云</cite>
                    <dl class="gray9">
                        <dt><img src="./static/20170527103838658.jpg"></dt>
                        <dd class="win-name"><a href="/searchResult.htm" class="blue">就是中中中啊</a></dd>
                        <dd class="z-font-size">幸运码：<em class="orange">10005083</em></dd>
                        <dd class="z-font-size"> 参与人次：<em class="orange">8265</em></dd>
                        <dd class="colorbbb">06月08日 16:30</dd>
                    </dl>
                </li>
                <li codeid="12492903"><cite>第483云</cite>
                    <dl class="gray9">
                        <dt><img src="./static/20150917020747247.jpg"></dt>
                        <dd class="win-name"><a href="/searchResult.htm" class="blue">一次就好g</a></dd>
                        <dd class="z-font-size">幸运码：<em class="orange">10008446</em></dd>
                        <dd class="z-font-size"> 参与人次：<em class="orange">10</em></dd>
                        <dd class="colorbbb">06月08日 13:06</dd>
                    </dl>
                </li>
                <li codeid="12492902"><cite>第482云</cite>
                    <dl class="gray9">
                        <dt><img src="./static/20170518201701663.jpg"></dt>
                        <dd class="win-name"><a href="/searchResult.htm" class="blue">爷爷奶奶中大奖</a></dd>
                        <dd class="z-font-size">幸运码：<em class="orange">10003865</em></dd>
                        <dd class="z-font-size"> 参与人次：<em class="orange">228</em></dd>
                        <dd class="colorbbb">06月08日 12:42</dd>
                    </dl>
                </li>


 
            </ul>
        </div>
        <div id="divLoading" class="loading clearfix g-acc-bg"><b></b>正在加载</div>
        <div id="div_footer" class="pro_foot conduct-ing" style="display: none;"></div>
    </div>

    <input id="hidPageType" type="hidden" value="-1">
    <input id="hidIsHttps" type="hidden" value="1">
    <input id="hidSiteVer" type="hidden" value="v40">
    <input id="hidWxDomain" type="hidden" value="https://weixin.1yyg.com">
    <input id="hidOpenID" type="hidden" value="">
        <div class="footer clearfix " style="bottom: 0px; ">
            <ul>
                <li class="f_home "><a href="/index.htm " class="hover "><i></i>云购</a></li>
                <li class="f_announced "><a href="/newestLottery.htm "><i></i>最新揭晓</a></li>
                <li class="f_single "><a href="/orderShare.htm "><i></i>晒单</a></li>
                <li class="f_car "><a id="btnCart " href="/shoppingCart.htm "><i><b num="22 ">22</b></i>购物车</a></li>
                <li class="f_personal "><a href="/myInfo.htm"><i></i>我的云购</a></li>
            </ul>
        </div>
    <script type="text/javascript">
        var Base = {
            head: document.getElementsByTagName("head")[0] || document.documentElement,
            Myload: function (B, A) {
                this.done = false;
                B.onload = B.onreadystatechange = function () {
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
            getScript: function (A, C) {
                var B = function () { };
                if (C != undefined) {
                    B = C;
                }
                var D = document.createElement("script");
                D.setAttribute("language", "javascript");
                D.setAttribute("type", "text/javascript");
                D.setAttribute("src", A);
                this.head.appendChild(D);
                this.Myload(D, B);
            },
            getStyle: function (A, C) {
                var B = function () { };
                if (C != undefined) {
                    B = C;
                }
                var C = document.createElement("link");
                C.setAttribute("type", "text/css");
                C.setAttribute("rel", "stylesheet");
                C.setAttribute("href", A);
                this.head.appendChild(C);
                this.Myload(C, B);
            }
        }
        function GetVerNum() {
            var D = new Date();
            return D.getFullYear().toString().substring(2, 4) + '.' + (D.getMonth() + 1) + '.' + D.getDate() + '.' + D.getHours() + '.' + (D.getMinutes() < 10 ? '0' : D.getMinutes().toString().substring(0, 1));
        }
        $(document).ready(function () {
            var _SkinDomain = $("#hidIsHttps").val() == "1" ? "https://skin.1yyg.net" : "https://skin.1yyg.net";
            Base.getScript(_SkinDomain + '/v40/weixin/JS/Bottom.js?v=' + GetVerNum(), function () {
                var _pagetype = $("#hidPageType").val();
                var _footer = $("div.footer");
                var _cartpay = $("#mycartpay");
                var _cartlist = 0;//$("li", "#cartBody");
                var _saysome = $("div.saysome");
                var _curpage = window.location.href.toLowerCase();

                var _ishide = false;
                if (_cartpay.length > 0 && _cartlist.length > 0) {
                    _footer = _cartpay;
                    _pagetype = "1";
                    _ishide = true;
                }
                else if (_saysome.length > 0) {
                    _footer = _saysome;
                    _pagetype = "1";
                }
                //弹出输入法是否隐藏底部导航
                if (_curpage.indexOf('/member/recharge.do') > 0 || _curpage.indexOf('/member/goodsbuydetail-') > 0) {
                    _ishide = true;
                }

                var _hh = parseInt($(window).height());
                var _ww = $(window).width();
                if (_pagetype != "-1" && _footer.length > 0) {
                    var SetFooterPos = function () {
                        var j = 0;
                        var _setObj;
                        _setObj = setInterval(function () {
                            var _hh1 = parseInt($(window).height());
                            var _hh2 = _hh - _hh1;

                            if (_hh1 > 200) {
                                if (_hh2 > 0) {
                                    if (parseInt($(window).width()) != parseInt(_ww)) {
                                        _footer.css("bottom", 0).show();
                                    }
                                }
                                else {
                                    _footer.css("bottom", 0).show();
                                }
                                j++;
                                //$("#mycarttest").html(_hh1 + "||" + _hh2 + "||" + $(window).width());
                                if (j == 3) {
                                    clearInterval(_setObj);
                                }
                            }
                        }, 100);
                    }

                    SetFooterPos();

                    window.onresize = function () {
                        if (_ishide) {
                            _footer.hide();
                        }
                        SetFooterPos();
                    };
                }
            });
        });

    </script>
    <div style="display: none;">
        <script type="text/javascript" language="JavaScript" src="./static/stat.php"></script>
        <script src="./static/core.php" charset="utf-8" type="text/javascript"></script><a href="http://www.cnzz.com/stat/website.php?web_id=3362429" target="_blank" title="站长统计">站长统计</a>
    </div>


    <div style="position: static; width: 0px; height: 0px; border: none; padding: 0px; margin: 0px;">
        <div id="trans-tooltip">
            <div id="tip-left-top" style="background: url(&quot;chrome-extension://ikkbfngojljohpekonpldkamedehakni/imgs/map/tip-left-top.png&quot;);"></div>
            <div id="tip-top" style="background: url(&quot;chrome-extension://ikkbfngojljohpekonpldkamedehakni/imgs/map/tip-top.png&quot;) repeat-x;"></div>
            <div id="tip-right-top" style="background: url(&quot;chrome-extension://ikkbfngojljohpekonpldkamedehakni/imgs/map/tip-right-top.png&quot;);"></div>
            <div id="tip-right" style="background: url(&quot;chrome-extension://ikkbfngojljohpekonpldkamedehakni/imgs/map/tip-right.png&quot;) repeat-y;"></div>
            <div id="tip-right-bottom" style="background: url(&quot;chrome-extension://ikkbfngojljohpekonpldkamedehakni/imgs/map/tip-right-bottom.png&quot;);"></div>
            <div id="tip-bottom" style="background: url(&quot;chrome-extension://ikkbfngojljohpekonpldkamedehakni/imgs/map/tip-bottom.png&quot;) repeat-x;"></div>
            <div id="tip-left-bottom" style="background: url(&quot;chrome-extension://ikkbfngojljohpekonpldkamedehakni/imgs/map/tip-left-bottom.png&quot;);"></div>
            <div id="tip-left" style="background: url(&quot;chrome-extension://ikkbfngojljohpekonpldkamedehakni/imgs/map/tip-left.png&quot;);"></div>
            <div id="trans-content"></div>
        </div>
        <div id="tip-arrow-bottom" style="background: url(&quot;chrome-extension://ikkbfngojljohpekonpldkamedehakni/imgs/map/tip-arrow-bottom.png&quot;);"></div>
        <div id="tip-arrow-top" style="background: url(&quot;chrome-extension://ikkbfngojljohpekonpldkamedehakni/imgs/map/tip-arrow-top.png&quot;);"></div>
    </div>
    <div id="div_fastnav" class="fast-nav-wrapper">
        <ul class="fast-nav">
            <li id="li_menu"><a href="javascript:;"><i class="nav-menu"></i></a></li>
            <li id="li_top" style="display:none;"><a href="javascript:;"><i class="nav-top"></i></a></li>
        </ul>
        <div class="sub-nav five" style="display:none;"><a href="http://weixin.1yyg.com/v40/index.do"><i class="home"></i>云购</a><a href="http://weixin.1yyg.com/v40/lottery/"><i class="announced"></i>最新揭晓</a>
            <a
                href="http://weixin.1yyg.com/v40/post/index.do"><i class="single"></i>晒单</a><a href="http://weixin.1yyg.com/myInfo.htm"><i class="personal"></i>我的云购</a><a href="http://weixin.1yyg.com/v40/mycart/"><i class="shopcar"></i>购物车</a></div>
    </div>
    <script language="javascript" type="text/javascript" src="./static/MorePeriod.js"></script>
    <script language="javascript" type="text/javascript" src="./static/Bottom.js"></script>
    <script language="javascript" type="text/javascript" src="./static/BottomFun.js"></script>
    <script language="javascript" type="text/javascript" src="./static/cnzzCount.js"></script>
    <script language="javascript" type="text/javascript" src="./static/Comm.js"></script>
    <script language="javascript" type="text/javascript" src="./static/CartComm.js"></script>
    <script language="javascript" type="text/javascript" src="./static/MorePeriodFun.js"></script>
    <script language="javascript" type="text/javascript" src="./static/pageDialog.js"></script>
</body>

</html>