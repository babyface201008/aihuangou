$(function(){var a=function(){var i=20;var j=null;var h=null;var g=null;var n=0;var m=$("#hidShowData").val();var v=$("#divConsumption");var B=$("#divRechage");var d=$("#divTransfer");var e=v.find("div.loading");var k=B.find("div.loading");var l=d.find("div.loading");var z=false,x=false,y=false;var r=v.find("dl");var u=B.find("dl");var A=d.find("dl");var b=false,c=false,p=false;$("#divNav").find("a").each(function(E,D){$(this).click(function(){$(this).addClass("z-checked").siblings().removeClass("z-checked");n=E;if(E==0){v.show();B.hide();d.hide();h.initPage()}else{if(E==1){v.hide();B.show();d.hide();j.initPage()}else{v.hide();B.hide();d.show();g.initPage()}}})});var w=function(){var F=0;var D={FIdx:1,EIdx:i,isCount:1};var E=function(){return"FIdx="+D.FIdx+"&EIdx="+D.EIdx+"&isCount="+D.isCount};var G=function(){if(b){return}b=true;GetJPData("","getUserConsumption",E(),function(L){if(L.code==0){var J="";if(D.isCount==1){D.isCount=0;F=L.count}var K=L.listItems;var I=K.length;for(var H=0;H<I;H++){J+="<dd><span>"+K[H].logTime+"</span><span>￥"+K[H].logMoney+"</span><span>"+(!!K[H].logRemark?K[H].logRemark:"--")+"</span></dd>"}r.append(J);if(D.EIdx<F){b=false}else{if(F>0){v.append(Gobal.LookForPC)}e.hide()}}else{if(L.code==10){location.reload()}else{if(L.code==-1){e.hide();if(D.FIdx==1){r.html(Gobal.NoneHtmlEx(L.tips))}}else{e.hide();r.html(Gobal.ErrorHtml(L.code))}}}_IsLoading=false})};this.initPage=function(){if(!z){z=true;D.FIdx=1;D.EIdx=i;D.isCount=1;G()}};this.getNextPage=function(){D.FIdx+=i;D.EIdx+=i;G()}};var t=function(){var F=0;var D={FIdx:1,EIdx:i,isCount:1};var E=function(){return"FIdx="+D.FIdx+"&EIdx="+D.EIdx+"&isCount="+D.isCount};var G=function(){if(c){return}c=true;GetJPData("","getUserRecharge",E(),function(L){if(L.code==0){var J="";if(D.isCount==1){F=L.count;D.isCount=0}var K=L.listItems;var I=K.length;for(var H=0;H<I;H++){J+="<dd><span>"+K[H].logTime+"</span><span>￥"+K[H].logMoney+"</span><span>"+K[H].typeName+"</span></dd>"}u.append(J);if(D.EIdx<F){c=false}else{if(F>0){B.append(Gobal.LookForPC)}k.hide()}}else{if(L.code==10){location.reload()}else{if(L.code==-1){k.hide();if(D.FIdx==1){u.html(Gobal.NoneHtmlEx(L.tips))}}else{k.hide();u.html(Gobal.ErrorHtml(L.code))}}}_IsLoading=false})};this.initPage=function(){if(!x){x=true;D.FIdx=1;D.EIdx=i;D.isCount=1;G()}};this.getNextPage=function(){D.FIdx+=i;D.EIdx+=i;G()}};var s=function(){var F=0;var D={FIdx:1,EIdx:i,isCount:1};var E=function(){return"FIdx="+D.FIdx+"&EIdx="+D.EIdx+"&isCount="+D.isCount};var G=function(){if(p){return}p=true;GetJPData("","getTransferList",E(),function(L){if(L.code==0){var J="";if(D.isCount==1){F=L.count;D.isCount=0}var K=L.listItems;var I=K.length;for(var H=0;H<I;H++){J+="<dd><span>"+K[H].applyTime+"</span>";if(K[H].transWay=="0"){J+='<span class="orange">-￥'+CastMoney(K[H].transMoney)+"</span>"}else{J+='<span class="green">+￥'+CastMoney(K[H].transMoney)+"</span>"}var M="";switch(parseInt(K[H].transState)){case 1:M="待付款";break;case 2:M="转账成功";break;case -1:M="已取消";break;case -2:M="未付款，已过期";break}J+="<span>"+K[H].userName+"<br />["+M+"]</span>";J+="</dd>"}A.append(J);if(D.EIdx<F){p=false}else{if(F>0){d.append(Gobal.LookForPC)}l.hide()}}else{if(L.code==10){location.reload()}else{if(L.code==-1){l.hide();if(D.FIdx==1){A.html(Gobal.NoneHtmlEx(L.tips))}}else{l.hide();A.html(Gobal.ErrorHtml(L.code))}}}_IsLoading=false})};this.initPage=function(){if(!y){y=true;D.FIdx=1;D.EIdx=i;D.isCount=1;G()}};this.getNextPage=function(){D.FIdx+=i;D.EIdx+=i;G()}};h=new w();j=new t();g=new s();if(m==0){h.initPage()}else{if(m==1){$("#divNav").find("a").eq(1).click()}else{if(m==2){$("#divNav").find("a").eq(2).click()}}}scrollForLoadData(function(){if(n==0){if(!b){h.getNextPage()}}else{if(n==1){if(!c){j.getNextPage()}}else{if(!p){g.getNextPage()}}}});var o=$("#hidHasMobile").val()=="1";var q=$("#hidHasPaypwd").val()=="1";var f=$("#hidHasMoney").val()=="1";var C=$("div.weixin-mask");$("#btnTransfer").click(function(){var D=function(G){$("body").attr("style","overflow:hidden;");var F=$(G);$("body").append(F).find("#closeDiag").click(function(){$("div.acc-pop").remove();C.hide();$("body").attr("style","");IsMasked=false});F.css({top:($(window).height()-F.height()-64)/2,left:($(window).width()-F.width()-32)/2}).show();C.css("height",$(document).height()>$(window).height()?$(document).height():$(window).height()).show();IsMasked=true};if(!f){var E='<div class="acc-pop"><h3 class="gray6">您当前账户没有余额</h3><h6 class="gray9">请先充值，再进行转账操作</h6><a id="okDiag" href="recharge.do" class="orangeBtn">立即充值</a><a id="closeDiag" href="javascript:;" class="box-close z-set"></a></div>';D(E)}else{if(!o){var E='<div class="acc-pop"><h3 class="gray6">需要验证手机才能进行转账</h3><h6 class="gray9">请先验证手机再进行转账操作</h6><a id="okDiag" href="mobilebind.do?forward='+escape(location.href)+'" class="orangeBtn">立即验证</a><a id="closeDiag" href="javascript:;" class="box-close z-set"></a></div>';D(E)}else{if(!q){var E='<div class="acc-pop"><h3 class="gray6">需要设置支付密码才能进行转账</h3><h6 class="gray9">请先设置支付密码再进行转账操作</h6><a id="okDiag" href="PayPwdCheck.do?forward='+escape(location.href)+'" class="orangeBtn">立即设置</a><a id="closeDiag" href="javascript:;" class="box-close z-set"></a></div>';D(E)}else{location.href="Transfer.do"}}}})};a()});