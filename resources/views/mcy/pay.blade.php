@extends('mcy.layout')
@section('title','支付')
@section('my-css')
 
@endsection
@section('content')
正在调起支付接口
@endsection
@section('my-js')
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
	function jsApiCall(data)
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			{!!$params!!},
			function(res){
				if (res.err_msg == 'get_brand_wcpay_request:cancel')
				{
					layer.msg("您已取消");
					setTimeout(function(){
						location.href = 'http://yyg2.chkg99.com' + '/mcy/user';
					},500);
				}
				if (res.err_msg == 'get_brand_wcpay_request:ok')
				{
					layer.msg('支付成功');
					setTimeout(function(){
						location.href = 'http://yyg2.chkg99.com' + '/mcy/user';
					},500);
				}else{
					layer.msg('支付失败');
					setTimeout(function(){
						location.href = 'http://yyg2.chkg99.com' + '/mcy/user';
					},500)
				}
			}
			);
	}

	function callpay(data)
	{
		if (typeof WeixinJSBridge == "undefined"){
			if( document.addEventListener ){
				document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
			}else if (document.attachEvent){
				document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
				document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
			}
		}else{
			jsApiCall(data);
		}
	}
	callpay();
</script>
@endsection