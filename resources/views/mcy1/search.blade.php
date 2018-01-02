<!DOCTYPE html>
<!-- saved from url=(0057)/v41/GoodsSearch.do?q=%E6%B1%BD%E8%BD%A6 -->
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <title>搜索</title>

    <link href="./static/comm.css" rel="stylesheet" type="text/css">
    <link href="./static/goods.css" rel="stylesheet" type="text/css">
    <script src="./static/jquery190.js" language="javascript" type="text/javascript"></script>

</head>

<body class="g-acc-bg m-site-box" fnav="2" style="zoom: 1;">
    <input name="hidSearchKey" type="hidden" id="hidSearchKey" value="汽车">

    <!--触屏版内页头部-->
    <div class="m-block-header" id="div-header" style="display: block;">
        <strong id="m-title">搜索</strong>
        <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
        <a href="/index.htm" class="m-index-icon"><i class="m-public-icon"></i></a>
    </div>
    <script>
        if (navigator.userAgent.toLowerCase().match(/MicroMessenger/i) != "micromessenger") {
            document.getElementById('div-header').style.display = 'block';
        }
        document.getElementById('m-title').innerText = document.title;

    </script>

    <div class="pro-s-box thin-bor-bottom search-box pos-fix-0" id="divSearch">
        <div class="box">
            <div class="border">
                <div class="border-inner"></div>
            </div>
            <div class="input-box">
                <i class="s-icon"></i>
                <input type="text" placeholder="输入“汽车”试试" value="" id="txtSearch" maxlength="10">
                <i class="c-icon" id="btnClearInput" style=""></i>
            </div>
        </div>
        <a href="javascript:;" class="s-btn" id="btnSearch">搜索</a>
    </div>
    <!--搜索时显示的模块-->
    <div class="search-info" style="display: none;">
        <div class="hot">
            <p class="title">热门搜索</p>
            <ul id="ulSearchHot" class="hot-list clearfix">
                <li wd="iPhone"><a class="items">iPhone</a></li>
                <li wd="三星"><a class="items">三星</a></li>
                <li wd="小米"><a class="items">小米</a></li>
                <li wd="黄金"><a class="items">黄金</a></li>
                <li wd="汽车"><a class="items">汽车</a></li>
                <li wd="电脑"><a class="items">电脑</a></li>
            </ul>
        </div>
        <div class="history" style="display: none">
            <p class="title">历史记录</p>
            <div class="his-inner" id="divSearchHotHistory"></div>
        </div>
    </div>

    <!--搜索结果模块-->
    <div class="good-result pad-top-86" id="loadingPicBlock">
        <!--搜索有结果时-->
        <div class="goodList" style="display: block;">
            <div class="result-num thin-bor-bottom pos-fix-44" id="divResultTip" style="">
                <p>
                    共搜索到&nbsp;
                    <span class="orange" id="spCount">72</span> &nbsp;个相关商品
                </p>
                <div class="add-car-all" id="multipleAddToCartBtn" style="">一键加入购物车</div>
            </div>

            <ul id="ulGoodsList">
                <li id="24360" class=""> <span class="gList_l fl">        
                    <a href="./productDetailOpen.htm"><img src="./static/20170609175321309.jpg"></a>    </span>
                    <div class="gList_r">
                        <h3 class="gray6">(第21云)Mama&amp;Bebe 小闪电IFIX 汽车儿童安全座椅 3-12周岁</h3> <em class="gray9">价值：￥299.00</em>
                        <div class="gRate">
                            <div class="Progress-bar">
                                <p class="u-progress"><span style="width: 72.24080267558529%;" class="pgbar"><span class="pging"></span></span>
                                </p>
                                <ul class="Pro-bar-li">
                                    <li class="P-bar01"><em>216</em>已参与</li>
                                    <li class="P-bar02"><em>299</em>总需人次</li>
                                    <li class="P-bar03"><em>83</em>剩余</li>
                                </ul>
                            </div>
                            <a codeid="12589155" class="">
                                <s></s>
                            </a>
                        </div>
                    </div>
                </li>
                <li id="24419" class=""> <span class="gList_l fl">       
                     <a href="./productDetailOpen.htm"> <img src="./static/20170609190147261.jpg"></a>    </span>
                    <div class="gList_r">
                        <h3 class="gray6">(第4云)进口大众 Tiguan 2016款 2.0T 自动两驱型汽车 北美版</h3> <em class="gray9">价值：￥312888.00</em>
                        <div class="gRate">
                            <div class="Progress-bar">
                                <p class="u-progress"><span style="width: 53.234703791772134%;" class="pgbar"><span class="pging"></span></span>
                                </p>
                                <ul class="Pro-bar-li">
                                    <li class="P-bar01"><em>166565</em>已参与</li>
                                    <li class="P-bar02"><em>312888</em>总需人次</li>
                                    <li class="P-bar03"><em>146323</em>剩余</li>
                                </ul>
                            </div>
                            <a codeid="12590018" class="">
                                <s></s>
                            </a>
                        </div>
                    </div>
                </li>
               
              
            </ul>
            <div id="divLoading" class="loading clearfix" style="display: none;"><b></b>正在搜索</div>
        </div>

        <!--搜索无结果时-->
        <div class="null-search-wrapper" id="divNoneData" style="display: none">
            <div class="null-search-inner">
                <i class="null-search-icon"></i>
                <p class="gray9">抱歉，没有您想要的商品！</p>
            </div>

            <div class="hot-recom">
                <div class="title thin-bor-top gray6">人气推荐</div>
                <div class="goods-wrap thin-bor-top">
                    <ul class="goods-list clearfix" id="ulRec"></ul>
                </div>
            </div>
        </div>

    </div>


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
        </ul>
        <div class="sub-nav five" style="display:none;"><a href="/index.htm"><i class="home"></i>云购</a><a href="/newestLottery.htm "><i class="announced"></i>最新揭晓</a>
            <a
                href="/orderShare.htm"><i class="single"></i>晒单</a><a href="/myInfo.htm"><i class="personal"></i>我的云购</a><a href="/shoppingCart.htm"><i class="shopcar"></i>购物车</a></div>
    </div>
    <script language="javascript" type="text/javascript" src="./static/GoodsSearch.js"></script>
    <script language="javascript" type="text/javascript" src="./static/Bottom.js"></script>
    <script language="javascript" type="text/javascript" src="./static/BottomFun.js"></script>
    <script language="javascript" type="text/javascript" src="./static/cnzzCount.js"></script>
    <script language="javascript" type="text/javascript" src="./static/Comm.js"></script>
    <script language="javascript" type="text/javascript" src="./static/CartComm.js"></script>
    <script language="javascript" type="text/javascript" src="./static/GoodsSearchFun.js"></script>
    <script language="javascript" type="text/javascript" src="./static/pageDialog.js"></script>
    <script language="javascript" type="text/javascript" src="./static/fastclick.js"></script>
    <script language="javascript" type="text/javascript" src="./static/CartComm.js"></script>
</body>

</html>