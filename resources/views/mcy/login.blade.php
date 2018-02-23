@extends('mcy.layout')
@section('title',$site->site_name)
@section('my-css')
	<link href="/chyyg1/login.css" rel="stylesheet" type="text/css" />

@endsection
@section('content')
	<div class="h5-1yyg-v1" id="content">
		<section>
			<div class="registerCon">
				<ul>
					<li class="accAndPwd">
						<dl><input id="txtAccount" type="tel" placeholder="请输入手机号" class="lEmail"><s class="rs4"></s></dl>
						<dl>
							<input type="password" id="txtPassword" class="lPwd" placeholder="请输入密码">
							<s class="rs3"></s>
							<input type="hidden" value="{!! csrf_token() !!}" id="_token">
						</dl>
					</li>
					<li><a href="javascript:void(0);" id="btnLogin" class="nextBtn colorBtn">登 录</a>
					{{--	<input name="hidLoginForward" type="hidden" id="hidLoginForward" value="http://m.0769ht.cn/mobile/home/init" /></li>
					<li>
						<a href="http://m.0769ht.cn/api/wxlogin" class="nextBtn colorBtn weixiBtn"><i></i>微信登录</a>
					</li>--}}
					<li class="rSelect" style="text-align:right;"><a href="http://m.0769ht.cn/mobile/user/password">忘记密码？</a></li>
				</ul>
				<a class="rSelecta" href="/register">10秒快速注册</a>
			</div>
		</section>

		<div style="height:45px;"></div>
@endsection
@section('my-js')

<script language="javascript" type="text/javascript"  src="/chyyg1/LoginFun.js?v=1.0"></script>

@endsection