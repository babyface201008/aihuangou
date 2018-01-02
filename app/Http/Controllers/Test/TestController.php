<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use QL\QueryList as QueryList;
use App\Tools\Test;
use App\Tools;
use App\Http\Controllers\Api\Mcy\ApiMcyPayInfoController;
use App\Model\McyUser;
use App\Model\McySite;
use App\Model\McyYunGou;
use App\Model\McyYunGouOrder;
use App\ApiResponse;
use App\Tools\WeixinUtil;
use App\Tools\WXPAY\Lib\WxPayConfig;
use App\Model\McyWxInfo;
use DB;


class TestController extends Controller
{
	public function test(Request $request)
	{
		return view("mcy.test");
	}

	public function fixIp(Request $request)
	{

		$users = McyUser::where('is_delete',0)->orderBy('created_at','desc')->get();
		$arr1 = array('揭阳市','潮州市','汕头市');
		foreach($users as $user)
		{
			$mt_rand = mt_rand(0,2);
			$user->ip_addr = "广东省".$arr1[$mt_rand];
			$user->save();
			// echo "<br>";
			// $info = Tools::getCity('116.5.201.41');
			// $addr = $info['region'].$info['city'];
			// echo $addr;
			// echo "<Br>";
			// $user->save();
		}
	}
	public function test_weixin_ip(Request $request)
	{
		$openid = $request->session()->get('openid');
		$mcy_user = McyUser::where('openid',$openid)->where('is_delete',0)->first();
		 $wxinfo = McyWxInfo::where('wxinfo_id',8)->first();
            	 WxPayConfig::$APPID = $wxinfo->appid;
            	 WxPayConfig::$APPSECRET = $wxinfo->appsecret;
	        $accessToken = WeixinUtil::get_access_token();
		 $result = json_decode(WeixinUtil::get_userinfo($accessToken, $openid));
		 if (isset($result->errcode))
		 {
		 	dd($result);
		 }else{
		 	// echo $result['province'];
		 	echo @$result->province;
		 	dd($result);
		 }
	}
	public function test_ip(Request $request)
	{

		$ip = $request->ip();
		echo $ip."<br>";
		$reIP=$_SERVER["REMOTE_ADDR"]; 
		echo $reIP."<br>";
		$reIP=@$_SERVER["HTTP_CLIENT_IP"]; 
		echo $reIP."<br>";
		$user_IP = (@$_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"]; 
		$user_IP = ($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"]; 
		echo $user_IP."<br>";
		$info = Tools::getCity($ip);
		var_dump($info);
	}
	public function test_time(Request $request)
	{
		$t1 = microtime(true);
		 // $orders = McyYunGouOrder::where('product_id',56)->where('qishu',276)->where('is_delete',0)->where('mcy_user_id',1637)->select('yungouma')->get();
		$orders = DB::select('select * from mcy_user');
          $count = 0;
          // foreach($orders as $order)
          // {
          //   $c = explode(",",$order->yungouma);
          //   $count += count($c);
          // }
         $t2 = microtime(true);
         echo $t2 - $t1;
          dd($count);

	}
	public function apiget_test(Request $request)
	{
		$response = new ApiResponse;
        $oid = $request->input('oid');
        $number = $request->number?$request->number:20;
        $page = $request->page?$request->page:1;
        $error = 0;
        if ($oid == '')
        {
          $yungou_shop = McyYunGou::where('is_delete',0)->where('huode_id',0)->where('show_time','>',0)->orderBy('show_time','asc')->first();
        }else{
          $yungou_shop = McyYunGou::where('yungou_id',$oid)->where('is_delete',0)->first();
        }
        if ($yungou_shop)
        {          
        }else{
          $response->listItems = '';
          $response->error =1 ;
          return $response->toJson();
        }
        $date = $yungou_shop->show_time;
        // $date = date("Y-m-d H:i:s");
        $listItems = McyYunGou::where('is_delete',0)->where('show_time','>',$date)->where('huode_id',0)->orderBy('show_time','asc')->limit(2)->get();
        foreach($listItems as $item)
        {
         $product = McyProduct::where('product_id',$item->product_id)->first();
         $item->id = $item->product_id;
         $item->yid = $item->yungou_id;
         $item->thumb_style = '';
         $item->LoadPic = '/favicon.ico';
         $item->thumb = $product->product_img;
         $item->qishu = $item->qishu;
         $item->title = $product->product_name;
         $item->shop_money = $product->product_price;
        }
        $response->error = $error;
        $response->listItems = $listItems;
        return $response->toJson();
	}

	public function send_template_msg(Request $request)
	{
		$test = new ApiMcyPayInfoController;
		$touser = 'o7RM2wOlsHXF14CJv2Bmq3TuA7bM';
		$name = ' ceshi ';
		$price = '0.1';
		$url = 'www.chkg99.com';
		$r = $test->send_template_msg($touser,$name,$price,$url);
		dd($r);
	}
	public function student1(Request $request)
	{
		$area_code = '445102';
		$schools = array();
		$schools[] = array(18, 'czky1', '开元中学', '100', 1);
		$schools[] = array(19, 'czky1', '城南中学', '396', 2);
		$schools[] = array(20, 'czky1', '锡华中学', '146', 3);
		$schools[] = array(21, 'czky1', '太平中学', '150', 4);
		$schools[] = array(22, 'czky1', '城基中学', '394', 5);
		$schools[] = array(23, 'czky1', '城西中学', '177', 6);
		echo "<table>";
		for ($i=1;$i<1200;$i++)
		{
			$a = array(0,1,2,3,4,5,6);
			echo "<tr>";
			$birth = mt_rand(mktime(0,0,0,1,1,2010),mktime(0,0,0,8,30,2011));
			$sfz = Tools::getRandomSFZ($birth,$area_code);
			$sex = Tools::getSex($sfz);
			if ($sex == 1) { $sex = '男';}else{ $sex = '女';}
			$name = Tools::getRandomName();
			echo "<td>xx".$i."</td>";
			echo "<td>".$name."</td>";
			echo "<td>".$sex."</td>";
			shuffle($a);
			$t = 1;
			foreach($a as $key => $value)
			{
				$r = mt_rand(0,10);
				if ($t == 1)
				{
					if ($r > 9 && $key !==0)
					{
						echo "<td>"."</td>";
						$t = 0;
					}else{
						echo "<td>".$schools[$a[$value]][2]."</td>";
					}
				}else{

				}
			
			}
			echo "</tr>";
		}
		echo "</table>";
	}
	public function student2(Request $request)
	{
		$area_code = '445102';
		$schools = array();
		$schools[] = array(10, 'xxky2', '来宜小学', '92', 1);
		$schools[] = array(11, 'xxky2', '培英小学', '90', 2);
		$schools[] = array(12, 'xxky2', '南春路小学', '72', 3);
		$schools[] = array(13, 'xxky2', '城西中心小学', '108', 4);
		$schools[] = array(14, 'xxky2', '新春园小学', '68', 5);
		$schools[] = array(15, 'xxky2', '厦寺小学', '77', 6);
		$schools[] = array(16, 'xxky2', '北关小学', '54', 7);
		$schools[] = array(17, 'xxky2', '凤新中心小学', '119', 8);
		$schools[] = array(17, 'xxky2', '春光小学', '99', 9);
		echo "<table>";
		for ($i=1;$i<1200;$i++)
		{
			$a = array(0,1,2,3,4,5,6,7,8);
			echo "<tr>";
			$birth = mt_rand(mktime(0,0,0,1,1,2010),mktime(0,0,0,8,30,2011));
			$sfz = Tools::getRandomSFZ($birth,$area_code);
			$sex = Tools::getSex($sfz);
			if ($sex == 1) { $sex = '男';}else{ $sex = '女';}
			$name = Tools::getRandomName();
			echo "<td>xx".$i."</td>";
			echo "<td>".$name."</td>";
			echo "<td>".$sex."</td>";
			shuffle($a);
			$t = 1;
			foreach($a as $key => $value)
			{
				$r = mt_rand(0,10);
				if ($t == 1)
				{
					if ($r > 9 && $key !==0)
					{
						echo "<td>"."</td>";
						$t = 0;
					}else{
						echo "<td>".$schools[$a[$value]][2]."</td>";
					}
				}else{

				}

			}
			echo "</tr>";
		}
		echo "</table>";
	}

	public function school_test(Test $test)
	{
		$area_code = '445102';
		$schools = array();
		$schools[] = array(4, 'xxky1', '区实验学校', '279', 1);
		$schools[] = array(5, 'xxky1', '昌黎路小学', '34', 2);
		$schools[] = array(6, 'xxky1', '城南小学', '216', 3);
		$schools[] = array(7, 'xxky1', '振德街小学', '118', 4);
		$schools[] = array(8, 'xxky1', '铮蓉小学', '76', 5);
		$schools[] = array(9, 'xxky1', '新桥路小学', '23', 6);
		$schools[] = array(10, 'xxky2', '来宜小学', '92', 1);
		$schools[] = array(11, 'xxky2', '培英小学', '90', 2);
		$schools[] = array(12, 'xxky2', '南春路小学', '72', 3);
		$schools[] = array(13, 'xxky2', '城西中心小学', '108', 4);
		$schools[] = array(14, 'xxky2', '新春园小学', '68', 5);
		$schools[] = array(15, 'xxky2', '厦寺小学', '77', 6);
		$schools[] = array(16, 'xxky2', '北关小学', '54', 7);
		$schools[] = array(17, 'xxky2', '凤新中心小学', '119', 8);
		$schools[] = array(17, 'xxky2', '春光小学', '99', 9);
		$schools[] = array(18, 'czky1', '开元中学', '100', 1);
		$schools[] = array(19, 'czky1', '城南中学', '396', 2);
		$schools[] = array(20, 'czky1', '锡华中学', '146', 3);
		$schools[] = array(21, 'czky1', '太平中学', '150', 4);
		$schools[] = array(22, 'czky1', '城基中学', '394', 5);
		$schools[] = array(23, 'czky1', '城西中学', '177', 6);
		$schools[] = array(38, 'czky2', '开元中学', '99', 1);
		$schools[] = array(39, 'czky2', '城南中学', '339', 2);
		$schools[] = array(40, 'czky2', '锡华中学', '146', 3);
		$schools[] = array(41, 'czky2', '太平中学', '146', 4);
		$schools[] = array(43, 'czky2', '城西中学', '51', 6);
		$schools[] = array(44, 'cnzyw', '城南中英文学校', '400', 0);
		$schools[] = array(45, 'czky2', '城基中学', '33', 5);
		$schools[] = array(46, 'xxky2', '春光小学', '1', 9);
		echo "<table>";
		for ($i=1;$i<3000;$i++)
		{
			echo "<tr>";
			$birth = mt_rand(mktime(0,0,0,1,1,2010),mktime(0,0,0,8,30,2011));
			$sfz = Tools::getRandomSFZ($birth,$area_code);
			$name = Tools::getRandomName();
			echo "<td>".$name."</td>";
			echo "<td>".$sfz."</td>";
			echo "<td>".$schools[mt_rand(0,count($schools) -1 )][2]."</td>";
			echo "<td>".$schools[mt_rand(0,count($schools) -1 )][1]."</td>";
			echo "</tr>";
		}
		echo "</table>";

	}

	public function test1(Request $request)
	{
			$url = 'http://mini.eastday.com/mobile/170419145738003.html';
			//采集规则
			$rules = array(
			    //文章标题
			    'title' => ['.title','text'],
			    'content' => ['.J-article-content','html'],
			    //文章作者名
			    'author' => ['.article-src-time','text']
			);
			//列表选择器
			$rang = '.J-article';
			//采集
			$data = \QL\QueryList::Query($url,$rules,$rang)->data;
			dd($data);
	}

	public function freeproxylist(Request $request)
	{

	}

	public function getProxyList(Request $request)
	{
		$type = $request->type;
		switch ($type) {
			case 1:
				return $this->freeproxylist();
				break;
			
			default:
				return "";
				break;
		}
	}

    public function queryExample(Request $request)
    {
    	$client = new \GuzzleHttp\Client(['base_uri' => 'http://phphub.org']);
		$jar = new \GuzzleHttp\Cookie\CookieJar();
		//发送一个Http请求
		$response = $client->request('GET', '/categories/6', [
		    'headers' => [
		        'User-Agent' => 'testing/1.0',
		        'Accept'     => 'application/json',
		        'X-Foo'      => ['Bar', 'Baz']
		    ],
		    'form_params' => [
		        'foo' => 'bar',
		        'baz' => ['hi', 'there!']
		    ],
		    // 'cookies' => $jar,
		    'timeout' => 3.14,
		    // 'proxy' => 'tcp://localhost:8125',
		    // 'cert' => ['/path/server.pem', 'password'],
		]);
		$body = $response->getBody();
		//获取到页面源码
		$html = (string)$body;
		//采集规则
		$rules = array(
		    //文章标题
		    'title' => ['.media-heading a','text'],
		    //文章链接
		    'link' => ['.media-heading a','href'],
		    //文章作者名
		    'author' => ['.img-thumbnail','alt']
		);
		//列表选择器
		$rang = '.topic-list>li';
		//采集
		$data = \QL\QueryList::Query($html,$rules,$rang)->data;
		//查看采集结果
		print_r($data);
    }


    public function yibu(Request $request)
    {
    	$url = 'http://mcy.hs.k.com/yibutest'; 
    	$param = array( 
    		'name'=>'fdipzone', 
    		'gender'=>'male', 
    		'age'=>30 
    		); 

    	return $this->doRequest($url, $param); 
    }

    public function yibutest()
    {
    	$post = $_POST;
    	sleep(5);
    	file_put_contents('./test.txt', $post);
    }
    public function doRequest($url, $param=array()){ 
    	ignore_user_abort(true); // 忽略客户端断开 
		set_time_limit(0);    //
    	$urlinfo = parse_url($url); 

    	$host = $urlinfo['host']; 
    	$path = $urlinfo['path']; 
    	$query = isset($param)? http_build_query($param) : ''; 

    	$port = 80; 
    	$errno = 0; 
    	$errstr = ''; 
    	$timeout = 10; 

    	$fp = fsockopen($host, $port, $errno, $errstr, $timeout); 

    	$out = "POST ".$path." HTTP/1.1\r\n"; 
    	$out .= "host:".$host."\r\n"; 
    	$out .= "content-length:".strlen($query)."\r\n"; 
    	$out .= "content-type:application/x-www-form-urlencoded\r\n"; 
    	$out .= "connection:close\r\n\r\n"; 
    	$out .= $query; 

    	$data = fputs($fp, $out); 
    	// $html = '';
    	// while (!feof($fp)) {
    	// 	$html.=fgets($fp);
    	// }
    	// echo $html;
    	fclose($fp); 
    } 
    
}
