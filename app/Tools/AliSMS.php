<?php 
namespace App\Tools;
/**
* Ali Sms
*/
require_once dirname(__DIR__) . '/Tools/AliSmsSdk/vendor/autoload.php';
use App\Response;
use App\ApiResponse;
// use Aliyun\Core\Profile\DefaultProfile;
// use Aliyun\Core\DefaultAcsClient;
// use Aliyun\Core\Exception\ClientException;
// use Aliyun\Core\Exception\ServerException;
// use Aliyun\Core\Regions\Endpoint;
// use Aliyun\Core\Regions\EndpointProvider;
// use Aliyun\Core\Regions\EndpointConfig;
// use Aliyun\Core\Sms\Request\V20160927\SingleSendSmsRequest;
use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\QuerySendDetailsRequest;
Config::load();
use Log;
use App\Tools;
use App\Model\McySms;

class AliSMS
{
	/**
	 * 注册发送短信验证码
	 */
	public static function yzm($mobile)
	{


		$response =  new Response ;
		//短信配置信息表
		$mcy_sms = McySms::getInfo();
		if(!$mcy_sms){
			return $response->reply(2,"接口错误,请联系客服");
		}

		$iClientProfile = DefaultProfile::getProfile('cn-hangzhou', $mcy_sms->sms_password, $mcy_sms->sms_token);
		// $iClientProfile = DefaultProfile::getProfile('cn-hangzhou', 'LTAIIrFo6rlM0nvP', 'tJmascBlnPNaUKDIePo4l6Oh103YaW');
		DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", "Dysmsapi", "dysmsapi.aliyuncs.com");
		$client = new DefaultAcsClient($iClientProfile);
		// $config = new EndpointConfig();
		// $endpoint = new Endpoint('cn-hangzhou', $config->getRegionIds(), $config->getProductDomains());
		// $endpoints = array( $endpoint );
		// EndpointProvider::setEndpoints($endpoints);
		// $request = new SingleSendSmsRequest();
		$request = new SendSmsRequest;
		$request->setSignName($mcy_sms->sms_name); //签名名称
		$request->setTemplateCode('SMS_67245175'); //模板id

		// $request->setRecNum($mobile);//目标手机号
		$request->setPhoneNumbers($mobile);//目标手机号
		$code = Tools::getRandomNUmber(6);
		$message = array('code'=>$code);
		$content = json_encode($message);
		 //选填-发送短信流水号
		// $request->setOutId("1234");
		$request->setTemplateParam($content);//模板变量，数字一定要转换为字符串
		try {
			$result = $client->getAcsResponse($request);
			Log::info(json_encode($result,1));
			$response->code = $code;
			return $response->reply(0,"ok");
		}
		catch (ClientException $e) {
			Log::info($e->getErrorCode()." :  ".$e->getErrorMessage());
			$errcode = $e->getErrorCode();
			$errmsg = $e->getErrorMessage();
			return $response->reply(2,$errcode.":".$errmsg);
		}
		catch (ServerException $e) {
			$errcode = $e->getErrorCode();
			$errmsg = $e->getErrorMessage();
			Log::info($e->getErrorCode()." :  ".$e->getErrorMessage());
			return $response->reply(2,$errcode.":".$errmsg);
		}
	}


	/**
	 * 中奖发送短信通知
	 */
	public static function zhongjiang($mobile,$code)
	{

		$response =  new Response ;
		//短信配置信息表
		$mcy_sms = McySms::getInfo();
		if(!$mcy_sms){
			return $response->reply(2,"接口错误,请联系客服");
		}

		$iClientProfile = DefaultProfile::getProfile('cn-hangzhou', $mcy_sms->sms_password, $mcy_sms->sms_token);
		// $iClientProfile = DefaultProfile::getProfile('cn-hangzhou', 'LTAIIrFo6rlM0nvP', 'tJmascBlnPNaUKDIePo4l6Oh103YaW');
		DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", "Dysmsapi", "dysmsapi.aliyuncs.com");
		$client = new DefaultAcsClient($iClientProfile);
		// $config = new EndpointConfig();
		// $endpoint = new Endpoint('cn-hangzhou', $config->getRegionIds(), $config->getProductDomains());
		// $endpoints = array( $endpoint );
		// EndpointProvider::setEndpoints($endpoints);
		// $request = new SingleSendSmsRequest();
		$request = new SendSmsRequest;
		$request->setSignName($mcy_sms->sms_name); //签名名称
		$request->setTemplateCode('SMS_119077309'); //模板id

		// $request->setRecNum($mobile);//目标手机号
		$request->setPhoneNumbers($mobile);//目标手机号

		$message = array('code'=>$code);
		$content = json_encode($message);
		//选填-发送短信流水号
		// $request->setOutId("1234");
		$request->setTemplateParam($content);//模板变量，数字一定要转换为字符串
		try {
			$result = $client->getAcsResponse($request);
			Log::info(json_encode($result,1));
			$response->code = $code;
			return $response->reply(0,"ok");
		}
		catch (ClientException $e) {
			Log::info($e->getErrorCode()." :  ".$e->getErrorMessage());
			$errcode = $e->getErrorCode();
			$errmsg = $e->getErrorMessage();
			return $response->reply(2,$errcode.":".$errmsg);
		}
		catch (ServerException $e) {
			$errcode = $e->getErrorCode();
			$errmsg = $e->getErrorMessage();
			Log::info($e->getErrorCode()." :  ".$e->getErrorMessage());
			return $response->reply(2,$errcode.":".$errmsg);
		}
	}


