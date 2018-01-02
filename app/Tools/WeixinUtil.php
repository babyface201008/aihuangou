<?php namespace App\Tools;


use App\Tools\UtilUUID;
use App\Tools\FileUtil;
use App\Tools\HttpsResponse;

use App\Tools\WXPAY\Lib\WxPayConfig;
use App\Tools\WXPAY\Lib\WxPayMicroPay;
use App\Tools\WXPAY\Lib\WxPayRefund;
use App\Tools\WXPAY\MicroPay;
use App\Tools\WXPAY\JsApiPay;
use App\Tools\WXPAY\Lib\WxPayUnifiedOrder;
use App\Tools\WXPAY\WxPayApi;


use Log;
use stdClass;
use Session;

class WeixinUtil {
	
	public static function init() {
		$wi = new stdClass();
		$wi->app_id = WxPayConfig::$APPID;
		$wi->app_secret = WxPayConfig::$APPSECRET;
		return $wi;
    }
	
	/**
	 * 获取access_token
	 */
	public static function get_access_token() {
		
		$wi = WeixinUtil::init();
		
		$access_token = WeixinUtil::make_appsecret($wi->app_id, $wi->app_secret);
	
		return $access_token;
	}
	
	/**
	 * @brief 生成相关JS相关签名
	 */
	public static function make_nonceStr() {
		
		$codeSet = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		for ($i = 0; $i<16; $i++) {
			$codes[$i] = $codeSet[mt_rand(0, strlen($codeSet)-1)];
		}
		$nonceStr = implode($codes);
		
		return $nonceStr;
	}
	
	public static function make_appsecret($appId, $appsecret){
		
		$TOKEN_URL="https://api.weixin.qq.com/cgi-bin/token"
						."?grant_type=client_credential"
						."&appid=".$appId
						."&secret=".$appsecret;
		//创建文件夹
		FileUtil::createMkdir(storage_path(), "/json/".$appId);		
		
		$file_path = storage_path()."/json/".$appId."/access_token.json";
		
		$isfile = FileUtil::isFile($file_path);
		
		if ($isfile) {
			$data = json_decode(FileUtil::fileGetContents($file_path));
			if ($data->expire_time < time()) {
			
			$json = HttpsResponse::https_request($TOKEN_URL);
			$result = json_decode($json,true);
			$access_token = $result['access_token'];
			if ($access_token) {
				$data->expire_time = time() + 7000;
				$data->access_token = $access_token;
				FileUtil::fileWirteToJson($file_path, $data);
			}
			}else{
				$access_token = $data->access_token;
			}
		} else {
			$data = new stdClass;
			$json = HttpsResponse::https_request($TOKEN_URL);
			$result = json_decode($json,true);
			$access_token = $result['access_token'];
			if ($access_token != null) {
				$data->expire_time = time() + 7000;
				$data->access_token = $access_token;
				FileUtil::fileWirteToJson($file_path, $data);
			}
		}
		
		return $access_token;
	}
	
	/**
	 * 生成签名之前必须先了解一下jsapi_ticket，jsapi_ticket是公众号用于调用微信JS接口的临时票据。
	 * 正常情况下，jsapi_ticket的有效期为7200秒，通过access_token来获取。
	 * 由于获取jsapi_ticket的api调用次数非常有限，频繁刷新jsapi_ticket会导致api调用受限，
	 * 影响自身业务，开发者必须在自己的服务全局缓存jsapi_ticket 。
	 */
	public static function make_ticket($appId, $appsecret) {
		
		$access_token = WeixinUtil::make_appsecret($appId, $appsecret);
		
		$ticket_URL="https://api.weixin.qq.com/cgi-bin/ticket/getticket"
						."?access_token=".$access_token
						."&type=jsapi";
		
		//创建文件夹
		FileUtil::createMkdir(storage_path(), "/json/".$appId);		
		
		$file_path = storage_path()."/json/".$appId."/jsapi_ticket.json";
						
		// jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
		$isfile = FileUtil::isFile($file_path);
		
		if ($isfile) {
			$data = json_decode(FileUtil::fileGetContents($file_path));
			if ($data->expire_time < time()) {
				$json = HttpsResponse::https_request($ticket_URL);
				$result = json_decode($json,true);
				$ticket = $result['ticket'];
				if ($ticket) {
					$data->expire_time = time() + 7000;
					$data->jsapi_ticket = $ticket;
					FileUtil::fileWirteToJson($file_path, $data);
				}
			}else{
				$ticket = $data->jsapi_ticket;
			}
		} else {
			$data = new stdClass;
			$json = HttpsResponse::https_request($ticket_URL);
			$result = json_decode($json,true);
			$ticket = $result['ticket'];
			if ($ticket) {
				$data->expire_time = time() + 7000;
				$data->jsapi_ticket = $ticket;
				FileUtil::fileWirteToJson($file_path, $data);
			}
		}
		
		return $ticket;
	}

