@extends('mcy.layout')
@section('title','支付')
@section('my-css')
 
@endsection
@section('content')
{{--正在调起支付接口
<form method="post" action="{{$url}}" id="myForm">
<input type="hidden" placeholder="商户支付Key" name="payKey" value="{{@$postData['payKey']}}">
<input type="hidden" placeholder="金额" name="orderPrice" value="{{@$postData['orderPrice']}}">
<input type="hidden" placeholder="商户支付订单号String" name="outTradeNo" value="{{@$postData['outTradeNo']}}">
 <input type="hidden" placeholder="产品类型" name="productType" value="{{@$postData['productType']}}">
 <input type="hidden" placeholder="下单时间" name="orderTime" value="{{@$postData['orderTime']}}">
 <input type="hidden" placeholder="支付产品名称String" name="productName" value="{{@$postData['productName']}}">
 <input type="hidden" placeholder="下单IP" name="orderIp" value="{{@$postData['orderIp']}}">
 <input type="hidden" placeholder="页面通知地址" name="returnUrl" value="{{@$postData['returnUrl']}}">
 <input type="hidden" placeholder="后台异步通知" name="notifyUrl" value="{{@$postData['notifyUrl']}}">
 <!-- <input type="hidden" placeholder="子商户支付Key" name="subPayKey" value=""> -->
 <!-- <input type="hidden" placeholder="备注" name="remark" value="{{@$postData['remark']}}"> -->
 <input type="hidden" placeholder="签名" name="sign" value="{{@$postData['sign']}}">
</form>--}}

<div style="text-align: center">


	{!! QrCode::size(300)->encoding('UTF-8')->generate($payORcode); !!}
	<p style="font-size: 16px">微信扫一扫支付</p>
</div>
@endsection
@section('my-js')


{{--<script type="text/javascript">
window.onload= function(){
   document.getElementById('myForm').submit();
}
</script>--}}
@endsection