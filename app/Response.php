<?php
namespace App;
/**
 * Response class to api return 
 **/
class Response
{
	public $msg ;
	public $ret ;
	public $info;
	public function toJson()
	{
		return json_encode($this,JSON_UNESCAPED_UNICODE);
	}

	public function reply($ret,$msg,$info='')
	{
		$this->msg = $msg;
		$this->ret = $ret;
		$this->info = $info;
		return json_encode($this,JSON_UNESCAPED_UNICODE);
	}
}
?>