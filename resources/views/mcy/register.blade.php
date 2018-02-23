@extends('mcy.layout')
@section('title',$site->site_name)
@section('my-css')
	<link href="/chyyg1/login.css" rel="stylesheet" type="text/css" />

@endsection
@section('content')
	<!-- 此段必须要引入 -->
	<div id="_umfp" style="display:inline;width:1px;height:1px;overflow:hidden"></div>
	<!-- 引入结束 -->
	<div class="h5-1yyg-v1" id="content">
		<section>
			<div class="registerCon">
				<ul>
					<li class="accAndPwd">
						<dl><input id="userMobile" type="tel" placeholder="请输入手机号" class="lEmail"><s class="rs4"></s></dl>
						<dl><input type="password" id="txtPassword" placeholder="请输入密码" class="lPwd" style="border-bottom-color:#eee;border-radius:inherit;"><s class="rs3"></s></dl>
						<input type="hidden" value="{!! csrf_token() !!}" id="_token">
						<dl style="position:relative;"><input type="text" id="txtVerify" placeholder="请输入验证码" class="lPwd"><s class="rs1"></s><a class="diy-sm" id="btnCode">获取验证码</a></dl>


						<div id="embed-captcha"></div>
						{{--<p id="wait" class="show">正在加载验证码......</p>
						<p id="notice" class="hide">请先完成验证</p>--}}
					</li>

					<li><a id="btnNext" class="nextBtn  colorBtn">注册</a></li>

					<li style="text-align:left;"><span id="isCheck"><em></em>我已阅读并同意</span><a href="/terms">{{$site->site_name}}用户服务协议</a></li>
				</ul>
			</div>
		</section>
		<div style="height:45px;"></div>
@endsection
@section('my-js')
<script src="/chyyg1/RegisterFun.js" language="javascript" type="text/javascript"></script>

@endsection