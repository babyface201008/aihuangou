var ReplyFun=null;$(function(){var e="postAdmire";var c=$("#hidPostID").val();var b=$("#replyList");var f=$("div.loading");var a=$("#hidBindMobile").val();var d=function(){var p={empty:"说点什么吧",cmtErr:"评论内容不能少于3个字！",contentErr:"评论内容不能多余150个字！",subFail:"提交失败！",notMine:"亲，不能对自已回复哦！",notrade:"亲，参与过云购就可以回复啦！",tooFast:"亲，回复太频繁，请稍候！",singleOver:"亲，说得太多啦，看看别的吧！",totalOver:"亲，说得太多啦，明天再来吧！",mobileErr:"亲，需绑定手机才能发表评论哦！"};var r=function(G){$.PageDialog.ok(G)};var F=function(G){$.PageDialog.fail(G)};var z=function(G){var H=G.replace(/</ig,"&lt;").replace(/>/ig,"&gt;").replace(/\[(\/)?(b|br)\]/ig,"<$1$2>").replace(/\[s:(\d+)\]/ig,'<img src="https://skin.1yyg.net/Images/Emoticons/$1.gif" alt="" />').replace(/\[url=([^\]]*)\]([^\[]+)\[\/url\]/ig,'<a href="$1" target="_blank" class="blue">$2</a>').replace(/\s{2}/ig,"&nbsp;&nbsp;");return H};var o=0;var s=function(){var I=false;var L=false;var K=1;var G=10;var H={PostID:c,FIdx:K,EIdx:G,IsCount:1};var M=function(){var N="";N+="PostID="+H.PostID;N+="&fidx="+H.FIdx;N+="&eidx="+H.EIdx;N+="&iscount="+H.IsCount;return N};var J=function(){var N=function(O){if(O.code==0){if(H.IsCount==1){H.IsCount=0;o=O.count}var R=O.Rows;var S=R.length;var P="";for(var Q=0;Q<S;Q++){P+='<div class="mess-list"><a href="/'+Gobal.SiteVer+"/userpage/"+R[Q].userWeb+'" class="photo"><img src="https://img.1yyg.net/userface/'+R[Q].userPhoto+'" alt="头像"/></a><p class="name"><a href="/'+Gobal.SiteVer+"/userpage/"+R[Q].userWeb+'" class="blue">'+R[Q].replyUserName+'</a><span class="fr time">'+R[Q].replyTime+"</span></p><p>"+z(R[Q].replyContent)+"</p></div>"}b.append(P);if(o>H.EIdx){_IsLoading=false}else{_IsLoading=true;f.hide()}}else{if(O.code==1){if(H.FIdx==1){b.html('<div class="null-mess">沙发耶，还不快坐？</div>');_IsLoading=true;f.hide()}}else{b.html('<div class="null-mess">获取失败，请刷新页面重试['+O.code+"]！</div>");_IsLoading=true;f.hide()}}};GetJPData(Gobal.WxDomain,"GetReplyList",M(),N)};this.getInitPage=function(){J()};this.getNextPage=function(){H.FIdx+=G;H.EIdx+=G;J()}};ReplyFun=new s();ReplyFun.getInitPage();scrollForLoadData(ReplyFun.getNextPage);var x=parseInt($("#hidHits").val());var y=parseInt($("#hidReply").val());$("#liZan").find("em").html(x);$("#liReply").find("em").html(y);var k="postHits";var u=$.cookie(k);if(u==null||u==""){u=","}var q=$("#liZan");var C=function(){var G=$('<b class="gray9">已羡慕</b>');q.append(G);G.fadeTo(2000,0,function(){G.remove()})};var w=function(){if(c<=0){return}GetJPData("","InsertPostHits","postid="+c,function(H){if(H.code==0){u=u+c+",";$.cookie(k,u,{expires:1,path:"/"});G()}});var G=function(){var M=q.find("img");var H=M.width();var I=M.height();var L=q.find("span");var K=-2;var N=-1;M.hide();var J=$('<img style="display: none" src='+M.attr("src")+">").prependTo(L);J.css({position:"absolute",left:K+"px",top:N+"px",width:H,height:I,"z-index":9999}).show();J.animate({width:H*2,height:I*2,left:K-H/2,top:N-I/2,opacity:0},700,function(){J.remove();q.find("em").html(x+1);q.addClass("current")})}};if(u.indexOf(","+c+",")>=0){q.bind("click",function(){}).addClass("current")}else{q.bind("click",function(){if(u.indexOf(","+c+",")>=0){return}w()})}var D=function(){var H=$("#ulRec"),O=$("#hdGoodsID").val();if(O==0){return}var K=0,L=0,G=0,P=0;var M=function(S){K=parseInt(S.codeSales);L=parseInt(S.codeQuantity);G=parseInt(L-K);P=parseInt(K*100)/L;P=K>0&&P<1?1:P;var Q='<li class="thin-bor-right" id="'+S.goodsID+'">	<a href="javascript:;">		<img src="https://img.1yyg.net/GoodsPic/pic-200-200/'+S.goodsPic+'">		<p class="goods-title gray6">(第'+S.codePeriod+"云)"+S.goodsSName+' </p>		<p class="goods-price gray9">价值：￥<span>'+S.codePrice+'.00</span></p>	</a>	<div class="Progress-bar">		<p class="u-progress">			<span class="pgbar" style="width: '+P+'%;">				<span class="pging"></span>			</span>		</p>	</div></li>';var R=$(Q);R.click(function(){location.href="/"+Gobal.SiteVer+"/products/"+$(this).attr("id")+".do"});H.append(R)};var N=[];var I=function(Q){GetJPData(Gobal.WxDomain,"GetPopularGoods","num=8",function(W){var U=W.code;if(U==0){var V=W.listItems;var R=V.length,T=null;for(var S=0;S<R;S++){T=V[S];if(Q==8){M(T)}else{if(N.indexOf(T.goodsID)==-1){M(T);Q--;if(Q==0){break}continue}}}}})};var J=function(W){var T=W.code;if(T==0){var V=W.listItems;var Q=V.length;var S;for(var R=0;R<Q;R++){S=V[R];M(S);N.push(S.goodsID)}if(Q<8){var U=8-Q;I(U)}}else{if(T==-1){I(8)}}};GetJPData(Gobal.WxDomain,"GetHotSortGoodsIDByGID","goodsID="+O,J)};D();var A=$("#comment");A.html(p.empty);var g=A.val();var v=false;var h=function(){var G=150;var I=A.val();var H=I.length;if(I==p.empty){H=0}if(I.length>G){F("评论内容已达上限！");A.val(I.substring(0,G))}$("#p_size").html(H+"/"+G);if(v){setTimeout(h,200)}};A.bind("focus",function(H){stopBubble(H);v=true;var G=$(this).val();if(G==g){$(this).val("").attr("style","color:#666666")}h()}).bind("blur",function(H){stopBubble(H);v=false;var G=$(this).val();if(G==""){$(this).val(p.empty).attr("style","color:#bbbbbb")}});var t=function(){var G=self.location.toString();location.href=Gobal.WxDomain+"/"+Gobal.SiteVer+"/passport/login.do?forward="+encodeURIComponent(G);return false};var m=false;var n=function(){if(m){return}var G=A.val();if(G==g||G==p.empty){F(p.empty);A.focus();return}else{if(G.length<3){F(p.cmtErr);return}else{if(G.length>150){F(p.contentErr);return}}}m=true;$.post(Gobal.WxDomain+"/JPData",{action:"InsertPostReply",postid:c,originalContent:G},function(H,J){if(H.code==0){r("评论成功");$("#comment").val("");y++;o++;$("#emReplyNum").html(y);$("#liReply").find("em").html(y);$("div.null-mess").hide();var I='<div class="mess-list"><a href="/'+Gobal.SiteVer+"/userpage/"+H.userWeb+'" class="photo"><img src="https://img.1yyg.net/userface/'+H.userPhoto+'" alt="头像"/></a><p class="name"><a href="/'+Gobal.SiteVer+"/userpage/"+H.userWeb+'" class="blue">'+H.replyUserName+'</a><span class="fr time">'+H.replyTime+"</span></p><p>"+G+"</p></div>";b.prepend(I);setTimeout(function(){$("#p_size").html("0/150");$("div.s_comments").hide().prevAll("div").show();$("html,body").animate({scrollTop:j},0)},1000)}else{if(H.code==10){location.href=Gobal.WxDomain+"/"+Gobal.SiteVer+"/passport/login.do?forward="+self.location.toString()}else{if(H.code==-201){F(p.mobileErr)}else{if(H.code==-358){F(p.singleOver)}else{if(H.code==-359){F(p.totalOver)}else{if(H.code==-353){F(H.tips)}else{if(H.code==-354){F(p.notMine)}else{if(H.code==-355){F(p.notrade)}else{if(H.code==-303||H.code==-356){F(p.tooFast)}else{if(H.code==-301){F(p.cmtErr)}else{F(p.subFail)}}}}}}}}}}m=false},"json")};var j=0;var B=function(){j=$(window).scrollTop();var J=$("#userState").val()=="1"?true:false;if(J){if(a==""){var G='<div class="clearfix m-round u-tipsEject"><div class="u-tips-txt">亲，需要绑定手机才能发表评论哦！</div><div class="u-Btn"><div class="u-Btn-li"><a href="javascript:;" id="btnMsgCancel" class="z-CloseBtn">取消</a></div><div class="u-Btn-li"><a id="btnMsgOK" href="javascript:;" class="z-DefineBtn">立即绑定</a></div></div></div>';var I=function(){var K=$("#pageDialog");K.find("a.z-DefineBtn").click(function(){location.replace("/"+Gobal.SiteVer+"/member/MobileBind.do?forward="+escape(location.href));H.close()});K.find("a.z-CloseBtn").click(function(){H.cancel()})};var H=new $.PageDialog(G,{W:300,H:126,close:true,autoClose:false,ready:I})}else{$("div.s_comments").show().prevAll("div").hide();$("#comment").focus();$("#a_cancel").bind("click",function(){$("div.s_comments").hide().prevAll("div").show();$("html,body").animate({scrollTop:j},0)});$("#a_sendok").bind("click",n)}}else{t()}};$("#liReply").bind("click",B);var i=[""+$("h1").html()+""];var l=$("p.pro").text().substring(0,30);var E=$("div.txt").find("img").eq(0).attr("src").replace("big","small");Base.getScript(Gobal.Skin+"/JS/WxShare.js?v=170329",function(){$("#liShare").bind("click",function(){if(Gobal.IsWeixin){wxShareFun({shareTitle:_ShareTitle,shareImg:E,shareLink:location.href,shareDesc:l,showMask:false});wxShowMaskFun()}else{mShareTools.InitialSettings({sTitle:i,sImg:E,sUrl:location.href,sDesc:l});mShareTools.ShowShare()}})});Base.getScript(Gobal.Skin+"/JS/Flexslider.js?v=160304",function(){var G=$("div.txt").find("img");var H='<div id="sliderBox" class="widget-sing-img" style="display:none;">';H+='<ul class="slides">';for(var I=0;I<G.length;I++){var K=$(G[I]);if(typeof(K.attr("src2"))!="undefined"){H+='<li><img name="loading" src="https://skin.1yyg.net/'+Gobal.SiteVer+'/weixin/images/loading.gif" src2="'+K.attr("src2")+'" alt="" /></li>'}else{H+='<li><img src="'+K.attr("src")+'" alt="" /></li>'}}H+="</ul>";H+="</div>";var L=$(H);$("body").append(L);var J=null;G.each(function(){$(this).bind("click",function(){L.show();$("body").attr("style","overflow:hidden;");IsMasked=true;var M=L.find("img[name='loading']");if(M.length>0){J=setInterval(function(){M.each(function(){var O=$(this);var N=O.attr("src2");if(typeof(N)!="undefined"&&N!=""){var P=$('<img src="'+N+'" alt="" />');P.load(function(){O.attr("src",N).removeAttr("src2")})}})},200)}})});L.bind("click",function(){L.hide();$("body").attr("style","");IsMasked=false;if(J!=null){clearInterval(J)}});L.flexslider({animationLoop:false}).find("li").css({"line-height":$(window).height()+"px"})})};loadImgFun(0);Base.getScript(Gobal.Skin+"/JS/pageDialog.js?v=160304",d)});