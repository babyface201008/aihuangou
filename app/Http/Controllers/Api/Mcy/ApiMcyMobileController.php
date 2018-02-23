<?php
namespace App\Http\Controllers\Api\Mcy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\News;
use App\Tools;
use App\Response;
use App\ApiResponse;
use App\Model\McySendSms;
use App\Model\McyUser;
use App\Tools\MyLog\WechatLog;
class ApiMcyMobileController extends Controller
{
	/**
	 * 注册发手机验证码接口
	 */
	public function apiRegisterSend(Request $request){

		$response = new ApiResponse;
		$mobile = $request->input("mobile","");

		//1.验证手机

		//格式
		if(!Tools::is_mobile($mobile)){
			return $response->reply(3,'手机格式不正确');
		}
		//是否注册过
		if (McyUser::where('mobile',$mobile)->where('is_delete',0)->count() > 0) {
			return $response->reply(1,'该手机已注册');
		}

		//2.判断手机是否在有限期内或者已经发送
		$sms = McySendSms::where('mobile',$mobile)->where('is_delete',0)->first();
		if ($sms){
			//判断是否在十分钟内

			if (time() <= strtotime($sms->created_at." + 10 mins")) {
				/* 十分钟内 */
				return $response->reply(2,'短信已经发送，十分钟内有效');
			}else{
				$sms->is_delete = 1;
				$sms->save();
			}
		}

    	/* 发送消息 */
		$sms_new = new McySendSms;
		$sms_new->created_at = date('Y-m-d H:i:s');
		$sms_new->updated_at = date('Y-m-d H:i:s');

		$result =  Tools\AliSMS::yzm($mobile);
		$result =json_decode($result);
		if (@$result->ret == 0){
			/* 发送成功 写入数据库 */
			$sms_new->code = $result->code;
			$sms_new->mobile = $mobile;
			if ($sms_new->save())
			{
				@WechatLog::info("$mobile 验证成功,验证码为：$result->code,验证时间@$sms_new->created_at");
				return $response->reply(0,'发送成功，短信十分钟内有效');
			}else{
				return $response->reply(2,'系统繁忙，请稍后验证');
			}
		}else{
			// echo "bad";
			return $response->reply(2,'系统繁忙，请稍后验证');
		}

		return $response->reply(0,'成功');

	}

	/**
	 * 更换手机接发验证码接口
	 */
	public function apiMobileSend(Request $request)
	{
		$response = new ApiResponse;
		$openid = $request->session()->get('openid');
		$mobile = intval($request->input('mobile'));
		$mcy_user = McyUser::where('is_delete',0)->where('openid',$openid)->first();
		if ($mcy_user->mobile == ''){}else{
			return $response->reply(3,'您已经通过手机验证了，无须重新验证');
		}
		$check_mobile = McyUser::where('is_delete',0)->where('is_robot',0)->where('mobile',$mobile)->first();
		/* 判断手机是否在平台注册过了 */
		if ($check_mobile)
		{
			return $response->reply(3,'该手机已经在平台注册过了，如不是本人，请联系客服');
		}else{
			/* 判断手机是否在有限期内或者已经发送 */
			$sms = McySendSms::where('mcy_user_id',$mcy_user->mcy_user_id)->where('mobile',$mobile)->where('is_delete',0)->first();
			if ($sms){
				/* 判断是否在十分钟内 */
				if ($sms->created_at <= date("Y-m-d H:i:s",strtotime($sms->created_at." + 10 mins")))
				{
					/* 十分钟内 */
					return $response->reply(2,'短信已经发送，十分钟内有效');
				}else{
					$sms->is_delete = 1;
					$sms->save();
				}
			}else{}
			 /* 发送消息 */
			 $result = json_decode(Tools::yzm($mobile));
			 if (@$result->ret == 0){
			 	/* 发送成功 写入数据库 */
			 	$sms = new McySendSms;
			 	$sms->mcy_user_id = $mcy_user->mcy_user_id;
			 	$sms->code = $result->code;
			 	$sms->mobile = $mobile;
			 	if ($sms->save())
			 	{
			 		@WechatLog::info("$mobile 验证成功,验证码为：$result->code,验证时间@$sms->created_at");
			 		return $response->reply(0,'发送成功，短信十分钟内有效');
			 	}else{
			 		return $response->reply(2,'系统繁忙，请稍后验证');
			 	}
			 }else{
			 	// echo "bad";
			 	return $response->reply(2,'系统繁忙，请稍后验证');
			 }
			 // dd($result);
		}
	}


	public function apiMobileAdd(Request $request)
	{
		$response = new ApiResponse;
		$mobile = $request->input('mobile');
		$code = $request->input('code');
		$openid = $request->session()->get('openid');
		$mcy_user = McyUser::where('is_delete',0)->where('openid',$openid)->first();
		$sms = McySendSms::where('is_delete',0)->where('mobile',$mobile)->where('code',$code)->where('mcy_user_id',$mcy_user->mcy_user_id)->first();
		if ($sms){
			if ($sms->created_at <= date("Y-m-d H:i:s",strtotime($sms->created_at." + 10 mins")))
			{
				/* 十分钟内 */
				$sms->is_delete = 1;
				$mcy_user->mobile = $mobile;
				if ($sms->save()){
					if ($mcy_user->save()){
						return $response->reply(0,'验证成功，快点去快购吧！大奖等着你来拿');
					}else{}
				}else{
				}
				return $response->reply(2,'系统繁忙，请稍后验证');
			}else{
				$sms->is_delete = 1;
				$sms->save();
				return $response->reply(3,'验证码已经过期，请重新获取验证码');
			}
		}else{
			return $response->reply(2,'错误验证码或验证码已过期');
		}

	}


	/**
	 * 忘记密码发手机验证码接口
	 */
	public function apiForgetPassSend(Request $request){

		$response = new ApiResponse;
		$mobile = $request->input("mobile","");

		//1.验证手机

		//格式
		if(!Tools::is_mobile($mobile)){
			return $response->reply(3,'手机格式不正确');
		}

		//判断手机号是否注册过
		$mcy_user = McyUser::where('mobile',$mobile)->where('is_delete',0)->first();
		if(!$mcy_user){
			return $response->reply(3,'该手机号还没有注册过');
		}

		//2.判断手机是否在有限期内或者已经发送
		$sms = McySendSms::where('mobile',$mobile)->where('is_delete',0)->first();
		if ($sms){
			//判断是否在十分钟内

			if (time() <= strtotime($sms->created_at." + 10 mins")) {
				/* 十分钟内 */
				return $response->reply(2,'短信已经发送，十分钟内有效');
			}else{
				$sms->is_delete = 1;
				$sms->save();
			}
		}


		/* 发送消息 */
		$sms_new = new McySendSms;
		$sms_new->created_at = date('Y-m-d H:i:s');
		$sms_new->updated_at = date('Y-m-d H:i:s');

		$result =  Tools\AliSMS::yzm($mobile);
		$result =json_decode($result);
		if (@$result->ret == 0){
			/* 发送成功 写入数据库 */
			$sms_new->code = $result->code;
			$sms_new->mobile = $mobile;
			if ($sms_new->save())
			{

				return $response->reply(0,'发送成功，短信十分钟内有效');
			}else{
				return $response->reply(2,'系统繁忙，请稍后验证');
			}
		}else{
			// echo "bad";
			return $response->reply(2,'系统繁忙，请稍后验证');
		}

		return $response->reply(0,'成功');

	}

}
