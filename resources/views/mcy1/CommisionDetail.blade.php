<!DOCTYPE html>
<!-- saved from url=(0043)//myInfo.htmcommission.do -->
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>佣金明细</title>
    <meta content="app-id=518966501" name="apple-itunes-app">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <link href="./static/comm.css" rel="stylesheet" type="text/css">
    <link href="./static/invite.css" rel="stylesheet" type="text/css">
    <script src="./static/jquery190.js" language="javascript" type="text/javascript"></script>

</head>

<body fnav="1" class="g-acc-bg" style="zoom: 1;">

    <!--触屏版内页头部-->
    <div class="m-block-header" id="div-header" style="display: block;">
        <strong id="m-title">佣金明细</strong>
        <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
        <a href="/index.htm" class="m-index-icon"><i class="m-public-icon"></i></a>
    </div>
    <script>
        if (navigator.userAgent.toLowerCase().match(/MicroMessenger/i) != "micromessenger") {
            document.getElementById('div-header').style.display = 'block';
        }
        document.getElementById('m-title').innerText = document.title;

    </script>


    <input name="hidCurrMoney" type="hidden" id="hidCurrMoney" value="0">
    <input name="hidHasPaypwd" type="hidden" id="hidHasPaypwd" value="0">
    <div class="wrapper">

        <div class="inviteDetails commiss marginB">
            <p class="accumulated-income">佣金余额：<em class="orange">￥0.00</em><cite>（累计收入：￥0.00）</cite></p>

            <div class="commiss-menu">
                <a href="javascript:;" class="z-checked">佣金收入</a>
                <a href="javascript:;" class="">佣金消费</a>
            </div>

            <div class="commission-info">
                <dl>
                    <dt><span>时间</span><span>用户名</span><span>云购金额(￥)</span><span>佣金(￥)</span></dt>
                    <div class="noRecords colorbbb clearfix">
                        <s class="z-y9"></s>最近三个月无记录</div>
                </dl>
                <div class="loading clearfix g-acc-bg" style="display: none;"><b></b>正在加载</div>
            </div>
            <div class="commission-info commission-consumption" style="display: none;">
                <dl>
                    <dt><span>时间</span><span>类型</span><span>描述</span><span>佣金(￥)</span></dt>
                </dl>
                <div class="loading clearfix g-acc-bg" style="display: none;"><b></b>正在加载</div>
            </div>
        </div>

        <div class="pro_foot">
            <ul>
                <li id="btnMention" class="border-orange-Btn"><a href="javascript:;">佣金提现</a></li>
                <li>
                    <a href="/shareAndMakeMoney.htm" class="orangeBtn">赚佣金</a>
                </li>
            </ul>
        </div>

        <div class="weixin-mask" style="display: none;"></div>

        <input id="hidPageType" type="hidden" value="-1">
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
    </div>


    <script language="javascript" type="text/javascript" src="./static/CommissionList.js"></script>
    <script language="javascript" type="text/javascript" src="./static/Bottom.js"></script>
    <script language="javascript" type="text/javascript" src="./static/BottomFun.js"></script>
    <script language="javascript" type="text/javascript" src="./static/cnzzCount.js"></script>
    <script language="javascript" type="text/javascript" src="./static/Comm.js"></script>
    <script language="javascript" type="text/javascript" src="./static/CartComm.js"></script>
    <script language="javascript" type="text/javascript" src="./static/CommissionListFun.js"></script>
    <script language="javascript" type="text/javascript" src="./static/pageDialog.js"></script>
    <div id="div_fastnav" class="fast-nav-wrapper">
        <ul class="fast-nav">
            <li id="li_menu"><a href="javascript:;"><i class="nav-menu"></i></a></li>
            <li id="li_top" style="display:none;"><a href="javascript:;"><i class="nav-top"></i></a></li>
        </ul>
        <div class="sub-nav five" style="display:none;"><a href="//index.htm"><i class="home"></i>云购</a><a href="//newestLottery.htm "><i class="announced"></i>最新揭晓</a>
            <a
                href="//orderShare.htm"><i class="single"></i>晒单</a><a href="//myInfo.htm"><i class="personal"></i>我的云购</a><a href="//shoppingCart.htm"><i class="shopcar"></i>购物车</a></div>
    </div>
</body>

</html>