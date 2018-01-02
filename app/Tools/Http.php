<?php 
namespace App\Tools;

/**
* The Curl function for the laravel
*/
class Http
{
	const D_OAPI_HOST = "http://kuurin.welkin4firesky.com";

	public static function get($path, $params=[])
	{
		$url = self::jionparams($path, $params);
		return $url;
	}

	private static function jionParams($path, $params=[])
	{
		$url = D_OAPI_HOST . $path;
		if (count($params) > 0)
		{
			$url = $url . "?";
			foreach ($params as $key => $value)
			{
				$url = $url . $key . "=" .$value . "&";
			}
			$length = count($url);
			if ($url[$length -1 ] == '&')
			{
				$url = substr($url, 0, $length - 1);
			}
		}
		return $url;
	}
}
 ?>