@extends('mcy.layout')
@section('title','购物车')
@section('my-css')
<link href="{{Request::root()}}/chyyg1/goods.css" rel="stylesheet" type="text/css" />
<link href="/chyyg1/comm.css?v=20170925" rel="stylesheet" type="text/css">
<link href="/chyyg1/cartList.css" rel="stylesheet" type="text/css">
<link href="/chyyg1/goods.css" rel="stylesheet" type="text/css">
<style>
	body {
		background-color: white;
	}
	.recharge-tip
	{
		margin: 0;
		width: 100%;
		height: auto;
		color:#fff;
		background: #dc332d;
		padding: 20px 0;
		position: relative;
		overflow: hidden;
	}
	.recharge-tip > p {
		width: 80%;
		margin: 0 auto;
		font-size: 16px;
		text-align: left;
		-webkit-touch-callout: none;
		-webkit-user-select: none;
		-khtml-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
		cursor: default;
	}

	/*购物车一键更改数量/清空购物车按钮*/
	#all {
		bottom: 108px;
		padding: 6px 6px 6px 10px;
		box-sizing: border-box;
		border-top: 1px solid #dedede;
		border-bottom: 1px solid #dedede;
		background: #FFF;
	}

	#all input {
		float: left;
		display: block;
		height: 35px;
		box-sizing: border-box;
		padding: 5px;
		border-radius: 5px;
	}
	#all dd:first-child {
		width: 52%;
		float: left;
	}
	#all dd:first-child p {
		float: left;
		display: block;
		width: 35%;
		height: 35px;
		line-height: 35px;
		text-align: center;
		font-size: 15px;
		letter-spacing: 5px;
	}
	#all dd:last-child {
		width: 46.5%;
		float: right;
	}
	#allNum + label {
		float: left;
		display: block;
		height: 35px;
		line-height: 25px;
		box-sizing: border-box;
		padding: 5px;
		border-radius: 5px;
		width: 60%;
		color: #dc332d;
		border: 1px solid #dc332d;
		margin-right: 3px;
		font-size: 16px;
		font-weight: 400;
		cursor: pointer;
	}
	#allNum + label:after {
		content: '\039E\039E\039E';
		display: block;
		position: absolute;
		width: 25px;
		height: 15px;
		top: 15px;
		left: 23%;
		color: #CCC;
		border: 1px solid #CCC;
		line-height: 15px;
		font-size: 12px;
        text-align: center;
	}
	#addMore, #clearAll {
		background: #FFF;
		font-size: 16px;
		letter-spacing: 2px;
	}
	#clearAll {
		width: 30%;
		color: #dc332d;
		border: 1px solid #dc332d;
	}
	#addMore {
		width: 66%;
		margin-right: 4%;
		color: #ffb320;
		border: 1px solid #FDA700;
	}
	/*自定义键盘*/
	#keyboard {
		display: none;
		position: absolute;
		width: 80%;
		left: 10px;
		bottom: 55px;
		background: #FFF;
		opacity: .85;
	}
	#keyboard, #keyboard * {
		margin: 0;
		padding: 0;
	}
	#keyboard:after {
		position: absolute;
		content: ' ';
		display: block;
		width: 1rem;
		height: 1rem;
		background: #000;
		transform: rotate(-45deg);
		left: calc((100% / 3) / 2 - 0.5rem);
		bottom: -.5rem;
		z-index: -1;
	}
	#keyboard ul {
		width: 100%;
		text-align: center;
		border-radius: 5px;
		background: #000;
	}
	#keyboard li {
		display: block;
		float: left;
		width: calc(100% / 3);
		height: 3rem;
		border-bottom: 1px solid #F2F2F2;
		color: #F2F2F2;
		font-weight: 400;
		font-size: 1.3rem;
		line-height: 3rem;
		background: transparent;
		list-style: none;
		box-sizing: border-box;
		cursor: pointer;
		-moz-user-select: none; /*不允许数字被选中*/
		-webkit-user-select: none;
	}
	#keyboard li:nth-child(12) {
		background: #dc332d;
	}
	#keyboard li:active { /*点击时的背景反馈*/
		background: #dc332d;
		-webkit-tap-highlight-color: rgba(0,0,0,0);
	}
	#keyboard ul li:not(:nth-child(3n)) {
		border-right: 1px solid #F2F2F2;
	}
	.clear {
		width: 100%;
		height: 0;
		overflow: hidden;
		clear: both;
	}
	/*end*/

	.haveNot{
		padding-top: 40px;
	}
	.loading-cartlist-title {
		font-size: 150%;
		text-align: center;
	}
	.z-del {
		background: url(/chyyg1/setIcon.png) ;
		background-size: 80px auto;
	}
	.zhiding_w {
		width: 45px;
	    height: 28px;
	    border-radius: 3px;
	    text-align: center;
	    display: inline-block;
	    color: #fff;
	    background: #dc332d;
	    line-height: 28px;
	    font-size: 9px;
	    margin: 0px 13px;
	    border: 1px solid #ccc;
	    border-radius: 5px;
	}
	.loading-cartlist-btn {
	    height: 44px;
	    line-height: 44px;
	    background-color: #dc332d;
	    color: #FFF;
	    display: block;
	    text-align: center;
	    border-radius: 5px;
	    font-size: 16px;
	    letter-spacing: 10px;
	}
	.loading-cartlist-btn-div {
		text-align: center;
	    width: 100%;
	    display: block;
	}
	.loading-cartlist-img{
		width: 100%;
		margin: 10% auto 0 auto;
		text-align: center;
		color: #bbb;
		font-size: 14px;
	}
	.loading-cartlist-img img{
		width: 120px;
		opacity: 0.1;
	}
	.loading-cartlist-img p {
		margin-top: 40px;
	}
