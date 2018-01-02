<?php 
namespace App\Tools\MyLog;

use monolog\Logger;
use Monolog\hander\StreamHandler;
use Illuminate\Log\Writer;

/**
* Wechat Log
*/
class WechatLog
{
	const LOG_INFO = 'wechat_info';
	const LOG_ERROR = 'wechat_error';

	private static $loggers  = array();

	public static function base($type = self::LOG__ERROR, $day = 30)

	{

		if (empty(self::$loggers[$type])) {
			self::$loggers[$type] = new Writer(new Logger($type));
			self::$loggers[$type]->useDailyFiles(storage_path().'/logs/'.$type.'.log',$day);
		}
		$log = self::$loggers[$type];
		return $log;
	}

	public static function info($message)
	{
		self::base(self::LOG_INFO)->info($message);
	}

	public static function error($message)
	{
		self::base(self::LOG_ERROR)->error($message);
	}
}

 ?>