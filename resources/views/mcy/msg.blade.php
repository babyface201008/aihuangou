@extends('mcy.layout')
@section('title','')
@section('my-css')
 <style type="text/css">
 	body {
 		background-color: white;
 	}
 	.msg {
 		text-align: center;
 		margin: auto;
 	}
 	.welkin_icon i{
 		margin-top: 20%;
 		font-size: 100px;
 	}
 	.welkin_msg {
 		padding: 10px 0;
 		font-size: 150%;
 	}
 	.btn-mobile {
 		display: block;
 		width: 45%;
 		height: 40px;
 		border-radius: 5px;
 		background: #dc332d;
 		border: 1px solid #dc332d;
 		margin: auto;
 		color: white;
 		line-height: 40px;
 		font-size: 16px;
 	}
 </style>
@endsection
@section('content')
<div class="msg">
	<div class="welkin_icon">
	{!!@$icon!!}
	@if ($type == 1)
	<i class="weui-icon-success"></i>
	@elseif ($type == 2)
	<i class="weui-icon-warn"></i>
	@elseif ($type == 3)
	<i class="weui-icon-warn"></i>
	@elseif ($type == 5)
	<i class="weui-icon-success"></i>
	@endif
</div>
<div class="welkin_msg">
	{!!@$msg!!}
</div>
@if ($type == 3)
	<a href="/mcy/user/add/mobile" class="btn btn-mobile">点击填写手机!</a>
@endif

</div>
@endsection
@section('my-js')
	@if ($type == 1 || $type==5)
		<script>
            setTimeout(function(){
                location.href = '/mcy/user';
            },1000);
		</script>
	@endif

@endsection