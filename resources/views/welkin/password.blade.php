@extends('welkin.layout')
@section('title','账户密码管理')
@section('my-css')

@endsection
@section('content')
<div style="width:60%;float:left;padding:30px;">
	<div class="form-group">
		<label for="username" class="col-sm-2 control-label">账号</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="username" name="username" placeholder="{{@$user->username}}" value="{{@$user->username}}">
		</div>
	</div>
	<div class="form-group">
		<label for="password" class="col-sm-2 control-label">现密码:</label>
		<div class="col-sm-10">
			<input type="password" class="form-control" id="cpassword" name="cw" >
		</div>
	</div>
	<div class="form-group">
		<label for="password" class="col-sm-2 control-label">新密码</label>
		<div class="col-sm-10">
			<input type="password" class="form-control" id="password" name="pw1" >
		</div>
	</div>
	<div class="form-group">
		<label for="repassword" class="col-sm-2 control-label">再次输入新密码</label>
		<div class="col-sm-10">
			<input type="password" class="form-control" id="repassword" name="pw2">
		</div>
	</div> 
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="button" class="btn btn-success">提交</button>
		</div>
	</div>
</div>

@endsection

@section('my-js')
<script>
	$(".btn-success").on('click',function(){
		var cpassword = $("#cpassword").val();
		var username = $("#username").val();
		var password = $("#password").val();
		var repassword = $("#repassword").val();
		if (username == '' || password == '')
		{
			layer.msg("用户名称或密码不能为空",{icon:2,time:2000});
			return false;
		}else{}
		if (password.length < 6)
		{
			layer.msg('密码不能少于6个',{icon:2,time:2000});
			return false;
		}else{}
		if (password !== repassword)
		{
			layer.msg('两次密码不一致',{icon:2,time:2000});
			return false;
		}else{
			$.ajax({
				url : '/api/welkin/user/password/update',
				type : 'post',
				async : false,
				dataType : 'json',
				data : {
					_token : "{!! csrf_token() !!}",
					username: username,
					cpassword : hex_sha1(cpassword),
					password : hex_sha1(password),
					repassword : hex_sha1(repassword)
				},
				success: function(data) {
					console.log(data);
					if(data == null) {
						layer.msg('服务端错误', {icon:2, time:2000});
						return;
					}
					if(data.ret != 0) {
						layer.msg(data.msg, {icon:2, time:2000});
						return;
					}
					layer.msg(data.msg,{icon:1,time:2000});
					setTimeout(function(){
						location.reload();
					},500);

				},
				error: function(xhr, ret, error) {
					console.log(xhr);
					console.log(ret);
					console.log(error);
					layer.msg('ajax error', {icon:2, time:2000});
				},
				beforeSend: function(xhr){
					layer.load(0, {shade: false});
				},
				complete: function(){
					layer.closeAll('loading');
				},
			});
		}
	});

</script>
@endsection