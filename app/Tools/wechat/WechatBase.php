<?php 
namespace App\Tools\wechat;
/**
* This is the Wechat base class
*/
use App\Tools\MyLog\WechatLog;
use App\Tools\wechat\Http;
use App\Tools\wechat\Config;
use Cache;
use Session;
class WechatBase
{
	static public function get_access_token()
	{
		// Cache::forget('access_token');
		if (Cache::has('access_token')){
			return Cache::get('access_token');
		}
		$url = "/cgi-bin/token?grant_type=client_credential&appid=".Config::APP_ID."&secret=".Config::APP_SECRET."";
		WechatLog::info($url);
		$data = Http::get($url);
		$data = json_decode($data);
		Cache::put("access_token",$data->access_token,110);
		return $data->access_token;
	}

	static public function qrcode_create($data=[])
	{
		$access_token = self::get_access_token();
		$url = "/cgi-bin/qrcode/create";
		WechatLog::info($url);
		$data = Http::post($url,array("access_token"=>$access_token),$data);
		return $data;
		return json_encode($data);
	}

	static public function qrcode_get($ticket)
	{
		$url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($ticket);
		$data = Http::image_get($url);
		return $data;
	}
}
 ?>