	/**
	 * 发货短信通知
	 */
	public static function shipping($mobile,$orderno)
	{

		$response =  new Response ;
		//短信配置信息表
		$mcy_sms = McySms::getInfo();
		if(!$mcy_sms){
			return $response->reply(2,"接口错误,请联系客服");
		}

		$iClientProfile = DefaultProfile::getProfile('cn-hangzhou', $mcy_sms->sms_password, $mcy_sms->sms_token);
		// $iClientProfile = DefaultProfile::getProfile('cn-hangzhou', 'LTAIIrFo6rlM0nvP', 'tJmascBlnPNaUKDIePo4l6Oh103YaW');
		DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", "Dysmsapi", "dysmsapi.aliyuncs.com");
		$client = new DefaultAcsClient($iClientProfile);
		// $config = new EndpointConfig();
		// $endpoint = new Endpoint('cn-hangzhou', $config->getRegionIds(), $config->getProductDomains());
		// $endpoints = array( $endpoint );
		// EndpointProvider::setEndpoints($endpoints);
		// $request = new SingleSendSmsRequest();
		$request = new SendSmsRequest;
		$request->setSignName($mcy_sms->sms_name); //签名名称
		$request->setTemplateCode('SMS_119077312'); //模板id

		// $request->setRecNum($mobile);//目标手机号
		$request->setPhoneNumbers($mobile);//目标手机号

		$message = array('orderno'=>$orderno);
		$content = json_encode($message);
		//选填-发送短信流水号
		// $request->setOutId("1234");
		$request->setTemplateParam($content);//模板变量，数字一定要转换为字符串
		try {
			$result = $client->getAcsResponse($request);
			Log::info(json_encode($result,1));
			$response->orderno = $orderno;
			return $response->reply(0,"ok");
		}
		catch (ClientException $e) {
			Log::info($e->getErrorCode()." :  ".$e->getErrorMessage());
			$errcode = $e->getErrorCode();
			$errmsg = $e->getErrorMessage();
			return $response->reply(2,$errcode.":".$errmsg);
		}
		catch (ServerException $e) {
			$errcode = $e->getErrorCode();
			$errmsg = $e->getErrorMessage();
			Log::info($e->getErrorCode()." :  ".$e->getErrorMessage());
			return $response->reply(2,$errcode.":".$errmsg);
		}
	}

	public static function xymm($mobile,$password)
	{
		$response =  new Response ;
		$iClientProfile = DefaultProfile::getProfile('cn-hangzhou', '', '');
		$client = new DefaultAcsClient($iClientProfile);
		$config = new EndpointConfig();
		$endpoint = new Endpoint('cn-hangzhou', $config->getRegionIds(), $config->getProductDomains());
		$endpoints = array( $endpoint );
		EndpointProvider::setEndpoints($endpoints);
		$request = new SingleSendSmsRequest();
		$request->setSignName(''); //签名名称
		$request->setTemplateCode(''); //模板id

		$request->setRecNum($mobile);//目标手机号
		$code = $password;
		$message = array('password'=>$code);
		$content = json_encode($message);
		$request->setParamString($content);//模板变量，数字一定要转换为字符串
		try {
			$result = $client->getAcsResponse($request);
			Log::info("xymm: ".json_encode($result,1));
			$response->code = $code;
			return $response->reply(0,"ok");
		}
		catch (ClientException $e) {
			Log::info($e->getErrorCode()." :  ".$e->getErrorMessage());
			$errcode = $e->getErrorCode();
			$errmsg = $e->getErrorMessage();
			return $response->reply(2,$errcode.":".$errmsg);
		}
		catch (ServerException $e) {
			$errcode = $e->getErrorCode();
			$errmsg = $e->getErrorMessage();
			Log::info($e->getErrorCode()." :  ".$e->getErrorMessage());
			return $response->reply(2,$errcode.":".$errmsg);
		}
	}

	public static function message($mobile,$message)
	{
		$response =  new Response ;
		$iClientProfile = DefaultProfile::getProfile('cn-hangzhou', '', '');
		$client = new DefaultAcsClient($iClientProfile);
		$config = new EndpointConfig();
		$endpoint = new Endpoint('cn-hangzhou', $config->getRegionIds(), $config->getProductDomains());
		$endpoints = array( $endpoint );
		EndpointProvider::setEndpoints($endpoints);
		$request = new SingleSendSmsRequest();
		$request->setSignName(''); //签名名称
		$request->setTemplateCode(''); //模板id
		$request->setRecNum($mobile);//目标手机号
		$content = json_encode($message);
		$request->setParamString($content);//模板变量，数字一定要转换为字符串
		try {
			$result = $client->getAcsResponse($request);
			Log::info(json_encode($result,1));
			return $response->reply(0,"ok");
		}
		catch (ClientException $e) {
			$errcode = $e->getErrorCode();
			$errmsg = $e->getErrorMessage();
			Log::info($e->getErrorCode()." :  ".$e->getErrorMessage());
			return $response->reply(2,$errcode.":".$errmsg);
		}
		catch (ServerException $e) {
			$errcode = $e->getErrorCode();
			$errmsg = $e->getErrorMessage();
			Log::info($e->getErrorCode()." :  ".$e->getErrorMessage());
			return $response->reply(2,$errcode.":".$errmsg);
		}
	}
}
 ?>