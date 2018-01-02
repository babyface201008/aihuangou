@extends('mcy.layout')
@section('title','晒单分享')
@section('my-css')
<link href="/chyyg1/jiathis_share.css" rel="stylesheet" type="text/css">
<link href="/chyyg1/single.css" rel="stylesheet" type="text/css">
@endsection
@section('content')
<div class="h5-1yyg-v1">

	<section class="clearfix g-share-lucky">        
		<a class="fl u-lucky-img" href="#"><img border="1" alt="" src="{{@$mcy_user->avator_img}}"> </a>
		<div class="u-lucky-r">
			<p class="share-score">300</p>
			<p>幸运获得者：<a href="#" class="z-user blue">{{@$mcy_user->username}}</a></p>
			<p>幸运快购码：<em class="orange">{{@$yungou_shop->huode_ma}}</em></p>
			<p>本期快购：<em class="orange">{{@$shaidan->count}}</em>人次</p>
			<p>揭晓时间：<em class="arial">{{@$yungou_shop->huode_order_time}}</em></p>
		</div>                
        </section>
        <!-- 热门推荐 -->
        <section class="clearfix g-share-ct">		
        	<b class="z-aw-es z-arrow"></b>	
        	<article class="m-share-con">
        		<h2>{{@$shaidan->shaidan_title}}</h2>
        		<em class="arial">{{@$shaidan->created_at}}</em>
        		<p class="z-share-pad" id="shareContent">{{@$shaidan->shaidan_content}}</p>
        		<p><img src="{{@$shaidan->shaidan_img}}" border="0" alt=""></p>	        
        	</article>	        
        	<div class="m-share-fixed">
        		<div id="CommentNav"> 
        			<div class="m-share-btn">
        				<!-- <div id="divtest" class="u-btn-w"><a id="emHits" class="z-btn-mood z-btn-moodgray"><s></s>羡慕嫉妒恨(<em>0</em>)</a></div> -->
        				<!-- <div class="u-btn-w"><a id="btnComment" href="javascript:void(0);" class="z-btn-comment"><s></s>我要评论</a></div> -->
        				<div class="u-btn-w"><a id="btnShare" href="javascript:void(0);" class="z-btn-Share"><s></s>分享</a></div>
        			</div>
        			<!-- <div class="m-comment" style="display:none;">
        				<div class="u-comment ">
        					<textarea name="comment" id="comment" rows="3" class="z-comment-txt" placeholder="编写优质评论,审核通过既可以获得随机福分"></textarea>
        				</div>
        				<div class="u-Btn">
        					<div class="u-Btn-li"><a id="btnCancel" href="javascript:;" class="z-CloseBtn">取 消</a></div>
        					<div class="u-Btn-li"><a id="btnPublish" href="javascript:;" class="z-DefineBtn">发表评论</a></div>
        				</div>
        			</div> -->
        			<!-- <div class="m-shareT-round"></div> -->
        		</div>
        		<!-- <div id="fillDiv" style="display:none;"></div> -->
        	</div>        
        	<!-- <article class="m-share-comment m-round">
        		<h3>共<span id="ReplyCount" class="z-user orange">0</span>条评论</h3>
        		<ul id="replyList">
        		</ul>
        	</article> -->
        </section>

        <style>
#pageDialogBG{-webkit-border-radius:5px; width:255px;height:45px;color:#fff;font-size:16px;text-align:center;line-height:45px;}
#jiathis_weixin_modal {width: 300px !important;margin: -200px 0 0 -151px !important;}
#toWeChat {display: none;position: fixed;width: 100%;height: 100%;background: rgba(0,0,0,.79);top: 0;left: 0;}
#toWeChat img:first-of-type {width: 8rem;height: auto;margin: 1rem 0 0 calc(100% - 10rem);}
#toWeChat p {color: #dc332d;font-size: 1.5rem;text-align: center;padding: 1rem;}
#toWeChat img:last-of-type {width: 159px;height: auto;margin: 2rem calc(50% - 4rem) 0;}
</style>
<div id="pageDialogBG" class="pageDialogBG">
<div class="Prompt"></div>
</div>
<div id="pageDialog" class="pageDialog" style="width:300px; height:100px; position: fixed; display: none;">
	<div class="clearfix m-round f-share-tips"><div class="f-share-tit">请选择以下方式分享</div>
	<a id="btnMsgCancel" href="javascript:void(0)" class="f-share-Close"></a>
	<ul id="shareType" class="f-share-li">
		<li><a href="javascript:void(0);"><b class="z-weixin"><s></s></b><em>朋友圈</em></a></li>
		<!-- <li><a href="javascript:void(0);"><b class="z-cqq"><s></s></b><em>QQ好友</em></a></li> -->
		<!-- <li><a href="javascript:void(0);"><b class="z-sina"><s></s></b><em>新浪微博</em></a></li> -->
	</ul>
	<div id="toWeChat">
		<img class="Img" src="/chyyg1/toWC_01.png">
		<p style="color: #dc332d;font-size: 1.5rem;text-align: center;padding: 1rem;">点击右上角，将晒单分享给<br>微信朋友或朋友圈</p>
		<img src="/chyyg1/toWC_02.png">
	</div>
	<!-- JiaThis Button BEGIN -->
	<div class="jiathis_style" style="display:none;">
		<a class="jiathis_button_weixin" title="分享到微信"><span class="jiathis_txt jtico jtico_weixin"></span></a>
		<a class="jiathis_button_cqq" title="分享到QQ好友"><span class="jiathis_txt jtico jtico_cqq"></span></a>
		<a class="jiathis_button_tsina" title="分享到微博"><span class="jiathis_txt jtico jtico_tsina"></span></a>
	</div>
	<!-- JiaThis Button END -->
	</div> 
</div>
@endsection

@section('my-js')
<script>
	//分享
	$("#btnShare").click(function(){
		var w=($(window).width()-300)/2,
			h=($(window).height()-100)/2;
		$("#pageDialog").css({top:h,left:w});
		$("#pageDialog").show();
	});
	$("#btnMsgCancel").click(function(){
		$("#pageDialog").hide();
	});
	$("#shareType li:not(:first-child)").click(function(){
		var n=$(this).index();
		$(".jiathis_style a").eq(n).click();
	});
    $("#shareType li:first-child").click(function(){
        $("#toWeChat").show();
    });
    $("#toWeChat").click(function () {
        $(this).hide();
        $("#pageDialog").hide();
	});
</script>
<script type="text/javascript" src="/chyyg1/jia.js" charset="utf-8"></script>
<script type="text/javascript" src="/chyyg1/plugin.client.js" charset="utf-8"></script>
@endsection