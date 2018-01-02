<!DOCTYPE html>
<!-- saved from url=(0048)http://weixin.1yyg.com/v40/GoodsImgDesc-23559.do -->
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta content="app-id=518966501" name="apple-itunes-app">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=yes, maximum-scale=5.0">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <title>
        商品图文详情
    </title>
    <link href="./static/comm.css" rel="stylesheet" type="text/css">
    <link href="./static/goods.css" rel="stylesheet" type="text/css">
    <script src="./static/jquery190.js" language="javascript" type="text/javascript"></script>
    <script type="text/javascript">
        /*
        * 智能机浏览器版本信息:
        *
        */
        var browser = {
            versions: function () {
                var u = navigator.userAgent, app = navigator.appVersion;
                return {//移动终端浏览器版本信息 
                    trident: u.indexOf('Trident') > -1, //IE内核
                    presto: u.indexOf('Presto') > -1, //opera内核
                    webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
                    gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核
                    mobile: !!u.match(/AppleWebKit.*Mobile.*/) || !!u.match(/AppleWebKit/), //是否为移动终端
                    ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
                    android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或者uc浏览器
                    iPhone: u.indexOf('iPhone') > -1 || u.indexOf('Mac') > -1, //是否为iPhone或者QQHD浏览器
                    iPad: u.indexOf('iPad') > -1, //是否iPad
                    webApp: u.indexOf('Safari') == -1 //是否web应该程序，没有头部与底部
                };
            }(),
            language: (navigator.browserLanguage || navigator.language).toLowerCase()
        }
        var _swidth = 0;
        var _dwidth = 0;
        var _gheight = 0;
        var setZoomFun = function (isResize) {
            var _goodsdesc = $("#divGoodsDesc").show();
            var _hwidth = _goodsdesc.width();//$("header.g-header").width();
            if (_hwidth == _swidth) { return; }
            _swidth = _hwidth;//window.screen.width;
            if (_dwidth == 0) {
                _dwidth = $(document).width();
            }
            if (_gheight == 0) {
                _gheight = _goodsdesc.height();
            }
            if (!isResize) {
                _goodsdesc.find("img").each(function () {
                    var E = "src2";
                    var H = $(this).attr(E);
                    $(this).attr("src", H).removeAttr(E).show();

                });
            }
            var _zoom = parseFloat(_swidth / _dwidth);
            if (_zoom >= 1 || _zoom <= 0) {
                return;
            }
            // document.title = _zoom;
            if (browser.versions.ios || browser.versions.iPhone || browser.versions.iPad) {
                _goodsdesc.css("-webkit-transform-origin", "left top");
                _goodsdesc.css("-moz-transform-origin", "left top");
                _goodsdesc.css("-o-transform-origin", "left top");

                _goodsdesc.css("-webkit-transform", "scale(" + _zoom + ")");
                _goodsdesc.css("-moz-transform", "scale(" + _zoom + ")");
                _goodsdesc.css("-o-transform", "scale(" + _zoom + ")");

                _goodsdesc.css("height", _gheight * _zoom + "px");

            } else {
                _goodsdesc.css("zoom", _zoom);
            }
        }

        $(document).ready(function () {
            setZoomFun(false);
        });

        $(window).resize(function () {
            setZoomFun(true);
        });
    </script>

</head>

