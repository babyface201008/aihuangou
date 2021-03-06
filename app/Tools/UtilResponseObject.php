<?php namespace App\Tools;

use Response;

class UtilResponseObject {
	
    public function __construct() {
        $params = func_get_args();
        foreach( $params as $param )
		{
			$this->{$param} = $param;
		}
    }

    public function __call($method, $arguments) {
        $arguments = array_merge(array("stdObject" => $this), $arguments);
        if (isset($this->{$method}) && is_callable($this->{$method})) {
            return call_user_func_array($this->{$method}, $arguments);
        } else {
            throw new Exception("Fatal error: Call to undefined method stdObject::{$method}()");
        }
    }
	
	// 将对象转为 JSON 对象
	public function toJson()
	{
		$json = json_encode($this, JSON_UNESCAPED_UNICODE);
		
		return Response::make($json)->header('Content-Type', 'application/json; charset=UTF-8');
	}
	
	// 将对象转为 JSON 对象
	public function toJsonTypeTextHtml()
	{
		$json = json_encode($this, JSON_UNESCAPED_UNICODE);
		
		return Response::make($json)->header('Content-Type', 'text/html; charset=UTF-8');
	}
	
	// 将对象转为数组
	public function toArray()
	{
		return (array)$this;
	}
	
	public $ret;
	public $msg;
}