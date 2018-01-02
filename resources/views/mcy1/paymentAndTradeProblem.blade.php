<!DOCTYPE html>
<!-- saved from url=(0045)//v41/help/TradeQuestions.do -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>支付交易问题</title>
    
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">

    <link href="./static/comm.css" rel="stylesheet" type="text/css"><link href="./static/help.css" rel="stylesheet" type="text/css"><script src="./static/jquery190.js" language="javascript" type="text/javascript"></script>

</head>
<body class="g-acc-bg" style="zoom: 1;">
    
<!--触屏版内页头部-->
<div class="m-block-header" id="div-header" style="display: block;">
    <strong id="m-title">支付交易问题</strong>
    <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
    <a href="/index.htm" class="m-index-icon"><i class="m-public-icon"></i></a>
</div>
<script>
    if (navigator.userAgent.toLowerCase().match(/MicroMessenger/i) != "micromessenger") {
        document.getElementById('div-header').style.display = 'block';
    }
    document.getElementById('m-title').innerText = document.title;
</script>


	<div id="content">
        <div class="u-w-wrapper">
            <ul class="u-ques-list ft14" id="u-ques-total">
                <li class="thin-bottom-bor">
                    <a href="javascript:;" class="gray3">
                        <span>支付成功了，为什么没有购买到云购码？钱款怎么处理？</span>
                        <i class="arrow gt"></i>
                    </a>
                    <div class="u-ques-info thin-top-bor">
                        <div class="ft12 p-wrapper gray6">
                            <p>支付成功却没有获得云购码的情况有以下原因：</p>
                            <p>1、您在支付的过程中商品份数已被支持完毕，支付成功后已没有云购码可分配。</p>
                            <p>解决：1元云购会自动将钱返还到您的云购账户上，您可以在“账户明细”里查询。</p>
                            <p>2、因到账延迟导致1元云购网未及时接收到到账指令。</p>
                            <p>解决：稍后查看或致电平台客服核实处理。</p>
                            <p>3、因网络拥堵造成云购码延迟显示。</p>
                            <p>解决：稍后查看或致电平台客服核实处理。</p>
                        </div>
                    </div>
                </li>
                <li class="thin-bottom-bor">
                    <a href="javascript:;" class="gray3">
                        <span>网上银行充值未及时到帐怎么办？</span>
                        <i class="arrow gt"></i>
                    </a>
                    <div class="u-ques-info thin-top-bor">
                        <div class="ft12 p-wrapper gray6">
                            <p>网上支付未及时到账可能有以下几个原因造成：</p>
                            <p>1、由于网速或者支付接口等问题，支付数据没有及时传送到支付系统造成的；</p>
                            <p>2、网速过慢，数据传输超时，使银行后台支付信息不能成功对接，导致银行交易成功而支付后台显示失败；</p>
                            <p>3、在网上支付如果使用某些防火墙软件，有时会屏蔽银行接口的弹出窗口，这时会造成在银行那边被扣费，但在我们网站上显示尚没支付。</p>
                            <p>充值未到账情况下请不要着急，我们每天都会根据银行系统的账务明细清单对前一天的订单进行逐笔核对，如遇问题订单，我们会做手工添加。</p>
                        </div>
                    </div>
                </li>
                <li class="thin-bottom-bor">
                    <a href="javascript:;" class="gray3">
                        <span>1元云购目前支持哪些支付方式？</span>
                        <i class="arrow gt"></i>
                    </a>
                    <div class="u-ques-info thin-top-bor">
                        <div class="ft12 p-wrapper gray6">
                            <p>
                                1元云购目前支持第三方支付平台支付、储蓄卡支付、信用卡支付。支持的第三方支付平台有：京东支付、快钱、银联支付。
                                储蓄卡支付和信用卡支付支持国内各大银行卡。1元云购将积极拓展更多支付方式，方便您自由选择的同时给予您更多愉悦体验。
                            </p>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="javascript:;" class="gray3">
                        <span>出现交易失败或支付异常怎么办？</span>
                        <i class="arrow gt"></i>
                    </a>
                    <div class="u-ques-info thin-top-bor">
                        <div class="ft12 p-wrapper gray6">
                            <p>不排除会因为网络或者其他原因出现交易失败或支付异常的情况。在此情况下，不要着急，请及时拨打客服电话4000 588 688或联系在线客服，会有客服人员协助您处理。</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>


	<script>
	    $(function () {

	        var $quesTotal = $("#u-ques-total"),
				$quesTotalLi = $quesTotal.find("li"),
				$quesTotalA = $quesTotalLi.find("a"),
				$quesTotalIcon = $quesTotalA.find("i"),
				$quesInfoDiv = $quesTotalLi.find(".u-ques-info");
	        var addHeight = 0, display = false;


	        $quesTotalA.on("click", function () {
	            //重置所有状态
	            $quesTotalLi.removeClass('current');
	            $quesInfoDiv.height(0);

	            var $quesInfoThis = $(this).next();

	            addHeight = $quesInfoThis.children().outerHeight();
	            display = $quesInfoThis.height() == 0 ? true : false;

	            if (display) {
	                $(this).parent().addClass('current');
	            } else {
	                $(this).parent().removeClass('current');
	            }
	            $quesInfoThis[0].style.height = (display ? addHeight : 0) + "px";
	        })
	    })
	</script>


<div style="position: static; width: 0px; height: 0px; border: none; padding: 0px; margin: 0px;"><div id="trans-tooltip"><div id="tip-left-top" style="background: url(&quot;chrome-extension://ikkbfngojljohpekonpldkamedehakni/imgs/map/tip-left-top.png&quot;);"></div><div id="tip-top" style="background: url(&quot;chrome-extension://ikkbfngojljohpekonpldkamedehakni/imgs/map/tip-top.png&quot;) repeat-x;"></div><div id="tip-right-top" style="background: url(&quot;chrome-extension://ikkbfngojljohpekonpldkamedehakni/imgs/map/tip-right-top.png&quot;);"></div><div id="tip-right" style="background: url(&quot;chrome-extension://ikkbfngojljohpekonpldkamedehakni/imgs/map/tip-right.png&quot;) repeat-y;"></div><div id="tip-right-bottom" style="background: url(&quot;chrome-extension://ikkbfngojljohpekonpldkamedehakni/imgs/map/tip-right-bottom.png&quot;);"></div><div id="tip-bottom" style="background: url(&quot;chrome-extension://ikkbfngojljohpekonpldkamedehakni/imgs/map/tip-bottom.png&quot;) repeat-x;"></div><div id="tip-left-bottom" style="background: url(&quot;chrome-extension://ikkbfngojljohpekonpldkamedehakni/imgs/map/tip-left-bottom.png&quot;);"></div><div id="tip-left" style="background: url(&quot;chrome-extension://ikkbfngojljohpekonpldkamedehakni/imgs/map/tip-left.png&quot;);"></div><div id="trans-content"></div></div><div id="tip-arrow-bottom" style="background: url(&quot;chrome-extension://ikkbfngojljohpekonpldkamedehakni/imgs/map/tip-arrow-bottom.png&quot;);"></div><div id="tip-arrow-top" style="background: url(&quot;chrome-extension://ikkbfngojljohpekonpldkamedehakni/imgs/map/tip-arrow-top.png&quot;);"></div></div></body></html>