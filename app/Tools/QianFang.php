<?php
namespace App\Tools;
class QianFang{
	public $gateway = 'http://gateway.kekepay.com/query/singleOrder';
	public $apiurl = 'http://gateway.kekepay.com/cnpPay/initPay';
	public function __construct(){
		// $this->payKey='';
		// $this->paySecret='';
		
		$this->payKey='';
		$this->paySecret='';
	}

	//扫码支付
	public function pay($data){
		$param['payKey']=$this->payKey;
		$param['orderTime']=date('YmdHis');
		$param['orderIp']=$_SERVER['REMOTE_ADDR'];
		// $param['returnUrl']= "http://" . $_SERVER['HTTP_HOST'] . 'payinfo/return_url';
		// $param['notifyUrl']= "http://" . $_SERVER['HTTP_HOST'] . 'payinfo/notify_url';
		$param['returnUrl']= $data['callback_url'];
		$param['notifyUrl']= $data['notify_url'];
		$param['productType']='10000301';
		$param['appId']='';
		$param['openId']= $data['openid'];
		// $param['openId']= 'o7RM2wOlsHXF14CJv2Bmq3TuA7bM';
		// $param['payWayCode']='WEIXIN';
		$param['outTradeNo']=$data['out_trade_no'];
		$param['orderPrice']=$data['total_fee'];
		$param['productName']=$data['name'];
		$signPars = '';
		//签名
		ksort($param);
		foreach($param as $k => $v) {
			if("" != $v && "sign" != $k) {
				$signPars .= $k . "=" . $v . "&";
			}
		}
		$signPars .= "paySecret=".$this->paySecret;
		$param['sign']=strtoupper(md5($signPars));
		//请求
		// $res=$this->http('http://pay-gateway.roncoo.net/cnpPay/initPay',$param);
		$res=$this->http('http://gateway.kekepay.com/cnpPay/initPay',$param);
		$res=json_decode($res,true);

		//校验签名
		if($this->checkSign($res)){
			return $res;
		}else{
			return '签名错误';
		}
	}

	//回调
	public function notify(){
		$res=$_GET;
		//校验签名
		if($this->checkSign($res)){
			return $res;
		}else{
			return '签名错误';
		}
	}

	public function http($url,$param='',$data = '',$method = 'GET'){
    	$opts = array(
    	    CURLOPT_TIMEOUT        => 30,
    	    CURLOPT_RETURNTRANSFER => 1,
    	    CURLOPT_SSL_VERIFYPEER => false,
    	    CURLOPT_SSL_VERIFYHOST => false,
    	);
    	/* 根据请求类型设置特定参数 */
    	$opts[CURLOPT_URL] = $url . '?' . http_build_query($param);
    	if(strtoupper($method) == 'POST'){
    	    $opts[CURLOPT_POST] = 1;
    	    $opts[CURLOPT_POSTFIELDS] = $data;
    	    if(is_string($data)){ //发送JSON数据
    	        $opts[CURLOPT_HTTPHEADER] = array(
    	            'Content-Type: application/json; charset=utf-8',
    	            'Content-Length: ' . strlen($data),
    	        );
    	    }
    	}
    	/* 初始化并执行curl请求 */
    	$ch = curl_init();
    	curl_setopt_array($ch, $opts);
    	$data  = curl_exec($ch);
    	$error = curl_error($ch);
    	curl_close($ch);
    	//发生错误，抛出异常
    	if($error) print_r($error);
    	return  $data;
	}

	//校验签名
	public function checkSign($res){
		$ressign=$res['sign'];
		unset($res['sign']);
		ksort($res);
		$ressignPars = '';
		foreach($res as $k => $v) {
			if("" != $v && "sign" != $k) {
				$ressignPars .= $k . "=" . $v . "&";
			}
		}
		$ressignPars .= "paySecret=".$this->paySecret;
		$myressign=strtoupper(md5($ressignPars));
		return $ressign==$myressign;
	}
}
