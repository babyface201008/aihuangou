<?php 
namespace App\Tools;

class HttpsResponse {
	public static function https_request($url) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl,  CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($curl);
		if (curl_errno($curl)){
			return 'ERROR'.curl_error($curl);
		}
		curl_close($curl);
		return $data;
	}
	/**
	 * http 发送链接跳转回来
	 */
	public static function get($url,$header,$data='') {
		if (!isset($header)) $header = array('Content-Type' =>'text/html','charset'=> 'utf-8');
		if ($data !== '') {$url .= self::jionParams($data);}
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($curl, CURLOPT_FAILONERROR, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, true);
		if (1 == strpos("$".$url, "https://"))
		{
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		}
		$data = curl_exec($curl);
		if (curl_errno($curl)){
			$data = json_encode(array('status'=>'1','response'=>curl_error($curl)));
		}
		$headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		$header = substr($data, 0, $headerSize);
		$body = substr($data, $headerSize);

		curl_close($curl);
		$data = json_encode(array("status"=>'0','response'=>$body),JSON_UNESCAPED_UNICODE);
		return $data;
	}
	
	/**
	 * @biref 发送数据post 
	 * @param $url 传递路径
	 * @param $post_date post数据
	 */
	public static function post($url, $post_date){
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: text/html;charset=utf-8'));
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // stop verifying certificate
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true); // enable posting
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_date); // post
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); // if any redirection after upload
		$data = curl_exec($curl);
		if (curl_errno($curl)){
			$data = json_encode(array('status'=>'1','response'=>curl_error($curl)));
		}
		curl_close($curl);
		$data = json_encode(array("status"=>'0','response'=>$data),JSON_UNESCAPED_UNICODE);
		return $data;
		
	}
	
	
	/**
	 * https 发送链接,传递数据,跳转回来
	 */
	public static function https_request_post($url,$data) {
		$curl = curl_init();
		$query_string = http_build_query($data);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POSTFIELDS,$query_string);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl,  CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($curl);
		if (curl_errno($curl)){
			return 'ERROR'.curl_error($curl);
		}
		curl_close($curl);
		return $data;
	}
	
	private static function jionParams($params=[])
	{
		$url = '';
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