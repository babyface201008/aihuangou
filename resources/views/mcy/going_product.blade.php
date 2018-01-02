@extends('mcy.layout')
@section('title','商品详情')
@section('my-css')
 <link href="/chyyg1/comm.css" rel="stylesheet" type="text/css">
<link href="/chyyg1/goods.css" rel="stylesheet" type="text/css">
	<style type="text/css">
		.cur {
		    margin-left: 20px;
		}
	</style>
@endsection
@section('content')
    <section class="goodsCon pCon">
	    <!-- 导航 -->
	    <div id="divPeriod" class="pNav">


	    	<div class="flex-viewport">
	    		<ul class="slides" style="display: block; width: 11207px; transition-duration: 0.4s; transform: translate3d(-111px, 0px, 0px);">
	    			<li><a href="{{Request::root()}}/product?product_id={{@$product->product_id}}">第{{@$yungou_shop->qishu + 1}}期</a><b></b></li>
	    			<!-- <li class="cur" ><a href="javascript:;">第{{@$yungou_shop->qishu}}期</a><b></b></li> -->
                    @for($i=$product->go_now_qishu - 1,$k=($product->go_now_qishu - 10),$a=1;$i > $k;$i--,$a++)
                    @if($i > 0)
                        @if ( $i == $yungou_shop->qishu)
                        <li class="cur"><a href="javascript:;">第{{$i}}期</a><b></b></li>
                        @else
                        <li><a href="{{Request::root()}}/going/product?product_id={{@$product->product_id}}&qishu={{$i}}" >第{{@$i}}期</a></li>
                        @endif
                    @endif                   
                    @endfor
                    <!-- 显示最新10期的信息  -->
	    			<!-- <li><a href="{{Request::root()}}/going/product?product_id={{@$product->product_id}}">第{{@$yungou_shop->qishu - 1}}期</a></li> -->
	    		</ul>
	    	</div>
	    </div>
	@if (@$type == 1)

        <!-- 揭晓倒计时 -->
        <div id="divLotteryTime" class="pProcess clearfix" data-id="{{@$yungou_shop->yungou_id}}" data-endtime="{{@$chazhi}}">
        	<div class="pCountdown">
        		<div class="g-snav">
        			<div class="g-snav-lst">揭晓<br>倒计时<s></s></div>
        			<div class="g-snav-lst"><b class="minute">99</b><em>分</em></div>
        			<div class="g-snav-lst"><b class="second">99</b><em>秒</em></div>
        			<div class="g-snav-lst"><b class="millisecond">99</b><em>毫秒</em></div>
        		</div>
        	</div>
        </div>
           <!-- 产品图 -->
        <div class="pPic pPicBor">
        	<div class="pPic2">
        		<div id="sliderBox" class="pImg">

        			<ul class="slides" style="display: block;">
        				<li><img src="{{$product->product_img}}"></li>
        			</ul>
        		</div>
        	</div>
        </div>

        <!-- 商品信息 -->
        <div class="pDetails pDetails-end">
        	<b>(第{{@$yungou_shop->qishu}}期){{@$product->product_name}}<span></span></b>
        	<p class="price">
        	价值：<em class="arial gray">￥{{$product->product_price}}</em>
        	</p>
        	<!-- <div class="pClosed">正在揭晓</div> -->
        	<div class="pOngoing " codeid="{{@$product->product_id}}">第<em class="arial">{{@$product->go_now_qishu}}</em>期 正在进行中……<span class="fr xyq">查看详情</span></div>
        </div>
        <!-- 参与记录，商品详细，晒单导航 -->
        <div class="joinAndGet">
        	<dl>
        		<a href="{{Request::root()}}/buyrecords/{{@$product->product_id}}/{{@$yungou_shop->qishu}}"><b class="fr z-arrow"></b>所有快购记录</a>
        		<a href="{{Request::root()}}/goodsdesc/{{@$product->product_id}}"><b class="fr z-arrow"></b>图文详情<em>（建议WIFI下使用）</em> </a>
        		<a href="{{Request::root()}}/goodspost/{{@$product->product_id}}/{{@$yungou_shop->qishu}}"><b class="fr z-arrow"></b>商品晒单</a>
        	</dl>
        	<!-- 上期获得者 -->
