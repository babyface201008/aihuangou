<!DOCTYPE html>
<!-- saved from url=(0043)//myInfo.htmmemberinfo.do -->
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <title>个人资料</title>
    <meta content="app-id=518966501" name="apple-itunes-app">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <link href="./static/comm.css" rel="stylesheet" type="text/css">
    <link href="./static/member.css" rel="stylesheet" type="text/css">
    <script src="./static/jquery190.js" language="javascript" type="text/javascript"></script>

</head>

<body fnav="1" class="g-acc-bg" style="zoom: 1;">

    <!--触屏版内页头部-->
    <div class="m-block-header" id="div-header" style="display: block;">
        <strong id="m-title">个人资料</strong>
        <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
        <a href="/index.htm" class="m-index-icon"><i class="m-public-icon"></i></a>
    </div>
    <script>
        if (navigator.userAgent.toLowerCase().match(/MicroMessenger/i) != "micromessenger") {
            document.getElementById('div-header').style.display = 'block';
        }
        document.getElementById('m-title').innerText = document.title;

    </script>

    <input name="hidBirthday" type="hidden" id="hidBirthday">
    <input name="hidUpdateTime" type="hidden" id="hidUpdateTime">
    <input name="hidSex" type="hidden" id="hidSex" value="0">
    <div class="sub_nav">
        <div class="link-wrapper">
            <a href="/editName.htm"><em>昵称</em><i></i><span class="fr">USER.1016069267</span></a>
        </div>
        <div class="link-wrapper">
            <a href="javascript:;"><em>性别</em><i></i><span class="fr">保密</span><select id="selSex" class="sex"><option value="2">男</option><option value="1">女</option><option value="3">保密</option></select></a>
            <a href="javascript:;"><em>生日</em><strong>一年之内只能修改一次</strong><i></i><span class="fr"></span><input id="dateBirth" type="date" value="" min="1952-01-01" max="2012-06-16" class="date"></a>
            <a href="/editPhone.htm"><em>电话</em><strong>备用联系信息不作公开</strong><i></i><span class="fr"></span></a>
        </div>
        <div class="link-wrapper">
            <a href="/editAddress.htm"><em>现居地</em><i></i><span class="fr"></span></a>
            <a href="/editAddress.htm"><em>家乡</em><i></i><span class="fr"></span></a>
        </div>
        <div class="link-wrapper">
            <a href="/editSignature.htm" class="underwrite"><em>个性签名</em><i></i><span></span></a>
        </div>
    </div>

    <input id="hidPageType" type="hidden" value="-1">
    <input id="hidIsHttps" type="hidden" value="1">
    <input id="hidSiteVer" type="hidden" value="v41">
    <input id="hidWxDomain" type="hidden" value="/">
    <input id="hidOpenID" type="hidden" value="">
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
            var _SkinDomain = $("#hidIsHttps").val() == "1" ? "https://{{Requets::root()}}" : "https://{{Requets::root()}}";
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
    <script language="javascript" type="text/javascript" src="./static/MemberInfo.js"></script>
</body>

</html>