$(function(){var c=function(){var f=new $CartComm();var w=$("#isEnabledBakLoadApp").val();var r=function(){var z=function(){if($.cookie("_showAppDown")!="0"){$(".app-down").show().click(function(){if(w=="1"){window.location.href="/"+Gobal.SiteVer+"/LoadApp.do"}else{window.location.href="http://a.app.qq.com/o/simple.jsp?pkgname=com.yyg.cloudshopping"}}).find("a.app-down-close").click(function(A){stopBubble(A);$(this).parent().hide();$.cookie("_showAppDown","0",{expires:7,path:"/"})})}};z();if(Gobal.IsWeixin){if($("#hidOpenID").val()==""&&$.cookie("_showBindWX")!="0"){$("#div_subscribe").show().click(function(){var B=null;var A='<div class="index-code-wrap"><h6>闀挎寜璇嗗埆浜岀淮鐮�</h6><div class="code"><img src="https://skin.1yyg.net/'+Gobal.SiteVer+'/weixin/images/index-code.jpg?160229" alt="1鍏冧簯璐畼鏂瑰井淇�"></div><a  href="javascript:;" class="close-code"><i class="z-set"></i></a></div>';var C=function(){$("a.close-code").click(function(){B.cancel()})};B=new $.PageDialog(A,{W:300,H:300,autoClose:false,ready:C,isTop:false})}).find("a.close-icon").click(function(A){stopBubble(A);$(this).parent().parent().hide();$.cookie("_showBindWX","0",{expires:7,path:"/"})})}else{z()}}else{$(".m-block-header").show()}};r();var s=function(){$("#btnNew").click(function(){location.href="/"+Gobal.SiteVer+"/goodslist.do?order=50"});$("#btnRecharge").click(function(){location.href="/"+Gobal.SiteVer+"/member/recharge.do"});$("#btnLimitbuy").click(function(){location.href="/"+Gobal.SiteVer+"/goodslist.do?sort=400&order=10"});$("#btnDownApp").click(function(){if(w=="1"){window.location.href="/"+Gobal.SiteVer+"/LoadApp.do"}else{window.location.href="http://a.app.qq.com/o/simple.jsp?pkgname=com.yyg.cloudshopping"}});$("#btnAllGoods").click(function(){location.href="/"+Gobal.SiteVer+"/goodslist.do"});$("#btnSearch").click(function(){location.href="/"+Gobal.SiteVer+"/goodssearch.do#sbox"})};s();var o=function(){var z=$("#sliderBox");GetJPData("https://api.1yyg.com","getbysortid","id=35",function(G){if(G.state==0){var F=G.listItems;var E="<ul>";var C="";for(var D=0;D<F.length;D++){C=F[D].url;if(C.indexOf("?")>-1){C+="&pf=weixin"}else{C+="?pf=weixin"}var B=C.replace("http://m.1yyg.com",Gobal.WxDomain+"/"+Gobal.SiteVer);E+='<li style="background-color:'+F[D].alt+';"><a href="'+B+'"><img src="'+F[D].src.replace("http://img.1yyg.net","https://img.1yyg.net")+'" alt="" /></a></li>'}E+="</ul>";var A=$(E);A.addClass("slides");z.empty().append(A).flexslider({slideshow:true})}})};Base.getScript(Gobal.Skin+"/JS/Flexslider.js?v=160722",o);var h=function(z){$.PageDialog('<div class="Prompt">'+z+"</div>",{W:150,H:45,close:false,autoClose:true,submit:function(){location.reload()}})};var y=function(z){$.PageDialog.fail(z)};var i=function(z){$.PageDialog.ok(z)};var m=function(G,A,B,z,I){var C=255;var F=126;if(typeof(z)!="undefined"){C=z}if(typeof(z)!="undefined"){F=I}var H=null;var J='<div class="clearfix m-round u-tipsEject"><div class="u-tips-txt">'+G+'</div><div class="u-Btn"><div class="u-Btn-li"><a href="javascript:;" id="btnMsgCancel" class="z-CloseBtn">鍙栨秷</a></div><div class="u-Btn-li"><a id="btnMsgOK" href="javascript:;" class="z-DefineBtn">纭畾</a></div></div></div>';var E=function(){var K=$("#pageDialog");K.find("a.z-DefineBtn").click(function(){if(typeof(A)!="undefined"&&A!=null){A()}D.close()});K.find("a.z-CloseBtn").click(function(){if(typeof(B)!="undefined"&&B!=null){B()}D.cancel()})};var D=new $.PageDialog(J,{W:C,H:F,close:true,autoClose:false,ready:E})};var u=$("#goodsNav");var d=u.offset().top;var v=d+u.height();var k=false;var q=null;var n=function(){var z=$(document).scrollTop();if(z>=v){if(k){return}k=true;if(q==null){q=$('<nav class="nav-wrapper"></nav>');q.append(u.children().clone());u.parent().append(q)}else{q.show()}u.parent().addClass("nav-wrapper");u.addClass("top-fixed")}else{k=false;if(q!=null){q.hide()}u.parent().removeClass("nav-wrapper");u.removeClass("top-fixed")}};$(window).scroll(function(){n()});$("#ulOrder li").each(function(){$(this).click(function(){$(this).addClass("current").siblings().removeClass("current");j.orderFlag=parseInt($(this).attr("order"));l.initPage();if(j.orderFlag==30){$(this).attr("order","31")}else{if(j.orderFlag==31){$(this).attr("order","30")}}if(k){k=false;if(q!=null){q.hide()}u.parent().removeClass("nav-wrapper");u.removeClass("top-fixed")}})});var l=null;var x=60;var e=0;var j={sortID:0,orderFlag:10,FIdx:1,EIdx:x,isCount:1};var p=$("#ulGoodsList");var t=$("div.loading");var g=function(){var z=function(){return"sortID="+j.sortID+"&orderFlag="+j.orderFlag+"&FIdx="+j.FIdx+"&EIdx="+j.EIdx+"&isCount="+j.isCount};var A=function(G,F,D,C,E){G.addClass("add");f.addShopCart(F,D,function(H){if(H.code==0){if(typeof(C)=="function"){C()}else{i("娣诲姞鎴愬姛")}addNumToCartFun(H.num)}else{if(H.code==2){y("鍝庡憖锛佽喘鐗╄溅婊″暒锛屽垹闄や竴浜涘惂锛�",300)}else{y("娣诲姞澶辫触锛岃閲嶈瘯["+H.code+"]")}}G.removeClass("add")},E)};var B=function(){GetJPData(Gobal.WxDomain,"getGoodsPageList",z(),function(J){if(J.code==0){var G=J.listItems;if(j.isCount==1){e=J.count;j.isCount=0}var K=G.length;var L=0;var N=0;var C=0;var O=0;var H=0;var E="";for(var I=0;I<K;I++){var F=G[I];var D=parseInt(F.codeType);L=parseInt(F.codeSales);N=parseInt(F.codeQuantity);C=parseInt(N-L);O=parseInt(L*100)/N;O=L>0&&O<1?1:O;H=C;if(D==3){H=F.codeLimitBuy>=C?C:F.codeLimitBuy}E='<li id="'+F.goodsID+'" codeID="'+F.codeID+'" goodsID="'+F.goodsID+'" codePeriod="'+F.codePeriod+'"><a href="javascript:;" class="g-pic"><img name="goodsImg" src="'+Gobal.LoadPic+'" src2="https://img.1yyg.net/GoodsPic/pic-200-200/'+F.goodsPic+'" width="136" height="136" />'+(D==3?'<div class="pTitle pPurchase">闄愯喘</div>':"")+'</a><p class="g-name">(绗�<em>'+F.codePeriod+"</em>浜�)"+F.goodsSName+'</p><ins class="gray9">浠峰€硷細锟�'+CastMoney(F.codePrice)+'</ins><div class="Progress-bar"><p class="u-progress"><span class="pgbar" style="width: '+O+'%;"><span class="pging"></span></span></p></div><div class="btn-wrap" name="buyBox" limitBuy="'+F.codeLimitBuy+'" surplus="'+C+'" totalnum="'+N+'" alreadybuy="'+L+'"><a href="javascript:;" class="buy-btn'+(C==0?" unAdd":"")+'" codeid="'+F.codeID+'">绔嬪嵆1鍏冧簯璐�</a><div class="gRate'+(C==0?" unAdd":"")+'" codeid="'+F.codeID+'" canbuy="'+H+'"><a href="javascript:;"><s></s></a></div></div></li>';var M=$(E);M.click(function(){location.href="/"+Gobal.SiteVer+"/products/"+$(this).attr("id")+".do"}).find("div.gRate").click(function(Q){stopBubble(Q);try{_czc.push(["_trackEvent","寰俊棣栭〉","鐐瑰嚮","鍔犲叆璐墿杞�","",""])}catch(Q){}var P=$(this);if(!P.hasClass("unAdd")){A(P,P.attr("codeid"),1,null,P.attr("canbuy"))}});p.append(M);M.FastBuyInitial(0)}if(j.EIdx<e){_IsLoading=false}else{_IsLoading=true;t.hide()}loadImgFun(0)}else{t.hide();if(j.FIdx==1){_IsLoading=true;p.append(Gobal.NoneHtml)}}})};this.getNextPage=function(){j.FIdx=j.FIdx+x;j.EIdx=j.EIdx+x;B()};this.initPage=function(){j.FIdx=1;j.EIdx=x;j.isCount=1;p.empty();B()}};l=new g();l.initPage();scrollForLoadData(l.getNextPage);FastClick.attach(p[0]);Gobal.scrollChangeFastNav()};var b=false;var a=b?new Date().getTime():"1701180102";Base.getScript(Gobal.Skin+"/JS/pageDialog.js?v=160308",function(){Base.getScript(Gobal.Skin+"/JS/CartComm.js?v=160911",function(){Base.getScript(Gobal.Skin+"/JS/AntiTip.js?date=170428",function(){Base.getScript(Gobal.Skin+"/JS/GoodsFastbuy.js?v="+a,function(){Base.getScript(Gobal.Skin+"/JS/fastclick.js?v=160523",c)})})})})});