<!--             <ul id="prevPeriod" class="m-round" codeid="4437417" uweb="386667">
            	<li class="fl"><s></s><img src="/chyyg1/1490720004.jpg@!thumb_110_110"></li>
            	<li class="fr"><b class="z-arrow"></b></li>
            	<li class="getInfo">
            		<dd>
            			<em class="blue">亦梦亦幻</em>
            		</dd>
            		<dd>总共快购：<em class="orange arial">1</em>人次</dd>
            		<dd>幸运快购码：<em class="orange arial">10000002</em></dd>
            		<dd>揭晓时间：2017-07-06 10:39:24</dd>
            		<dd>快购时间：2017-07-06 10:36:24</dd>
            	</li>
            </ul> -->
        </div>
	@elseif(@$type == 2)
	<div class="pProcess pProcess2">
		<div class="pResults">
			<div class="pResultsL">
				<a href="/userinfo/{{@$mcy_user->mcy_user_id}}">
                    <span>{{@$mcy_user->username}}</span>
					<img src="@if($mcy_user->avator_img=='')
					{{@$site->site_m_logo}}
					@else
					{{@$mcy_user->avator_img}}
					@endif" />
				<s></s>
                </a>
			</div>
			<div class="pResultsR">
				<div class="g-snav">
					<div class="g-snav-lst">总共快购<br><dd><b class="orange">{{@$mcy_user->count}}</b><br>人次</dd></div>
					<div class="g-snav-lst">揭晓时间<br><dd class="gray9"><span>{{@$yungou_shop->show_time}}</span></dd></div>
					<div class="g-snav-lst">快购时间<br><dd class="gray9"><span>{{@$yungou_shop->huode_order_time}}</span></dd></div>
				</div>
			</div>
			<p><a href="/calresult/{{@$yungou_shop->yungou_id}}" class="fr">查看计算结果</a>幸运快购码：<b class="orange">{{@$yungou_shop->huode_ma}}</b></p>
		</div>
	</div>
	   <!-- 产品图 -->
        <div class="pPic pPicBor">
        	<div class="pPic2">
        		<div id="sliderBox" class="pImg">

        			<ul class="slides" style="display: block;">
        				<li><img src="{{$product->product_img}}"></li>
        			</ul>
        		</div>
        	</div>
        </div>

        <!-- 商品信息 -->
        <div class="pDetails pDetails-end">
        	<b>(第{{@$yungou_shop->qishu}}期){{@$product->product_name}}<span></span></b>
        	<p class="price">
        	价值：<em class="arial gray">￥{{$product->product_price}}</em>
        	</p>
        	<!-- <div class="pClosed">正在揭晓</div> -->
        	<div class="pOngoing " codeid="{{@$product->product_id}}">第<em class="arial">{{@$product->go_now_qishu}}</em>期 正在进行中……<span class="fr xyq">查看详情</span></div>
        </div>
        <!-- 参与记录，商品详细，晒单导航 -->
        <div class="joinAndGet">
        	<dl>
        		<a href="{{Request::root()}}/buyrecords/{{@$product->product_id}}/{{@$yungou_shop->qishu}}"><b class="fr z-arrow"></b>所有快购记录</a>
        		<a href="{{Request::root()}}/goodsdesc/{{@$product->product_id}}"><b class="fr z-arrow"></b>图文详情<em>（建议WIFI下使用）</em> </a>
        		<a href="{{Request::root()}}/goodspost/{{@$product->product_id}}/{{@$yungou_shop->qishu}}"><b class="fr z-arrow"></b>商品晒单</a>
        	</dl>
        	<!-- 上期获得者 -->
<!--             <ul id="prevPeriod" class="m-round" codeid="4437417" uweb="386667">
            	<li class="fl"><s></s><img src="/chyyg1/1490720004.jpg@!thumb_110_110"></li>
            	<li class="fr"><b class="z-arrow"></b></li>
            	<li class="getInfo">
            		<dd>
            			<em class="blue">亦梦亦幻</em>
            		</dd>
            		<dd>总共快购：<em class="orange arial">1</em>人次</dd>
            		<dd>幸运快购码：<em class="orange arial">10000002</em></dd>
            		<dd>揭晓时间：2017-07-06 10:39:24</dd>
            		<dd>快购时间：2017-07-06 10:36:24</dd>
            	</li>
            </ul> -->
        </div>
	<script>
	</script>
	@else
	@endif

     
    </section>
@endsection
@section('my-js')
<script src="/chyyg1/jquery190.js" language="javascript" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="/chyyg1/LotteryDetail.js"></script>
<script language="javascript" type="text/javascript" src="/chyyg1/Bottom.js"></script>
<script language="javascript" type="text/javascript" src="/chyyg1/BottomFun.js"></script>
{{--<script language="javascript" type="text/javascript" src="/chyyg1/LotteryDetailFun.js"></script>--}}
<script language="javascript" type="text/javascript" src="/chyyg1/PeriodSlider.js"></script>
<script language="javascript" type="text/javascript" src="/chyyg1/GoodsPicSlider.js"></script>
 <script>
$(function(){
  $(".blue").click(function(){
	 window.location.href="{{Request::root()}}/userindex/" + $("#prevPeriod").attr("uweb");
  });
  $(document).on('click','.xyq',function(){
  	window.location.href = '/product?product_id='+ {{@$product->product_id}};
  });
  $(".xyq").on('click',function(){
        location.href = '/product?product_id='+ {{@$product->product_id}};
  });

	// 揭晓倒计时
	var divLotteryTime = $('#divLotteryTime');
	if ( divLotteryTime.size() > 0 ) {
		var id = divLotteryTime.attr('data-id');
		var minute = divLotteryTime.find('b.minute');
		var second = divLotteryTime.find('b.second');
		var millisecond = divLotteryTime.find('b.millisecond');
		var tips = minute.parent().prev();
		var times = (new Date().getTime()) + 1000 * divLotteryTime.attr('data-endtime');
		var timer = setInterval(function(){
			var time = times - (new Date().getTime());
			if ( time < 1 ) {
				clearInterval(timer);
				tips.css('line-height', '35px').css('color','#dc332d').html('正在玩命揭晓中……');
				minute.parent().remove();
				second.parent().remove();
				millisecond.parent().remove();

				var checker = setInterval(function () {
					$.getJSON(Gobal.Webpath+"/api/getshop/lottery_huode_shop",{'oid':id},function(info){
						if ( !info.ret ) {
							clearInterval(checker);
							tips.html('揭晓成功！三秒后自动刷新...');
							setTimeout(function(){
								// location.reload();
								location.href = '/going/product?product_id='+{{@$product->product_id}}+ '&qishu='+ {{@$product->go_now_qishu}};
							},3000);
						}else{
							// location.href = '/product?product_id={{$product->product_id}}';
						}
					});
				}, 3000);
				return;
			}

			i =  parseInt((time/1000)/60);
			s =  parseInt((time/1000)%60);
			ms =  String(Math.floor(time%1000));
			ms = parseInt(ms.substr(0,2));
			if(i<10)i='0'+i;
			if(s<10)s='0'+s;
			if(ms<10)ms='0'+ms;
			minute.html(i);
			second.html(s);
			millisecond.html(ms);
		}, 41);

	}


})

</script>
@endsection