<body fnav="1" style="zoom: 1;">

    <!--触屏版内页头部-->
    <div class="m-block-header" id="div-header" style="display: block;">
        <strong id="m-title">商品图文详情</strong>
        <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
        <a href="http://weixin.1yyg.com/" class="m-index-icon"><i class="m-public-icon"></i></a>
    </div>
    <script>
        if (navigator.userAgent.toLowerCase().match(/MicroMessenger/i) != "micromessenger") {
            document.getElementById('div-header').style.display = 'block';
        }
        document.getElementById('m-title').innerText = document.title;

    </script>

    <div class="h5-1yyg-v1">
        <div id="divGoodsDesc" class="detailContent z-minheight" style="transform-origin: left top 0px; transform: scale(0.8875); height: 8003.47px;">
            <div>
                <div style="width:800px; margin:0px auto; padding-top:10px;">
                    <div style="width:800px; margin:0px auto; padding:0px; font-family:&#39;微软雅黑&#39;; height:1136px; background:url(http://img.1yyg.net/GoodsInfo/20161101171627303.jpg) no-repeat center; color:#333;">
                        <p style="font-size:32px; line-height:45px; padding:30px 10px 0px 0px; margin:0px; text-align:center;">
                            MacBook Pro</p>
                        <p style="font-size:50px; line-height:65px; padding:20px 0px 0px 20px; margin:0px; text-align:center;">
                            一身才华，一触，即发。</p>
                        <p style="font-size:15px; line-height:28px; padding:720px 80px 0px 80px; margin:0px; text-align:center;">
                            它比以往速度更快、性能更强大，身形却更纤薄、更轻巧。它为你展现的，是迄今最明亮、最多彩的 Mac 笔记本显示屏。新一代 MacBook Pro 是对我们突破性理念的一场出色演绎，而它，也正期待着演绎你的奇思妙想。</p>
                        <div
                            style="font-family:&#39;微软雅黑&#39;; float:left; width:300px; margin:0px; padding:0px;">
                            <p style="font-size:14px; line-height:22px; padding:82px 0px 0px 195px; margin:0px; text-align:center;"><span style="font-size:40px; line-height:45px;">130</span>%</p>
                            <p style="font-size:13px; line-height:22px; padding:0px 0px 0px 195px; margin:0px; text-align:center;">
                                图形处理速度</p>
                            <p style="font-size:13px; line-height:22px; padding:0px 0px 0px 200px; margin:0px; text-align:center;">
                                最高提升 130%</p>
                    </div>
                    <div style="font-family:&#39;微软雅黑&#39;; float:left; width:180px; padding:0px;">
                        <p style="font-size:14px; line-height:22px; padding:130px 0px 0px 25px; margin:0px; text-align:center;">
                            显示屏亮度提升</p>
                        <p style="font-size:14px; line-height:22px; padding:0px 5px 0px 25px; margin:0px; text-align:center;">
                            67%</p>
                    </div>
                    <div style="font-family:&#39;微软雅黑&#39;; float:left; width:150px; padding:0px;">
                        <p style="font-size:14px; line-height:22px; padding:75px 0px 0px 0px; margin:0px; text-align:center;"><span style="font-size:40px; line-height:45px;">17</span>%</p>
                        <p style="font-size:13px; line-height:22px; padding:10px 0px 0px 0px; margin:0px; text-align:center;">
                            机身最多比以往纤薄</p>
                        <p style="font-size:13px; line-height:22px; padding:0px 0px 0px 0px; margin:0px; text-align:center;">
                            17%</p>
                    </div>
                </div>
                <div style="width:800px; margin:0px auto; padding-top:10px; font-family:&#39;微软雅黑&#39;; height:550px; background:url(http://img.1yyg.net/GoodsInfo/20161101171851518.jpg) no-repeat center; color:#333; border-bottom:1px solid #C1C1C1;">
                    <div style="font-family:&#39;微软雅黑&#39;; float:left; width:400px; margin:0px; padding:0px;">
                        <p style="font-size:13px; line-height:22px; padding:440px 0px 0px 30px; margin:0px; text-align:center;">
                            13 英寸机型</p>
                        <p style="font-size:14px; line-height:22px; padding:10px 0px 0px 30px; margin:0px; text-align:center;"><span style="font-size:35px; line-height:45px;">1.37</span>千克<span style="font-size:35px; line-height:45px;">14.9</span>毫米</p>
                    </div>
                    <div style="font-family:&#39;微软雅黑&#39;; float:left; width:400px; margin:0px; padding:0px;">
                        <p style="font-size:13px; line-height:22px; padding:440px 20px 0px 10px; margin:0px; text-align:center;">
                            15 英寸机型</p>
                        <p style="font-size:14px; line-height:22px; padding:10px 20px 0px 10px; margin:0px; text-align:center;"><span style="font-size:35px; line-height:45px;">1.83</span>千克<span style="font-size:35px; line-height:45px;">15.5 </span>毫米</p>
                    </div>
                </div>
                <div style="width:800px; margin:0px auto; padding:0px; font-family:&#39;微软雅黑&#39;; height:960px; background:url(http://img.1yyg.net/GoodsInfo/20161101171912432.jpg) no-repeat center; color:#333; border-bottom:1px solid #C1C1C1;">
                    <p style="font-size:25px; line-height:35px; padding:60px 0px 0px 0px; margin:0px; text-align:center;">
                        Multi-Touch Bar和Touch ID</p>
                    <p style="font-size:32px; line-height:55px; padding:10px 0px 0px 0px; margin:0px; text-align:center; letter-spacing:2px;">
                        开创性的新用法，<br> 就在你的 Mac 上。</p>
                    <p style="font-size:15px; line-height:28px; padding:20px 30px 20px 30px; margin:0px; text-align:center;">
                        Multi-Touch Bar 取代了以往键盘最上方的功能键，为你带来更多能、更实用的功能。它会根据你当前的操作自动显示不同的样子，呈现给你相关的工具，比如系统控制键里的音量和亮度、互动操作中的调整和内容浏览工具、智能输入功能中的表情符号和文本输入预测等等，这些都是你早就运用自如的。此外，Touch
                        ID 功能也首次登陆 Mac，让你可以在转瞬之间完成登录等各种操作。</p>
                    <p style="font-size:15px; line-height:28px; padding:510px 30px 20px 30px; margin:0px; text-align:center;">
                        你可以将常用的表情符号添加到邮件中，让你的表达生动传神。<br> 还可以使用文本输入预测功能更快地输入信息。
                    </p>
                </div>
                <div style="width:800px; margin:0px auto; padding:0px; font-family:&#39;微软雅黑&#39;; height:1160px; background:url(http://img.1yyg.net/GoodsInfo/20161101171939640.jpg) no-repeat center; color:#333; border-bottom:1px solid #C1C1C1;">
                    <p style="font-size:22px; line-height:30px; padding:50px 0px 0px 0px; margin:0px; text-align:center;">
                        性能</p>
                    <p style="font-size:32px; line-height:55px; padding:10px 0px 0px 40px; margin:0px; text-align:center; letter-spacing:2px;">
                        各行各业，<br> 都是专业利器。
                    </p>
                    <p style="font-size:16px; line-height:30px; padding:20px 0px 20px 0px; margin:0px; text-align:center;">
                        新一代 MacBook Pro 的推出，将笔记本电脑的性能与便携性提<br> 升到一个新的高度。无论你的目标有多远大，它强劲的图形处理器、高性能的中央处理器、先进的存储设备
                        <br> ，以及众多强大配置，都能助你加速实现创意构想。
                    </p>
                </div>
                <div style="width:800px; margin:0px auto; padding:0px; font-family:&#39;微软雅黑&#39;; height:1329px; background:url(http://img.1yyg.net/GoodsInfo/20161101172147483.jpg) no-repeat center; color:#333; border-bottom:1px solid #C1C1C1;">
                    <p style="font-size:22px; line-height:30px; padding:50px 0px 0px 0px; margin:0px; text-align:center;">
                        Retina 显示屏</p>
                    <p style="font-size:32px; line-height:55px; padding:10px 0px 0px 40px; margin:0px; text-align:center; letter-spacing:2px;">
                        迄今最明亮、最多彩的<br> Mac 笔记本显示屏</p>
                    <p style="font-size:15px; line-height:30px; padding:20px 20px 20px 20px; margin:0px; text-align:center;">
                        MacBook Pro 配备的是更胜以往的 Mac 笔记本电脑显示屏。它采用比以往亮度更高的 LED 背光组件，<br> 并且提升了对比度，因此呈现出来的黑色更加深邃，白色更加明亮。更大的像素孔径和可变的刷新率，使它比上一代机型能效更高。而且，全新
                        MacBook Pro 是首款拥有广色域的 Mac 笔记本电脑，可以使绿色和红色的显示效果更加鲜艳生动，让画面的细节鲜明毕现，栩栩如生。对于图形设计、调色和影像编辑来说，这一点至关重要。</p>
                    <p
                        style="font-size:14px; line-height:30px; padding:740px 460px 20px 70px; margin:0px;">
                        MacBook Pro 现在拥有 P3 色域，可显示的色彩数量比标准 RGB 增加了 25%，呈现的绿色和红色范围更广。</p>
                </div>
                <div style="width:800px; margin:0px auto; padding:0px; font-family:&#39;微软雅黑&#39;; height:971px; background:url(http://img.1yyg.net/GoodsInfo/20161101172210136.jpg) no-repeat center; color:#333; border-bottom:1px solid #C1C1C1;">
                    <p style="font-size:25px; line-height:35px; padding:50px 0px 0px 0px; margin:0px; text-align:center;">
                        音频</p>
                    <p style="font-size:32px; line-height:55px; padding:10px 0px 0px 0px; margin:0px; text-align:center; letter-spacing:2px;">
                        扬声器，效果响当当。</p>
                    <p style="font-size:16px; line-height:30px; padding:530px 30px 20px 30px; margin:0px; text-align:center;">
                        我们对扬声器进行了焕然一新的设计，动态范围宽达原来的两倍，<br> 音量最高提升 58%，低音增强至 2.5 倍，可营造出震撼的音响效果。而且，扬声器现在直接连接到系统电源，峰值功率最高提升至三倍。这些改进，使
                        MacBook Pro 非常适合随手进行混音编曲、现场剪辑视频或在旅途中欣赏影片。</p>
                </div>
                <div style="width:800px; margin:0px auto; padding:0px; font-family:&#39;微软雅黑&#39;; height:780px; background:url(http://img.1yyg.net/GoodsInfo/20161101172251432.jpg) no-repeat center; color:#333; border-bottom:1px solid #C1C1C1;">
                    <p style="font-size:22px; line-height:30px; padding:60px 0px 0px 250px; margin:0px;">
                        键盘和触控板</p>
                    <p style="font-size:32px; line-height:55px; padding:10px 0px 0px 250px; margin:0px; letter-spacing:2px;">
                        更灵敏的键盘，<br> 更宽阔的触控板。
                    </p>
                    <p style="font-size:16px; line-height:30px; padding:15px 30px 20px 250px; margin:0px;">
                        现在，新一代 MacBook Pro 互动体验的方方面面都更加出色。键盘经过重新设计，采用经过精心优化的第二代蝶式结构，手感更舒适，响应更灵敏。Force Touch 触控板的尺寸也显著增大了，让你有更多空间施展触控手势和进行点按操作。</p>
                </div>
                <div style="width:800px; margin:0px auto; padding:0px; font-family:&#39;微软雅黑&#39;; height:944px; background:url(http://img.1yyg.net/GoodsInfo/20161101172335849.jpg) no-repeat center; color:#333; border-bottom:1px solid #C1C1C1;">
                    <p style="font-size:22px; line-height:30px; padding:65px 0px 0px 0px; margin:0px; text-align:center;">
                        Thunderbolt 3</p>
                    <p style="font-size:32px; line-height:55px; padding:10px 0px 0px 40px; margin:0px; text-align:center; letter-spacing:2px;">
                        高速又多用，尽在一个接口。</p>
                    <p style="font-size:15px; line-height:30px; padding:20px 30px 20px 30px; margin:0px; text-align:center;">
                        Thunderbolt 3 不但拥有超高的带宽，同时具备了 USB-C 行业标准的高度多用性，从而打造出一个极速的通用端口。它仅用区区一个接口，就将数据传输、充电和视频输出功能集于一身，可提供最高达 40 Gbps 的数据吞吐能力，带宽高达
                        Thunderbolt 2 的两倍。两款尺寸的 MacBook Pro 均有配备四个端口的机型，从任何一侧，都可以很方便地使用所有这些功能。你只需一根连接线缆或转换器，即可轻松连接上现有的设备。另外，Thunderbolt
                        3 采用双面可用的设计，接入时完全没有正反面的问题。</p>
                    <p style="font-size:14px; line-height:30px; padding:410px 460px 20px 40px; margin:0px;">
                        一台配备四个 Thunderbolt 3 端口的 15 英寸 MacBook Pro 可以同时连接两台 5K 显示屏和两个 RAID 系统，打造出一个强大的工作平台。</p>
                </div>
                <div style="width:800px; margin:0px auto; padding:0px; font-family:&#39;微软雅黑&#39;; height:988px; background:url(http://img.1yyg.net/GoodsInfo/20161101172408284.jpg) no-repeat center; color:#333; border-bottom:1px solid #C1C1C1;">
                    <p style="font-size:22px; line-height:30px; padding:40px 0px 0px 0px; margin:0px; text-align:center;">
                        macOS</p>
                    <p style="font-size:32px; line-height:55px; padding:10px 0px 0px 40px; margin:0px; text-align:center; letter-spacing:2px;">
                        正是它，<br> 让 Mac 如此与众不同。</p>
                    <p style="font-size:15px; line-height:30px; padding:20px 30px 20px 30px; margin:0px; text-align:center;">
                        Mac 如此强大好用，macOS 这一操作系统功不可没。它经过精心打造，不但能使 Mac 硬件的性能得到充分发挥，而且用起来简单顺手，看起来也赏心悦目。macOS 包含一系列精彩 app，这些 app 会在你的日常生活中大派用场，并让你乐在其中。不仅如此，它还可以通过
                        iCloud 以及各种创新的方式，让你的 Mac、iOS 设备以及 Apple Watch 默契协作。</p>
                </div>
                <div style="width:800px; margin:0px auto; font-family:&#39;微软雅黑&#39;; padding-bottom:20px; border-bottom:1px solid #C1C1C1;">
                    <p style="font-size:18px; line-height:25px; padding:20px 0 10px 0px; margin:0px;">
                        重要说明：</p>
                    <p style="font-size:14px; line-height:22px; padding:0 0 10px 0px; margin:0px;">
                        1、商品获得者拥有苹果（Apple）MacBook Pro 13.3英寸笔记本电脑 10年免费使用权。</p>
                    <p style="font-size:14px; line-height:22px; padding:0 0 10px 0px; margin:0px;">
                        2、1元云购对本商品使用权在法律范围内拥有最终解释权。</p>
                    <p style="font-size:14px; line-height:22px; padding:0 0 10px 0px; margin:0px;">
                        3、商品详情图片仅供参考，具体以收到实物为准。</p>
                </div>
            </div>
        </div>
    </div>
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
            <li id="li_top" style="display: none;"><a href="javascript:;"><i class="nav-top"></i></a></li>
        </ul>
        <div class="sub-nav five" style="display:none;"><a href="http://weixin.1yyg.com/v40/index.do"><i class="home"></i>云购</a><a href="http://weixin.1yyg.com/v40/lottery/"><i class="announced"></i>最新揭晓</a>
            <a
                href="http://weixin.1yyg.com/v40/post/index.do"><i class="single"></i>晒单</a><a href="http://weixin.1yyg.com/myInfo.htm"><i class="personal"></i>我的云购</a><a href="http://weixin.1yyg.com/v40/mycart/"><i class="shopcar"></i>购物车</a></div>
    </div>
    <script language="javascript" type="text/javascript" src="./static/Bottom.js"></script>
    <script language="javascript" type="text/javascript" src="./static/BottomFun.js"></script>
    <script language="javascript" type="text/javascript" src="./static/cnzzCount.js"></script>
    <script language="javascript" type="text/javascript" src="./static/Comm.js"></script>
    <script language="javascript" type="text/javascript" src="./static/CartComm.js"></script>
</body>

</html>