$(function(){var a=function(){var d=$("#mentionList");var e=$("#divLoading");var f=0;var h=20;var b={FIdx:1,EIdx:h,isCount:1};var g=null;var c=function(){var k=function(){return"type=2&FIdx="+b.FIdx+"&EIdx="+b.EIdx+"&isCount="+b.isCount};var i=function(n){var m="";if(n=="1"){m="等待审核"}else{if(n=="2"){m="审核通过"}else{if(n=="3"){m="审核失败"}else{if(n=="4"){m="提现成功"}else{if(n=="5"){m="提现失败"}}}}}return m};var j=function(n){var m=$(n).attr("applyID");GetJPData("","getBrokerageInfo","applyID="+m,function(p){if(p.code==0){var o='<div class="record-pop-ups gray6 clearfix"><h4>提现记录详情</h4><ul><li><span>申请时间：</span><p>'+p.data.applyTime+'</p></li><li><span>提现金额：</span><p class="orange">￥'+p.data.fetchMoney+"</p></li><li><span>提现银行：</span><p>"+p.data.bankName+"</p></li><li><span>开户支行：</span><p>"+p.data.subBank+"</p></li><li><span>银行账号：</span><p>"+p.data.bankAccount+"</p></li><li><span>开&nbsp;&nbsp;户&nbsp;人：</span><p>"+p.data.userName+"</p></li><li><span>申请状态：</span><p>"+i(p.data.applyState)+'</p></li></ul><a id="closeDiag" href="javascript:;" class="orange z-closeBtn">关闭</a></div>';$("body").attr("style","overflow:hidden;");$("#wrapper").append(o).find("#closeDiag").click(function(){$("div.record-pop-ups").remove();$("div.weixin-mask").hide();$("body").attr("style","");IsMasked=false});var q=function(){var r=$("div.record-pop-ups");if(r.length>0){var s=($(window).width()>$(window).height()?$(window).height():$(window).width())-80;r.css({width:s,top:($(window).height()-r.height()-40)/2,left:($(window).width()-s-30)/2});$("div.weixin-mask").css("height",$(document).height()>$(window).height()?$(document).height():$(window).height()).show()}};q();IsMasked=true;$(window).resize(q)}})};var l=function(){GetJPData("","getcommissionlist",k(),function(p){if(p.code==0){if(b.isCount==1){b.isCount=0;f=p.str.totalCount}var o=p.str.listItems;var r=o.length;var n="";for(var q=0;q<r;q++){n="";var t=0;if(o[q].logType2=="2"&&o[q].applyState!=""){n+="<span>"+i(o[q].applyState)+"</span>";n+="<span>详情></span>";t=1}else{if(o[q].logType2=="3"){n+="<span>退回成功</span>"}else{if(o[q].logType2=="4"){n+="<span>充值成功</span>"}else{n+="<span></span>"}}n+="<span></span>"}var u=o[q].buyTime.split(" ");var m=parseFloat(o[q].brokerage);n="<dd "+(t==1?'name="detail" applyID="'+o[q].applyID+'"':"")+"><span>"+u[0]+'</span><span class="orange">'+(m>0?"+￥":"-￥")+(m>0?m.toFixed(2):(m*-1).toFixed(2))+"</span>"+n+"</dd> ";var s=$(n);if(t==1){s.click(function(){j($(this))})}d.append(s)}if(b.EIdx<f){_IsLoading=false}else{e.hide();if(f>0){$("#wrapper").append(Gobal.LookForPC)}}}else{if(p.code==10){location.reload()}else{if(p.code==-1){e.hide();if(b.FIdx==1){d.html(Gobal.NoneHtmlEx(p.tips))}}else{e.hide();d.html(Gobal.ErrorHtml(p.code));_IsLoading=false}}}})};this.getInitPage=function(){l()};this.getNextPage=function(){b.FIdx+=h;b.EIdx+=h;l()}};g=new c();g.getInitPage();scrollForLoadData(g.getNextPage)};a()});