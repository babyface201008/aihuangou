<?php 
namespace App\Tools\dingtalk\crypto;

use App\Tools\MyLog\DingTalkLog;
use App\Tools\dingtalk\crypto\Prpcrypt;
use App\Tools\dingtalk\crypto\errorCode;
use App\Tools\dingtalk\crypto\sha1;

use App\Tools\dingtalk\Config;

/**
* This is the DingTalkCrypto Class
*/
class DingTalkCrypt
{
	public  $token;
	public  $encodingAesKey;
	public  $suiteKey;
	// public  $create_suiteKey;
	public  $app_id;
	public  $app_secret;
	
	public function __construct($is_news = 0)
	{
		//The initial suiteKey is "";don't forget it!
		//The initial encodingAesKey is "";don't forget it!
		$this->token = Config::TOKEN;
		$this->encodingAesKey = Config::ENCODING_AES_KEY;

		if ($is_news){
			$this->suiteKey = Config::CREATE_SUITE_KEY;
		}else{
			$this->suiteKey = Config::SUITE_KEY;
		}

		$this->app_id = Config::APPID;
		$this->app_secret = Config::APP_SECRET;
	}
	public function EncryptMsg($plain, $timeStamp, $nonce, &$encryptMsg)
	{
		DingTalkLog::info("encryptmsg");
		$pc = new Prpcrypt();

		$pc->Prpcrypt($this->encodingAesKey);

		$array = $pc->encrypt($plain, $this->suiteKey);
		$ret = $array[0];
		if ($ret != 0) {
			return $ret;
		}
		if ($timeStamp == null) {
			$timeStamp = time();
		}
		$encrypt = $array[1];

		$sha1 = new SHA1;
		$array = $sha1->getSHA1($this->token, $timeStamp, $nonce, $encrypt);
		$ret = $array[0];
		if ($ret != 0) {
			return $ret;
		}
		$signature = $array[1];

		$encryptMsg = json_encode(array(
			"msg_signature" => $signature,
			"encrypt" => $encrypt,
			"timeStamp" => $timeStamp,
			"nonce" => $nonce
			));
		return ErrorCode::$OK;
	}

	public  function DecryptMsg($signature, $timeStamp = null, $nonce, $encrypt, &$decryptMsg)
	{
		if (strlen($this->encodingAesKey) != 43){
			DingtalkLog::info("failed code : ".ErrorCode::$IllegalAesKey);
			return ErrorCode::$IllegalAesKey;
		}

		$pc = new Prpcrypt();

		$pc->Prpcrypt($this->encodingAesKey);

		if ($timeStamp == null) {
			$timeStamp = time();
		}
		$sha1 = new SHA1;
		$array = $sha1->getSHA1($this->token, $timeStamp, $nonce, $encrypt);
		$ret = $array[0];

		if ($ret != 0) {
			return $ret;
		}

		$verifySignature = $array[1];
		if ($verifySignature != $signature) {
			return ErrorCode::$ValidateSignatureError;
		}

		$result = $pc->decrypt($encrypt, $this->suiteKey);
		if ($result[0] != 0) {
			return $result[0];
		}
		$decryptMsg = $result[1];

		return ErrorCode::$OK;
	}
}
 ?>