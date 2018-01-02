<!DOCTYPE html>
<!-- saved from url=(0044)//myInfo.htmPayPwdCheck.do -->
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0">
    <title>支付密码设置</title>
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">

    <link href="./static/jquery.vcCode4Mobile.css" rel="stylesheet">
    <link href="./static/comm.css" rel="stylesheet" type="text/css">
    <link href="./static/security.css" rel="stylesheet" type="text/css">
    <script src="./static/jquery190.js" language="javascript" type="text/javascript"></script>

</head>

<body class="secrityBg" style="zoom: 1;">


    <script type="text/html" id="vcCodeHtmlSectionTmpl">
        <section class="vc-wrapper" style="display: block; height: 226px;">
            <div class="vc-btn-container" id="dragBtnContainer" style="display: block;">
                <div class="vc-slide-text" style="display: block;"><span>请按住滑块，拖动到最右边</span></div>
                <div class="vc-slideBtnLeft" id="dragBtnLeft" style="width: 0;">
                    <span class="canvas-Title" style="display: none;">请点击图中的“<strong id="selectedChar"></strong>”字</span>
                </div>
                <div class="vc-slideBtn ui-draggable ui-draggable-handle" id="dragBtn" style="left: 0; top: 0px; float: left;"><i class="passport-icon ready-status"></i></div>
            </div>
            <div class="canvas-wrapper" style="">
                <div class="canvas-container" id="canvasContainer" style="height: 138px;">
                    <img id="vcCanvas" class="vc-canvas" src="" alt="">
                </div>
                <div class="canvas-foot">
                    <div class="fl">
                        <p class="tips" id="vcCodeTips"></p>
                    </div>
                    <div class="fr btn" style="display: none;" id="vcCodeRefresh">刷新</div>
                </div>
            </div>
            <div class="vc-close-btn"></div>
        </section>
    </script>


    <div class="h5-1yyg-v11">


        <!-- 内页顶部 -->

        <header class="g-header" id="g-header" style="display: none">
            <div class="head-l" style="display: none;">
                <a href="//myInfo.htmSafeSettings.do" class="z-HReturn"><i class="z-arrow"></i></a>
            </div>
            <h2>支付密码设置</h2>
            <div class="head-r"></div>
        </header>

        <!--触屏版内页头部-->
        <div class="m-block-header" id="div-header" style="display: block;">
            <strong id="m-title">支付密码设置</strong>
            <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
            <a href="/index.htm" class="m-index-icon"><i class="m-public-icon"></i></a>
        </div>

        <script>
            if (navigator.userAgent.toLowerCase().match(/MicroMessenger/i) != "micromessenger") {
                document.getElementById('div-header').style.display = 'block';
                document.getElementById('m-title').innerText = document.title;
            } else {
                document.getElementById('g-header').style.display = 'block';
            }
        </script>



        <section>
            <input name="hidIdentity" type="hidden" id="hidIdentity" value="18988938574">
            <input name="hidIdentityType" type="hidden" id="hidIdentityType" value="0">
            <input name="hidIsOpen" type="hidden" id="hidIsOpen" value="0">
            <input name="hidIsUpdate" type="hidden" id="hidIsUpdate">
            <input name="hidForward" type="hidden" id="hidForward">
            <div class="login-protection clearfix">
                <p class="gray6">支付密码<a id="a_switch"><b></b></a></p>
                <div id="div_update" class="set-con clearfix">
                    <ul>
                        <li>

                        </li>
                    </ul>
                </div>
            </div>
            <div id="div_auth"  class="authentication-con clearfix">
                <ul>
                    <li>
                        验证手机号: 18988****74</li>
                    <li class="enter-word">
                        <input id="txtCode" maxlength="6" type="text" placeholder="请输入6位验证码" class="rText"><a id="btnSend"
                            href="javascript:;" class="orgBtn">获取验证码</a></li>
                    <li><a id="btnSubmit" href="javascript:;" class="grayBtn">确认</a></li>
                    <li class="gray9">换了手机号或遗失？请致电客服申诉解除绑定<br> 4000-588-688
                    </li>
                </ul>
            </div>
        </section>

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


    <script language="javascript" type="text/javascript" src="./static/PayPwdCheck.js"></script>
    <script language="javascript" type="text/javascript" src="./static/Bottom.js"></script>
    <script language="javascript" type="text/javascript" src="./static/BottomFun.js"></script>
    <script language="javascript" type="text/javascript" src="./static/cnzzCount.js"></script>
    <script language="javascript" type="text/javascript" src="./static/Comm.js"></script>
    <script language="javascript" type="text/javascript" src="./static/CartComm.js"></script>
    <script language="javascript" type="text/javascript" src="./static/PayPwdCheckFun.js"></script>
    <script language="javascript" type="text/javascript" src="./static/jquery.vcCode4Mobile.js"></script>
    <script language="javascript" type="text/javascript" src="./static/pageDialog.js"></script>
</body>

</html>