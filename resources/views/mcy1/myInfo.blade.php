<!DOCTYPE html>
<!-- saved from url=(0037)/myInfo.htmindex.do -->
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0">
    <title>我的云购</title>
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">

    <link href="./static/comm.css" rel="stylesheet" type="text/css">
    <link href="./static/member.css" rel="stylesheet" type="text/css">
    <script src="./static/jquery190.js" language="javascript" type="text/javascript"></script>

</head>

<body class="g-acc-bg" style="zoom: 1;">
    <!--首页头部-->
    <div class="m-block-header" style=""><a href="/" class="m-public-icon m-1yyg-icon"></a></div>
    <!--首页头部 end-->
    <div class="m_myInfo">
        <dl>
            <dt class="gray6 person-info-btn" onclick="location.href='/settings.htm'">
            <a href="./personInfo.htm"><img src="./static/00000000000000000.jpg"></a>
                <p>USER.1016069267<em class="gray9">（ID:1016069267）</em><cite class="gray9"><span class="z-class-icon01"><s></s>云购小将</span></cite></p>
                <i
                    class="m-set"></i>
            </dt>
            <dd class="clearfix"><b class="can-use-points"><a href="/myBlessing.htm"><em class="orange">20</em>可用福分</a></b>
                <b
                    class="can-use-balance"><a href="/accountDetail.htm"><em class="orange"><i>￥</i>0.00</em>可用余额</a></b>
                    <a
                        href="/netBanker.htm" class="orangeBtn go-charge-btn">去充值</a>
            </dd>
        </dl>
    </div>
    <!--获得的商品-->

    <!--导航菜单-->

    <div class="sub_nav marginB person-page-menu">
        <a href="/myShoppingRecord.htm">
            <s class="m_s1"></s>我的云购记录<i></i></a>
        <a href="/myProductList.htm">
            <s class="m_s2"></s>获得的商品<i></i></a>
        <a href="/showOrders.htm">
            <s class="m_s4"></s>我的晒单<i></i></a>
        <a href="/myWallet.htm">
            <s class="m_s11"></s>我的钱包<i></i></a>
        <a href="/helpAndFeedback.htm" class="mt10">
            <s class="m_s7"></s>帮助与反馈<i></i></a>
        <p class="colorbbb">客服热线：4000-588-688 (工作时间9:00-21:00)</p>
    </div>

    <input id="hidPageType" type="hidden" value="4">
    <input id="hidIsHttps" type="hidden" value="1">
    <input id="hidSiteVer" type="hidden" value="v41">
    <input id="hidWxDomain" type="hidden" value="/">
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
            Base.getScript(_SkinDomain + '/v41/weixin/JS/Bottom.js?v=' + GetVerNum(), function () {
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

    <script>
        function goClick(obj, href) {
            $(obj).empty();
            location.href = href;
        }
        if (navigator.userAgent.toLowerCase().match(/MicroMessenger/i) != "micromessenger") {
            $(".m-block-header").show();
        }
    </script>


    <script language="javascript" type="text/javascript" src="./static/Bottom.js"></script>
    <script language="javascript" type="text/javascript" src="./static/BottomFun.js"></script>
    <script language="javascript" type="text/javascript" src="./static/cnzzCount.js"></script>
    <script language="javascript" type="text/javascript" src="./static/Comm.js"></script>
    <script language="javascript" type="text/javascript" src="./static/CartComm.js"></script>
</body>

</html>