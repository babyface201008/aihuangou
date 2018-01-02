
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>收银台</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0"/>
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <link href="http://m.1yygbh.com/statics/templates/ffxiang/css/mobile/comm.css?v=17051301" rel="stylesheet" type="text/css" />
    <script src="http://m.1yygbh.com/statics/plugin/jquery/jquery-1.9.1.min.js" language="javascript" type="text/javascript"></script>    <link href="http://m.1yygbh.com/statics/templates/ffxiang/css/mobile/cartList.css" rel="stylesheet" type="text/css" />
	<script id="pageJS" data="http://m.1yygbh.com/statics/templates/ffxiang/js/mobile/Payment.js?v=20170219" language="javascript" type="text/javascript"></script>
	<script type="text/javascript" src="http://m.1yygbh.com/statics/templates/ffxiang/js/jquery.cookie.js"></script>
<style>
    a.noMoney{
        background:#bdbbb9;
        border:1px solid #bdbbb9;
    }
</style>
</head>
<body>
<div class="h5-1yyg-v1">

    <input name="hidShopMoney" type="hidden" id="hidShopMoney" value="1" />
    <input name="hidBalance" type="hidden" id="hidBalance" value="0.00" />
    <input name="hidPoints" type="hidden" id="hidPoints" value="50" />
    <input name="shopnum" type="hidden" id="shopnum" value="0" />
    <input name="pointsbl" type="hidden" id="pointsbl" value="0" />
    <section class="clearfix g-pay-lst">
		<ul>
		 			<li>
			    <a href="http://m.1yygbh.com/index.php/mobile/mobile/item/2375" class="gray6">(第974期)苹果iPhone 7 Plus 256G版 4G手机 （颜色随机）</a>
			    <span>
			        <em class="orange arial">￥1.00</em>
			    </span>
			</li>
		 		</ul>
		<p  class="g-pay-Total gray9" > 合计：<span class="orange arial Fb F16" id="hongbao_jg">￥1.00</span> 元</p>
		<p class="g-pay-bline"></p>
    </section>
    <section class="clearfix g-Cart">
	    <article class="clearfix m-round g-pay-ment">
		    <ul id="ulPayway">
						     <li class="gray6 z-pay-ff z-pay-grayC">
				<span>您的福分不足（您的福分：50）</span>
				</li>
						
						    <li class="gray6 z-pay-ye z-pay-grayC">
				<a href="http://m.1yygbh.com/index.php/mobile/home/user_recharge" class="z-pay-Recharge">去充值</a>
				<span>您的余额不足（账户余额：0.00 元）</span>
				</li> 
					    </ul>
	    </article>
				<article id="nonpay" class="clearfix mt10 m-round g-pay-ment">
			<ul>
				<li class="z-pay-ye z-pay-grayC">
					<a href="http://m.1yygbh.com/index.php/mobile/home/user_recharge" class="z-pay-Recharge">去充值</a>
					<span style="color: #dc332d;">低于20元请前往充值后使用余额支付</span>
				</li>
			</ul>
		</article>
		        <article id="buynextList" class="clearfix mt10 m-round g-pay-ment g-bank-ct">
            <ul>
                <li style="color:#959595" class="gray6 z-pay-grayC">是否自动购买下一期:<input id="buynext" disabled="disabled"  checked='checked' type="checkbox" style="margin-top:10px;float:right;display: none;" /><label id="bnlabel" class='z-pay-mentsel' for="buynext"></label></li>
            </ul>
        </article>
    </section>
	<div class="g-Total-bt g-Pay-new">
                    <dd><a href="http://m.1yygbh.com/index.php/mobile/home/user_recharge"  class="orgBtn fr w_account noMoney">余额不足，请前往充值</a></dd>
            </div>
<script src="https://s11.cnzz.com/z_stat.php?id=1259931418&web_id=1259931418" language="JavaScript" type="hidden"></script>
<footer class="footer">
    <span id="btnTop" class="z-top" title="返回顶部"><b class="z-arrow"></b></span>
    <div class="u-ft-nav">
        <ul>
            <li class="f_home"><a href="http://m.1yygbh.com/index.php/mobile/mobile/init"><i></i>首页</a></li>
            <li class="f_allgoods"><a href="http://m.1yygbh.com/index.php/mobile/mobile/glist"><i></i>所有商品</a></li>
            <li class="f_announced"><a href="http://m.1yygbh.com/index.php/mobile/mobile/lottery"><i></i>最新揭晓</a></li>
            <li class="f_car"><a id="btnCart" href="http://m.1yygbh.com/index.php/mobile/cart/cartlist"><i></i>购物车</a></li>
            <li class="f_personal"><a href="http://m.1yygbh.com/index.php/mobile/home"><i></i>我的主页</a></li>
        </ul>
    </div>
    <!--置顶按钮滚动特效-->
    <script src="http://m.1yygbh.com/statics/templates/ffxiang/js/mobile/topHovertree.js" language="javascript" type="text/javascript"></script>
    <script>
        $(".f_ > a").addClass("hover");
        initTopHoverTree("btnTop",500,1,58);
    </script>
</footer>

<!--开启全站微信分享自定义-->
<script type="text/javascript" src="http://m.1yygbh.com/statics/templates/ffxiang/js/jquery.cookie.js"></script>
<!--end-->
<script language="javascript" type="text/javascript">
  var Path = new Object();
  Path.Skin="http://m.1yygbh.com/statics/templates/ffxiang";  
  Path.Webpath = "http://m.1yygbh.com/index.php";
  Path.submitcode = '59560e7511f00';
  
var Base={head:document.getElementsByTagName("head")[0]||document.documentElement,Myload:function(B,A){this.done=false;B.onload=B.onreadystatechange=function(){if(!this.done&&(!this.readyState||this.readyState==="loaded"||this.readyState==="complete")){this.done=true;A();B.onload=B.onreadystatechange=null;if(this.head&&B.parentNode){this.head.removeChild(B)}}}},getScript:function(A,C){var B=function(){};if(C!=undefined){B=C}var D=document.createElement("script");D.setAttribute("language","javascript");D.setAttribute("type","text/javascript");D.setAttribute("src",A);this.head.appendChild(D);this.Myload(D,B)},getStyle:function(A,B){var B=function(){};if(callBack!=undefined){B=callBack}var C=document.createElement("link");C.setAttribute("type","text/css");C.setAttribute("rel","stylesheet");C.setAttribute("href",A);this.head.appendChild(C);this.Myload(C,B)}}
function GetVerNum(){var D=new Date();return D.getFullYear().toString().substring(2,4)+'.'+(D.getMonth()+1)+'.'+D.getDate()+'.'+D.getHours()+'.'+(D.getMinutes()<10?'0':D.getMinutes().toString().substring(0,1))}
Base.getScript('http://m.1yygbh.com/statics/templates/ffxiang/js/mobile/Bottom.js?v='+GetVerNum());
	function changeWxPay() {
		$("#bankList li[urm=7]").attr("urm", 8);
	}

    $(function () {
        //展开所有商品
        $(".g-pay-Total.more").click(function(){
            $(".g-pay-lst li:nth-child(n+6)").css("display","block");
            $('<style>.g-pay-Total::after{visibility:hidden}</style>').appendTo('head');
            $("html,body").animate({scrollTop:0},1000);
        });

        //点击支付
        $("#btnPay").click(function () {
            $(this).text("正在支付，请等待……");
        })
    });
</script>
</div>
</body>
</html>