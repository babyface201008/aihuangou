$(function(){var a=function(){var b=function(o){$.PageDialog.fail(o)};var g=function(o){$.PageDialog.ok(o)};var d=$("#hidGoodsID").val();if(d>0){var n=false;var h=$("#a_sc");var k=function(){if(n){return}n=true;var o=function(p){if(p.code==0){g("已关注");h.addClass("z-foot-fansed").unbind("click").bind("click",function(){e()})}else{if(p.code==1){if(p.num==-1){b("关注失败，商品不存在！");location.reload()}else{if(p.num==-2){h.addClass("z-foot-fansed").unbind("click").bind("click",function(){e()})}}}else{if(p.code==10){location.href=Gobal.WxDomain+"/"+Gobal.SiteVer+"/Passport/login.do?forward="+escape(location.href)}else{b("关注失败，请重试["+p.code+"]！");location.reload()}}}n=false};GetJPData("https://api.1yyg.com","addCollectGoods","goodsID="+d,o)};var e=function(){if(n){return}n=true;var o=function(p){if(p.code==0){g("已取消关注");h.removeClass("z-foot-fansed").unbind("click").bind("click",function(){k()})}else{b("取消关注失败，请重试！");location.reload()}n=false};GetJPData("https://api.1yyg.com","delCollectGoods","goodsID="+d,o)};var i=function(o){if(o.code==0){h.addClass("z-foot-fansed").unbind("click").bind("click",function(){e()})}else{h.bind("click",function(){k()})}};GetJPData("https://api.1yyg.com","checkCollectGoods","goodsID="+d,i)}var f=$("#hidBuyNum").val();var l=$("#hidShareDesc").val();var c=["(٩(´͈ᗨ`͈)۶) 买它只花了"+f+"元，一种全新的购物模式，你也来试试吧！"];var m=Gobal.WxDomain+"/"+Gobal.SiteVer+"/lottery/detail-"+$("#hidCodeID").val()+".do";var j=$("#hidShareImg").val();$("#btnShare").bind("click",function(){if(Gobal.IsWeixin){wxShareFun({shareLink:m,shareImg:j,shareDesc:l,shareTitle:c,showMask:false});wxShowMaskFun()}else{mShareTools.InitialSettings({sTitle:c,sImg:j,sUrl:m,sDesc:l});mShareTools.ShowShare()}})};Base.getScript(Gobal.Skin+"/JS/pageDialog.js?v=160304",function(){Base.getScript(Gobal.Skin+"/JS/WxShare.js?v=170329",a)})});