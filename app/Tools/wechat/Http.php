<?php 
namespace App\Tools\wechat;
/**
* The Http class Controller
*/
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Tools\MyLog\WechatLog;
class Http extends Controller
{
	public static function get($path, $params=[])
	{
		$url = self::joinParams($path, $params);
		WechatLog::info($url);
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		// curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

		$data = curl_exec($curl);
		if ( curl_error($curl) ){
			WechatLog::error('http_request.error'.curl_error($curl));
			return 'ERROR'.curl_error($curl);
		}
		curl_close($curl);
		return $data;
	}

	public static function post($path, $params=[],$post_data)
	{
		$url = self::joinParams($path, $params);
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_POST, TRUE); // enable posting
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data); 
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE); // if any redirection after upload
		$data = curl_exec($curl);
		if ( curl_error($curl) ){
			WechatLog::error('http_request.error'.curl_error($curl));
			return 'ERROR'.curl_error($curl);
		}
		curl_close($curl);
		return $data;
	}
	public static function origin_post($url,$post_data)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json;charset=utf-8'));
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_POST, TRUE); // enable posting
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data); 
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE); // if any redirection after upload
		$data = curl_exec($curl);
		if ( curl_error($curl) ){
			WechatLog::error('http_request.error'.curl_error($curl));
			return 'ERROR'.curl_error($curl);
		}
		curl_close($curl);
		return $data;
	}

	static public function image_get($path)
	{
		$url = $path;
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl,  CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($curl);
		if (curl_errno($curl)){
			return 'ERROR'.curl_error($curl);
		}
		// header('Content-type: image/JPEG');
		$imginfo = curl_getinfo($curl);
		curl_close($curl);
		return $imginfo;

	}
	private static function joinParams($path, $params=[])
	{
		$url = Config::OAPI_HOST . $path;
		if (count($params) > 0)
		{
			$url = $url . "?";
			foreach ($params as $key => $value)
			{
				$url = $url . $key . "=" .$value . "&";

			}
			$length = strlen($url);
			if ($url[$length - 1 ] == '&')
			{
				$url = substr($url, 0, $length - 1);
			}
		}
		return $url;
	}
}
 ?>