	public static function make_signature($nonceStr, $timestamp, $jsapi_ticket, $url) {
		
		$tmpArr = array(
			'noncestr' => $nonceStr,
			'timestamp' => $timestamp,
			'jsapi_ticket' => $jsapi_ticket,
			'url' => $url
		);
		ksort($tmpArr, SORT_STRING);
		$string1 = http_build_query( $tmpArr );
		$string1 = urldecode( $string1 );
		$signature = sha1( $string1 );
		
		return $signature;
	}
	
	/**
	 * 用户同意授权，获取code
	 * @param $scope
 	 * 应用授权作用域，snsapi_base 
	 * （不弹出授权页面，直接跳转，只能获取用户openid），
	 * snsapi_userinfo （弹出授权页面，可通过openid拿到昵称、
	 * 性别、所在地。并且，即使在未关注的情况下，只要用户授权，
	 * 也能获取其信息） 
	 */
	public static function get_oauth2_code($redirect_uri, $state, $scope) {
		$wi = WeixinUtil::init();
		$code_url = "https://open.weixin.qq.com/connect/oauth2/authorize"
					."?appid=".$wi->app_id
					."&redirect_uri=".urlencode($redirect_uri)
					."&response_type=code"
					."&scope=".$scope
					."&state=".$state
					."#wechat_redirect";
		Log::error($code_url);
		return $code_url;
	}
	
	/**
	 * 通过code换取网页授权access_token
	 */
	public static function get_oauth2_token($code) {
		$wi = WeixinUtil::init();
		Log::info($code);
		$TOKEN_URL="https://api.weixin.qq.com/sns/oauth2/access_token"
					."?appid=".$wi->app_id
					."&secret=".$wi->app_secret
					."&code=".$code
					."&grant_type=authorization_code";	
					
		$data = new stdClass();
		$json = HttpsResponse::https_request($TOKEN_URL);
		$data->json = $json;
		Log::info("WeixinUtil::get_oauth2_token() data : $json");			
		
		return $data;
	}
	
	/**
	 * 获取网页JS的相关参数
	 */
	public static function get_weixin_params() {
		
		$wi = WeixinUtil::init();
		$appId = $wi->app_id;
		$appsecret = $wi->app_secret;
		
		$nonceStr = self::make_nonceStr();
		$timestamp = time();
		$jsapi_ticket = self::make_ticket($appId, $appsecret);
		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];	
		
		$signature = self::make_signature($nonceStr, $timestamp, $jsapi_ticket, $url);
		
		$weixin_params = array();
		$weixin_params['appId'] = $appId;
		$weixin_params['timestamp'] = $timestamp;
		$weixin_params['nonceStr'] = $nonceStr;
		$weixin_params['signature'] = $signature;
		
