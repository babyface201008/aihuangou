$(function(){var b=function(f){$.PageDialog.fail(f)};var d=function(f){$.PageDialog.ok(f)};var e=function(){var f=parseInt($("#hidUserID").val());if(f>0){GetJPData("https://y.1yyg.com","getShortUrl","urlType=0",function(k){if(k.code==0){var h="1元云购是一种很有意思的新型购物模式，1元就可能买到iPhone 6S，快来试试吧！";var m=k.shortUrl;$("#txtInfo").html(h+m);GetJPData("","getqrcodeauth","str="+escape(m),function(n){if(n.code==0){$("#p_prcode").bind("click",function(){var o=$('<img src="'+Gobal.WxDomain+"/GetQR.ashx?sn="+n.auth+"&str="+escape(m)+'&size=6&scale=4" alt="">');o.load(function(){var q=null;var p='<div class="sha-bg"><div class="sha-wrapper"><div class="sha-inner"><div class="sha-code"><img src="'+o.attr("src")+'" alt=""></div><p class="sha-word">1元云购 - 惊喜无限</p><a href="javascript:;" class="close-code"><i class="z-set"></i></a></div</div></div>';var r=function(){$("div.sha-bg").click(function(){q.cancel()})};q=new $.PageDialog(p,{W:300,H:300,autoClose:false,ready:r,isTop:false})})})}});var g=["1元云购是一种很有意思的新型购物模式，1元就可能买到iPhone 6S，快来试试吧！"],j="https://skin.1yyg.net/v1/weixin/Images/iPhone6S.jpg?v=151104",l="1元就可能买到iPhone 6S，快来试试吧！",i=m;$("#btnShare").bind("click",function(n){if(Gobal.IsWeixin){wxShareFun({shareLink:i,shareImg:j,shareDesc:l,shareTitle:g,showMask:false});wxShowMaskFun(true)}else{mShareTools.InitialSettings({sTitle:g,sImg:j,sUrl:i,sDesc:l});mShareTools.ShowShare()}return false})}})}};var c=function(){var h=$("div.weixin-mask");var g=parseFloat($("#hidCurrMoney").val());var f=$("#hidHasPaypwd").val()=="1";$("#liMention").click(function(){var i=function(l){$("body").attr("style","overflow:hidden;");var k=$(l);$("body").append(k).find("#closeDiag").click(function(){$("div.acc-pop").remove();h.hide();$("body").attr("style","");IsMasked=false});k.css({top:($(window).height()-k.height()-64)/2,left:($(window).width()-k.width()-32)/2}).show();h.css("height",$(document).height()>$(window).height()?$(document).height():$(window).height()).show();IsMasked=true};if(!f){var j='<div class="acc-pop"><h3 class="gray6">需要设置支付密码才能进行提现</h3><h6 class="gray9">请先设置支付密码再进行提现操作</h6><a id="okDiag" href="PayPwdCheck.do?forward='+escape(location.href)+'" class="orangeBtn">立即设置</a><a id="closeDiag" href="javascript:;" class="box-close z-set"></a></div>';i(j)}else{if(g>=100){location.href="MentionApply.do"}else{b("佣金满100才可提现哦")}}})};var a=function(){$("#btnBind").attr("href","/"+Gobal.SiteVer+"/member/MobileBind.do?forward="+escape(location.href)).show()};Base.getScript(Gobal.Skin+"/JS/pageDialog.js?v=160304",function(){if($("#divUnbind").length>0){a()}else{c();Base.getScript(Gobal.Skin+"/JS/WxShare.js?v=170329",function(){e()})}})});