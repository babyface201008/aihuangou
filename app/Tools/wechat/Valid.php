<?php 
namespace App\Tools\wechat;
/**
* The Valid class Controller
*/
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Tools\wechat\Config;
class Valid
{
	public  static function valid()
	{
		$echoStr = $_GET['echostr'];
		if (self::checkSignature()) {
			echo $echoStr;
			exit;
		}
	}
	private  static function checkSignature()
	{
		// return Config::TOKEN;
		$token = Config::TOKEN;
		if($token == ""){
			throw new Exception("TOKEN is not defined");
		}

		$signature = $_GET['signature'];
		$timestamp = $_GET['timestamp'];
		$nonce		 = $_GET['nonce'];
		$tmpArr 	 = array($token,$timestamp,$nonce);
		sort($tmpArr,SORT_STRING);
		$tmpStr    = implode($tmpArr);
		$tmpStr		 = sha1($tmpStr);
		if ($tmpStr == $signature) {
			return  true;
		}else{
			return false;
		}
	}
}
 ?>