</style>
@endsection
@section('content')
<section class="clearfix g-Cart">
	<article class="clearfix  g-Cart-list">
		<ul id="cartBody">
			@if($cartlists)
				@foreach($cartlists as $cartlist)
				<li>
					<a class="fl u-Cart-img " href="{{Request::root()}}/product?product_id={{$cartlist['yungou_shop']->product_id}}">
						<img src="{{@$cartlist['product']->product_img}}" src2="{{@$cartlist['product']->product_img}}" border="0" alt=""/>
					</a>
					<div class="u-Cart-r">
						<input type="hidden" name="cartMoney" value="1">
						<p class="z-Cart-tt">
							<a href="{{Request::root()}}/product?product_id={{$cartlist['yungou_shop']->product_id}}" class="gray3">
								{{@$cartlist['yungou_shop']->product_name}}						
							</a>
						</p>
						<ins class="z-promo gray9">
							剩余<em class="arial">{{@$cartlist['yungou_shop']->shenyurenshu}}</em>人次
						</ins>
						<p class="f-Cart-Other">
							<a class="fr z-del product_del " n=0 name="delLink" qishu="{{@$cartlist['yungou_shop']->qishu}}"  pid="{{$cartlist['yungou_shop']->product_id}}" ></a><!--删除按钮-->
							<a href="javascript:;" class="fl z-jian  product_jian" qishu="{{@$cartlist['yungou_shop']->qishu}}" n="1" pid="{{@$cartlist['yungou_shop']->product_id}}" >-</a>
							<input id="txtNum{{$cartlist['yungou_shop']->product_id}}" name="num" type="number" maxlength="7"  value="{{@$cartlist['number']}}" qishu="{{@$cartlist['yungou_shop']->qishu}}"  pid="{{$cartlist['yungou_shop']->product_id}}" class="fl z-amount product_number" />
							<a href="javascript:;" class="fl z-jia product_jia" qishu="{{@$cartlist['yungou_shop']->qishu}}" n="1" pid="{{$cartlist['yungou_shop']->product_id}}" >+</a>
							{{--<a href="javascript:;" class="fl z-queding zhiding_w" qishu="{{@$cartlist['yungou_shop']->qishu}}"  pid="{{$cartlist['yungou_shop']->product_id}}" >确定</a>--}}
						</p>
						<p class="zhuijia" data-id="{{$cartlist['yungou_shop']->product_id}}">
							<span  class="zhuijia1"  qishu="{{@$cartlist['yungou_shop']->qishu}}" n="20" pid="{{$cartlist['yungou_shop']->product_id}}" data-value="20">20</span>
							<span  class="zhuijia1"  qishu="{{@$cartlist['yungou_shop']->qishu}}" n="50" pid="{{$cartlist['yungou_shop']->product_id}}" data-value="50">50</span>
							<span  class="zhuijia1"  qishu="{{@$cartlist['yungou_shop']->qishu}}" n="100" pid="{{$cartlist['yungou_shop']->product_id}}" data-value="100">100</span>
							<span  class="zhuijia1"  qishu="{{@$cartlist['yungou_shop']->qishu}}" n="{{@$cartlist['yungou_shop']->shenyurenshu}}" pid="{{$cartlist['yungou_shop']->product_id}}" data-value="{{@$cartlist->yungou_shop->shenyurenshu}}">全部</span>
						</p>
					</div>
				</li>
				@endforeach
			@else
			<div class="loading-cartlist">

				<div class="loading-cartlist-img">
					<img src="/chyyg1/cart.png" alt="加载中">

					<p>您的购物车空空的</p>
					<p><a href="/glists" class="loading-cartlist-btn">去逛逛</a></p>
				</div>


			</div>
			@endif
		</ul>
	</article>
</section>

<div id="divBtmMoney" class="g-Total-bt g-car-new">
	<dl>
		<dt class="gray6">
			<p class="money-total">合计：&nbsp;<em class="orange"><span class="all_price">{{@$all_price}}</span>&nbsp;元</em></p>
			<p class="pro-total">总共&nbsp;<em><span class="all_count">{{@$all_count}}</span>&nbsp;</em>件商品</p>
		</dt>
		<dd>
			<a href="javascript:;" id="a_payment" class="w_account">&nbsp;去结算</a>
		</dd>
	</dl>
</div>
@endsection

@section('my-js')
<script>
	function check_number ()
	{
		var product_number = $(".product_number");
		product_number.each(function(key,value){
			var n = $(value).val();
			console.log(n);
			if (n == 1)
			{
				$(value).prev(".product_jian").addClass("z-jiandis");
			}else{
				$(value).prev(".product_jian").removeClass("z-jiandis");
			}
		});
	}
	check_number(); 
</script>
<script type="text/javascript">
    $(".f_car  > a").addClass("hover");
</script>
@endsection