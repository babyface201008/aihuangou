<!DOCTYPE html>
<!-- saved from url=(0039)http://weixin.1yyg.com/v40/goodslist.do -->
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>商品列表</title>

    <meta content="app-id=518966501" name="apple-itunes-app">
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">

    <link href="./static/comm.css" rel="stylesheet" type="text/css">
    <link href="./static/goods.css" rel="stylesheet" type="text/css">
    <script src="./static/jquery190.js" language="javascript" type="text/javascript"></script>

</head>

<body class="g-acc-bg m-site-box" fnav="0" style="zoom: 1;">

    <!--触屏版内页头部-->
    <div class="m-block-header" id="div-header" style="display: block;">
        <strong id="m-title">商品列表</strong>
        <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
        <a href="http://weixin.1yyg.com/" class="m-index-icon"><i class="m-public-icon"></i></a>
    </div>
    <script>
        if (navigator.userAgent.toLowerCase().match(/MicroMessenger/i) != "micromessenger") {
            document.getElementById('div-header').style.display = 'block';
        }
        document.getElementById('m-title').innerText = document.title;
    </script>

    <div>
        <input name="hdSortID" type="hidden" id="hdSortID" value="0">
        <!--商品分类-->
        <input name="hdOrderFlag" type="hidden" id="hdOrderFlag" value="10">
        <!--商品排序-->
        <input name="hdBrandID" type="hidden" id="hdBrandID" value="0">
        <!--品牌ID-->
        <input name="hdNvgtID" type="hidden" id="hdNvgtID">
        <!--品牌ID-->
        <input name="hdIsPreview" type="hidden" id="hdIsPreview">
        <!--是否为预览-->

        <div class="pro-s-box thin-bor-bottom" id="divSearch">
            <div class="box">
                <div class="border">
                    <div class="border-inner"></div>
                </div>
                <div class="input-box">
                    <i class="s-icon"></i>
                    <input type="text" placeholder="输入“汽车”试试" id="">
                    <i class="c-icon" id="btnClearInput" style="display: none"></i>
                </div>
            </div>
            <a href="javascript:;" class="s-btn" id="">搜索</a>
        </div>

        <!--搜索时显示的模块-->
        <div class="search-info" style="display: none;">
            <div class="hot">
                <p class="title">热门搜索</p>
                <ul id="" class="hot-list clearfix">
                    <li wd="iPhone"><a class="items">iPhone</a></li>
                    <li wd="三星"><a class="items">三星</a></li>
                    <li wd="小米"><a class="items">小米</a></li>
                    <li wd="黄金"><a class="items">黄金</a></li>
                    <li wd="汽车"><a class="items">汽车</a></li>
                    <li wd="电脑"><a class="items">电脑</a></li>
                </ul>
            </div>
            <div class="history" style="">
                <p class="title">历史记录</p>
                <div class="his-inner" id="">
                    <ul class="his-list thin-bor-top">
                        <li wd="新鲜水果" class="thin-bor-bottom"><a class="items">新鲜水果</a></li>
                        <li wd="黄金" class="thin-bor-bottom"><a class="items">黄金</a></li>
                        <li wd="三星" class="thin-bor-bottom"><a class="items">三星</a></li>
                    </ul>
                    <div class="cle-cord thin-bor-bottom" id="btnClear">清空历史记录</div>
                </div>
            </div>
        </div>

        <div class="all-list-wrapper">

            <div class="menu-list-wrapper" id="divSortList">
                <ul id="sortListUl" class="list">
                    <li sortid="0" class="current"><span class="items">全部商品</span></li>
                    <li sortid="100" reletype="1" linkaddr=""><span class="items">手机数码</span></li>
                    <li sortid="105" reletype="1" linkaddr=""><span class="items">电脑办公</span></li>
                    <li sortid="109" reletype="1" linkaddr=""><span class="items">家用电器</span></li>
                    <li sortid="114" reletype="1" linkaddr=""><span class="items">钟表首饰</span></li>
                    <li sortid="118" reletype="1" linkaddr=""><span class="items">食品饮料</span></li>
                    <li sortid="123" reletype="1" linkaddr=""><span class="items">化妆个护</span></li>
                    <li sortid="124" reletype="1" linkaddr=""><span class="items">运动户外</span></li>
                    <li sortid="125" reletype="1" linkaddr=""><span class="items">家居家纺</span></li>
                    <li sortid="126" reletype="1" linkaddr=""><span class="items">礼品箱包</span></li>
                    <li sortid="127" reletype="1" linkaddr=""><span class="items">母婴</span></li>
                    <li sortid="128" reletype="1" linkaddr=""><span class="items">汽车</span></li>
                    <li sortid="130" reletype="1" linkaddr=""><span class="items">其他商品</span></li>
                    <li sortid="400"><span class="items">限购专区</span></li>
                </ul>
            </div>

            <div class="good-list-wrapper">
                <div class="good-menu thin-bor-bottom">
                    <ul class="good-menu-list" id="ulOrderBy">
                        <li orderflag="10" class=""><a href="javascript:;">即将揭晓</a></li>
                        <li orderflag="20" class=""><a href="javascript:;">人气</a></li>
                        <li orderflag="50" class=""><a href="javascript:;">最新</a></li>
                        <li orderflag="31" class="current"><a href="javascript:;">价值</a><span class="i-wrap"><i class="up"></i><i class="down sort"></i></span></li>
                        <!--价值(由高到低30,由低到高31)-->
                    </ul>
                </div>
                <div class="good-list-inner">
                    <div class="good-list-box" id="loadingPicBlock">
                        <div class="goodList">
                            <ul >
                                <li id="23967"> <span class="gList_l fl">   
                                    <a codeid="12045076"  href="/productDetailOpen.htm" class="" canbuy="404284">    
                                    <img src="./static/20170324160308155.jpg">  
                                     </a>  </span>
                                    <div class="gList_r">
                                        <h3 class="gray6">(第52云)2016款 进口宝马（BMW）X3 28i 中东版 五门轿车</h3> <em class="gray9">价值：￥578888.00</em>
                                        <div class="gRate">
                                            <div class="Progress-bar">
                                                <p class="u-progress"><span style="width: 30.16196569975539%;" class="pgbar"><span class="pging"></span></span>
                                                </p>
                                                <ul class="Pro-bar-li">
                                                    <li class="P-bar01"><em>174604</em>已参与</li>
                                                    <li class="P-bar02"><em>578888</em>总需人次</li>
                                                    <li class="P-bar03"><em>404284</em>剩余</li>
                                                </ul>
                                            </div>
                                            <a>
                                                <s></s>
                                            </a>
                                           
                                        </div>
                                    </div>
                                </li>
                
                    </ul>
                </div>

                <!--<div class="load_more" style="display: none;"><a href="javascript:;">向上滑动加载更多</a></div>
                        <div class="loading"></div>-->
                <div id="divLoading" class="loading clearfix" style="display: none;"><b></b>正在加载</div>
            </div>
        </div>
    </div>
    </div>


    <input id="hidPageType" type="hidden" value="-2">
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
    <script language="javascript" type="text/javascript" src="./static/GoodsListAll.js"></script>
    <script language="javascript" type="text/javascript" src="./static/Bottom.js"></script>
    <script language="javascript" type="text/javascript" src="./static/BottomFun.js"></script>
    <script language="javascript" type="text/javascript" src="./static/cnzzCount.js"></script>
    <script language="javascript" type="text/javascript" src="./static/Comm.js"></script>
    <script language="javascript" type="text/javascript" src="./static/CartComm.js"></script>
    <script language="javascript" type="text/javascript" src="./static/GoodsListAllFun.js"></script>
    <script language="javascript" type="text/javascript" src="./static/pageDialog.js"></script>
    <script language="javascript" type="text/javascript" src="./static/fastclick.js"></script>
</body>

</html>