		return $weixin_params;
	}
	
	/**
	 * 下载多媒体
	 */
	public static function get_media($media_id,$type) {
			
		$access_token = self::get_access_token();

		$get_media_url = "http://file.api.weixin.qq.com/cgi-bin/media/get"
						."?access_token=".$access_token
						."&media_id=".$media_id;
		
		Log::info("media_url::".$get_media_url);
		
		$file = '/'.UtilUUID::stdUuid().'.jpg';	
		$dir_path = '/upload/'.$type.'/'.date('Ymd');
		
		//创建文件夹
		FileUtil::createMkdir(public_path(), $dir_path);
		
		//下载图片
		HttpsResponse::img_download($get_media_url, public_path().$dir_path.$file);
	
		
		return $dir_path.$file;
	}
	 
	/**
	 * 拉取用户信息
	 */
	public static function get_userinfo($access_token,$openid) {
		
		$userinfo_url = "https://api.weixin.qq.com/sns/userinfo"
						."?access_token=".$access_token
						."&openid=".$openid
						."&lang=zh_CN";
		
		$json = HttpsResponse::https_request($userinfo_url);
		
		return $json;
	}
	
	/**
	 * @brief 验证用户 openid 
	 */
	 public static function check_openid ($openid) {
	 	
		$uuid = self::gain_openid($openid);
		Log::info(json_encode($uuid));
		if (property_exists($uuid, "errcode")) {
			return true;
		} 
		
		return false;
	 }
	 
	/**
	 * @brief 根据openid 拉取信息
	 */
	 public static function gain_openid ($openid) {
	 	
		$access_token = self::get_access_token();
		Log::info("access_token === $access_token");
		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
		Log::info("gain_openid ++++++++++++ ". $url);
		$json_openid = HttpsResponse::https_request($url);
		Log::info("json_openid ++++++++++++ ". $json_openid);
		return $json_openid;
	 } 
	 
	 /**
	 * @brief 根据openid 是否关注公众号
	 */
	 public static function subscribe ($openid) {
	 	
		$gain_openid = json_decode(self::gain_openid($openid));
		
		if (property_exists($gain_openid, "errcode")) {
			if ( $gain_openid->errcode == 40001 ) {
				$wi = WeixinUtil::init();
				$appId = $wi->app_id;
				$file_path = storage_path()."/json/".$appId."/access_token.json";
				unlink($file_path);
				$gain_openid = json_decode(self::gain_openid($openid));
			}
		}
		
		if ($gain_openid->subscribe == 0) {
			return FALSE;
		}
		return TRUE;
	 }
	
	
	/*
	 * @brief 支付
	 * 设置统一支付接口参数
	 * 设置必填参数
	 * appid已填,商户无需重复填写
	 * mch_id已填,商户无需重复填写
	 * noncestr已填,商户无需重复填写
	 * spbill_create_ip已填,商户无需重复填写
	 * sign已填,商户无需重复填写
	 */	
	 public static function JsApiCall($data){
	 	
		$wxpay = WeixinUtil::init();
		
		$tools = new JsApiPay();
		
		$std = new stdClass();
		$std->order_id = $data->order_id;
		$std->table_name = $data->table_name;
		//②、统一下单
		$input = new WxPayUnifiedOrder();
		$input->SetBody($data->body);
		$input->SetAttach(json_encode($std));
		$input->SetOut_trade_no(date("YmdHis").$data->order_no);
		$input->SetTotal_fee($data->total_fee);
		$input->SetTime_start(date("YmdHis"));
		$input->SetNotify_url($data->notify_url);
		$input->SetTrade_type("JSAPI");
		$input->SetOpenid($data->openid);
		$order = WxPayApi::unifiedOrder($input);
	
		$jsApiParameters = $tools->GetJsApiParameters($order);
		
		return $jsApiParameters;
		
	 }
	 
	
	/**
	 * @brief 退款申请接口    根据 参数  transaction_id 退款
	 * ====================================================
	 * 注意：同一笔单的部分退款需要设置相同的订单号和不同的
	 * out_refund_no。一笔退款失败后重新提交，要采用原来的
	 * out_refund_no。总退款金额不能超过用户实际支付金额(现
	 * 金券金额不能退款)。
	*/
	public static function ApiRefundTwo($transaction_id,$total_fee,$refund_fee)
	{
		$wxpay = WeixinUtil::init();
		
		$input = new WxPayRefund();
		$input->SetTransaction_id($transaction_id);
		$input->SetTotal_fee($total_fee);
		$input->SetRefund_fee($refund_fee);
	    $input->SetOut_refund_no(WxPayConfig::$MCHID.date("YmdHis"));
	    $input->SetOp_user_id(WxPayConfig::$MCHID);
		$result = WxPayApi::refund($input);
		
		Log::info("refund::".json_encode($result));
		
		return $result;
	}


    /**
     * 判断是否为微信浏览器
    */
    public static function isWeixin(){
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($user_agent, 'MicroMessenger') === false) {
            // 非微信浏览器禁止浏览
            // echo "HTTP/1.1 401 Unauthorized";
            return false;
        } else {
            // 微信浏览器，允许访问
            // echo "MicroMessenger";
            // 获取版本号
            // preg_match('/.*?(MicroMessenger\/([0-9.]+))\s*/', $user_agent, $matches);
            // echo '<br>Version:'.$matches[2];
            return true;
        }
    }


}
