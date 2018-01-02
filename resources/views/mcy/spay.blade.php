@extends('mcy.layout')
@section('title','支付')
@section('my-css')
 
@endsection
@section('content')
{{$url}}
<a href="{{$url}}" class="jump">跳转</a>
@endsection
@section('my-js')
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
	location.href = "{{$url}}";
	$(".jump").click();
</script>
@endsection