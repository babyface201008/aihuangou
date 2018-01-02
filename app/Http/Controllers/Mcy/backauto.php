<?php

namespace App\Http\Controllers\Mcy;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\AiHuanGouUser;
use App\Model\Article;
use App\Model\Tag;
use App\Model\Category;
use App\Model\McyAutoMan;
use App\Model\McySite;
use App\Model\McyUser;
use App\Model\McyProduct;
use App\Model\McyYunGouCart;
use App\Model\McyYunGou;
use App\Model\McyOrder;
use App\Model\McyYunGouOrder;
use App\Model\McySendHistory;
use App\Tools\MyLog\WechatLog;
use App\Tools;
use App\ApiResponse;
use DB;
use App\Tools\WeixinUtil;
use App\Tools\WXPAY\Lib\WxPayConfig;
use App\Model\McyWxInfo;


class McyAutoManController extends Controller
{
	/* 设置测试页面配置 */
	public function automan(Request $request)
	{
		// $this->add_robot();
		// dd('welkin');
		$admin_id = $request->session()->get('admin_id');
		$categorys = Category::where("user_id",$admin_id)->where('is_delete',0)->get();
		$automan = McyAutoMan::where('is_delete',0)->where('user_id',$admin_id)->first();
		return view('welkin.mcy.automan',compact('categorys','automan','category_id'));
	}

	public function automanAdd(Request $request)
	{
		return view("welkin.mcy.automan_add");
	}

	/* 测试页面 */
	public function automanRun(Request $request)
	{
		$type = $request->input('type',1);
		/* 默认为当前分类 */
		$go_type = $request->input('go_type','category');
		/* 购买一件商品 */
		if ($type == 2)
		{
			$type = 0;
			$go_type = 'welkin';
			$is_auto = $request->input('is_auto');
			$category_id = $request->input('category_id');
			$auto_s_count = $request->input('auto_s_count');
			$auto_e_count = $request->input('auto_e_count');
			$center_time = $request->input('center_time');
			$test_time = $request->input('test_time');
			$category = Category::where('is_delete',0)->where('category_id',$category_id)->first();
			return view('welkin.mcy.automan_f',compact('type','go_type','is_auto','auto_s_count','auto_e_count','category_id','test_time','category'));
		}else{}
		if ($type == 1)
		{
			$type = 0;
			return view('welkin.mcy.automan_f',compact('type','go_type'));
		}else{
			/* type == 0*/
			$response = new ApiResponse;
			for ($i=0; $i < 1; $i++) { 
				$data =  $this->automanGo($request,$go_type);
			}
			$response->data = $data;
			return $response->reply(0,'ok');
		}
	}
	public function automanGo(Request $request,$go_type)
	{
		$admin_id = \Session::get('admin_id');
		switch ($go_type) {
			case 'category':
				$admin_id = $request->session()->get('admin_id');
				$automan = McyAutoMan::where('is_delete',0)->where('user_id',$admin_id)->first();
				$category_id = $automan->category_id;
				return $this->automanGoCategory($category_id);
				break;
			case 'products':
				$product_ids = $request->input('product_ids');
				return $this->automanGoProduct($product_ids,2);
				break;
			case 'product_id':
				$product_id = $request->input('product_id');
				return $this->automanGoProduct($product_id,1);
				break;
			case 'welkin':
				$info = $request->input();
				return $this->automanWelkin($request,$info);
				break;
			default:
				$product_ids = $request->input('product_ids');
				if ($product_ids == null)
				{
					$product_ids = McyProduct::where('is_delete',0)->where('user_id',$admin_id)->where('product_type',1)->get()->implode("product_id",",");
				}else{

				}
				return $this->automanGoProduct($product_ids);
				break;
		}
	}

	public function automanGoCategory($category_id)
	{
		$admin_id = \Session::get('admin_id');
		if ($category_id == 0)
		{
			/* 购买所有的类型　*/
			$products = McyProduct::where('is_delete',0)->where('product_type',1)->where('user_id',$admin_id)->get()->random(5);
			if ((count($products) > 1))
			{
				$product_ids = collect($products)->implode("product_id",",");
			}else{
				if (count($products) == 1)
				{
					$product_ids = McyProduct::where('is_delete',0)->first()->product_id;
				}else{
					$product_ids = '';
				}
			}
		}else{
			/* 只查找云购产品 */
			$products = McyProduct::where('is_delete',0)->where('product_type',1)->where('category_id',$category_id)->get()->random(5);
			if ((count($products) > 1))
			{
				$product_ids = collect($products)->implode("product_id",",");
			}else{
				if (count($products) == 1)
				{
					/* 只查找云购产品 */
					$product_ids = McyProduct::where('is_delete',0)->where('product_type',1)->first()->product_id;
				}else{
					$product_ids = '';
				}
			}
		}
		return $this->automanGoProduct($product_ids);
	}
	public function automanWelkin($request,$info)
	{	
		$category_id = $request->input('category_id');
		// $products_count = McyProduct::where('is_delete',0)->where('product_type',1)->where('category_id',$category_id)->count();
		// if ($products_count > 2)
		// {
		// 	$p = mt_rand(2,$products_count);
			$products = McyProduct::where('is_delete',0)->where('product_type',1)->where('category_id',$category_id)->get();
		// }else{
		// 	$products = McyProduct::where('is_delete',0)->where('product_type',1)->where('category_id',$category_id)->get();
		// }
		if ((count($products) > 1))
		{
			$product_ids = collect($products)->implode("product_id",",");
		}else{
			if (count($products) == 1)
			{
				/* 只查找云购产品 */
				$product_ids = McyProduct::where('is_delete',0)->where('product_type',1)->first()->product_id;
			}else{
				$product_ids = '';
			}
		}
		$type = 3;
		return $this->automanGoProduct($product_ids,$type,$request);
	}
	/* 首先购买一件 */
	public function automanGoProduct($product_ids,$type=2,$request='')
	{
		set_time_limit(0);
		if ($type ==1 )
		{
			/* 一件商品的ID */
			$product_id = $product_ids;
			return $this->auto_buy_one_product($product_id);
		}elseif ($type == 3)
		{
			$auto_s_count = $request->input('auto_s_count');
			$auto_e_count = $request->input('auto_e_count');
			$center_time = $request->input('center_time');
			$is_auto = $request->input('is_auto');
			if ($product_ids !== '')
			{
				$products = explode(",",$product_ids);
				$str = '';
				foreach ($products as $key => $product) {
					
					$str .= $this->auto_buy_one_product($product,$auto_s_count,$auto_e_count,$is_auto,$center_time)."<br>";
				}
				return $str;
			}else{
				return "没有需要测试购买的产品1";
			}
		}else{
			if ($product_ids !== '')
			{
				$products = explode(",",$product_ids);
				$str = '';
				foreach ($products as $key => $product) {
					$str .= $this->auto_buy_one_product($product)."<br>";
				}
				return $str;
			}else{
				return "没有需要测试购买的产品";
			}
		}
		return "";
	}

	public function auto_buy_one_product($product_id,$auto_s_count=0,$auto_e_count=0,$is_auto=1,$center_time=2)
	{
		// $t = mt_rand(0,2);
		$t = mt_rand(0,$center_time);
		sleep($t);
		$product_id = $product_id;
		/*　找出这件商品 */
		$product = McyProduct::where('is_delete',0)->where('product_id',$product_id)->first();
		if ($product)
		{
			/* 设置go_auto */
			$product->go_auto = $is_auto;
			$product->save();
			/* 找出测试小伙胖 */
			$robot_user = McyUser::where('is_delete',0)->where('is_robot',1)->get()->random(1)->first();
			// echo $robot_user->username;
			// dd($robot_user->money);
			/* 找出云购表 */
			$yungou_shop = McyYunGou::where('is_delete',0)->where('shenyurenshu','>',0)->where('product_id',$product_id)->orderBy('qishu','desc')->orderBy('sort','desc')->first();
			/* 随机购买数量 */
			if ($yungou_shop)
			{
		                if ($is_auto == 0 && $yungou_shop->zhiding ==  0) {$yungou_shop->zhiding = 1; $yungou_shop->save();}else{}
				if (($auto_s_count <= 0) || ( $auto_e_count <= 0) )
				{
					if ($yungou_shop->shenyurenshu > 5)
					{
						$yungou_number= mt_rand(1,6);
					}else{
						$yungou_number= mt_rand(1,($yungou_shop->shenyurenshu));
					}
				}else{
					if ($yungou_shop->shenyurenshu <= $auto_e_count)
					{
						// 人数不足
						if ($yungou_shop->shenyurenshu > 5)
						{
							$yungou_number= mt_rand(1,6);
						}else{
							$yungou_number= mt_rand(1,($yungou_shop->shenyurenshu));
						}	
					}else{
						// 人数足够
						$yungou_number= mt_rand($auto_s_count,$auto_e_count);
					}
				}
			
				/* 一共需要多少钱 */
				$all_price = $yungou_shop->price * $yungou_number;

				/* 判断账户是否有钱 ,不够充值 */
				if ($robot_user->money > $all_price)
				{
					// $robot_user->money -= $all_price;
					// $robot_user->save();
				}else{
					$robot_user->money += 10000;
					$robot_user->score += 10000;
					$robot_user->save();
				}
				/* 生成订单 */
				$order = new McyOrder;
				$order->product_id = $product_id;
				$order->qishu = $yungou_shop->qishu;
				$order->product_name = $product->product_name;
				$order->order_type = 1;
				$order->order_no = date("YmdHis",time()).$product_id.mt_rand(0,9);
				$order->order_price = $all_price;
				$order->order_user_id = $robot_user->mcy_user_id;
				$order->order_username = $robot_user->username;
				/* 为支付 */
				$order->order_status = 1;
				$order->save();

				/* 支付成功生成云购码 */
				/* 扣掉费用 生成支付单 */
				$robot_user->money -= $all_price;
				$robot_user->save();
				$order->order_status = 2;
				$order->save();

				/* 回调后处理信息 */

				/* 生成云购码 */
				// 找出现有的剩余码
				$yungou_shop1 = McyYunGou::where('is_delete',0)->where('shenyurenshu','>',0)->where('product_id',$order->product_id)->orderBy('qishu','desc')->orderBy('sort','desc')->first();
				$robot_user1 = McyUser::where('is_delete',0)->where('is_robot',1)->where('mcy_user_id',$order->order_user_id)->first();
				$shengyuma = explode(",",$yungou_shop1->shengyuma);
				/* 从中剔除购买的两 */
				// echo $yungou_number;
				$yungouma = collect($shengyuma)->random($yungou_number)->toArray();

				/* 购买之后剩下的码数*/
				$sym = array_diff($shengyuma,$yungouma);
				/* 购买之后的剩余人数 */
				$syrs = $yungou_shop1->shenyurenshu - $yungou_number;
				/* 生成云购订单 */
				$yungou_order = new McyYunGouOrder;
				$yungou_order->product_id = $order->product_id;
				$yungou_order->order_id = $order->order_id;
				$yungou_order->status = $order->order_status;
				$yungou_order->qishu = $yungou_shop1->qishu;
				$yungou_order->mcy_user_id = $order->order_user_id;
				$yungou_order->product_name = $order->product_name;
				$yungou_order->yungouma = implode(",",$yungouma);
				$yungou_order->allprice = $all_price;
				DB::beginTransaction();
				/* 成功就commit */
				if ($yungou_order->save())
				{
					/* 去掉购物信息*/
					$yungou_shop1->shengyuma =  implode(",",$sym);;
					$yungou_shop1->shenyurenshu = $syrs;
					$yungou_shop1->save();
					$str = "用户：".$robot_user1->username." 购买了 :ID为".$product_id."的".$product->product_name."商品 ".$yungou_number." 人次,共花了".$all_price."元";
					$robot_user1->save();
					DB::commit();

 					/* 购买成功后判断是否商品已经售罄*/
					$sq = $this->checkProductIsSellOut($order->product_id,$yungou_shop1->yungou_id);
					// echo $str;
					return $str;
				}else{
					/* 支付失败就返回现金 */
					$robot_user1->money += $order->order_price;
					$robot_user1->save();
					return "购买失败";
				}

			}else{
				$yungou_shop = McyYunGou::where('is_delete',0)->where('shenyurenshu',0)->where('product_id',$product_id)->orderBy('qishu','desc')->orderBy('sort','desc')->first();
				if ($yungou_shop)
				{
					if ($yungou_shop->show_time < date('Y-m-d H:i:s'))
					{
						/* 开奖时间过了 */
						if (($yungou_shop->status == 1) && !($yungou_shop->huode_id == 0) )
						{
							$str =  "ID为".$product_id."的商品已经卖完了,用户ID为：$yungou_shop->huode_id 的用户获得这个产品"."<br>";
						}else{
							@$this->checkProductIsSellOut($yungou_shop->product_id,$yungou_shop->yungou_id);
							$str =  "ID为".$product_id."的商品倒计时结束,正在计算结果,结束时间为 $yungou_shop->show_time"."<br>";
						}
					}else{
						$str =  "ID为".$product_id."的商品已经卖完了,准备开奖倒计时"."<br>";
					}
				}else{
					$str =  "ID为".$product_id."的商品已经卖完了,等待触发倒计时"."<br>";
				}
			}
		}else{
			$str =  "没有ID为".$product_id."的商品";
		}
		return $str;
	}

	/* 判断是否商品已经售罄 */
	public function checkProductIsSellOut($product_id,$yungou_id)
	{
		/* 商品的详情 */
		$product = McyProduct::where('is_delete',0)->where('product_id',$product_id);
		/* 商品的云购信息 */
		$yungou_shop = McyYunGou::where('is_delete',0)->where('yungou_id',$yungou_id)->first();
		if ($yungou_shop)
		{
			/* 判断是否购买人数已经完结 */
			$shenyurenshu = $yungou_shop->shenyurenshu;
			if ($shenyurenshu == 0)
			{
				/* 进入倒计时 */
				$date = date('Y-m-d H:i:s');
				// dd('fie');
				if ($yungou_shop->show_time == '0000-00-00 00:00:00')
				{
					/*  初始化时间 */
					// $yungou_shop->show_time = date("Y-m-d H:i:s",strtotime($date." + 1 mins"));
  					$siteinfo = McySite::where('is_delete',0)->where('user_id',6)->first();
  					$s = strtotime($date) + $siteinfo->site_time;
					$yungou_shop->show_time = date("Y-m-d H:i:s",$s);
					$yungou_shop->check_people += 1;
					$yungou_shop->save();
					/* 触发倒计时 */
					@$this->go_product_daojishi($yungou_shop->yungou_id);
					// return true;
				}else{
					@$this->go_product_daojishi($yungou_shop->yungou_id);
					// if ($yungou_shop->show_time > $date)
					// {
						/* 正在倒计时 */
					// 	return true;
					// }else{
						/* 倒计时结束了 */
						// return false;
						/* 异步函数 触发 排队通知倒计时开奖 */
						/* 开奖结束自动判断是否进入下一期 */
						// $this->go_product_daojishi($yungou_shop->yungou_id);
					// }
					// return true;	
				}
				
			}else{
				return false;
			}
		}else{
			return false;
			// return "商品的云购信息缺失"."<br>";
		}
	}
	public function triggerRequest($url,$io=false,$post_data = array(), $cookie = array())
	{
		$method = empty($post_data) ? 'GET' : 'POST';
		$url_array = parse_url($url);		
		$port = isset($url_array['port'])? $url_array['port'] : 80; 
		if(function_exists('fsockopen')){
			$fp = @fsockopen($url_array['host'], $port, $errno, $errstr, 30);
		}elseif(function_exists('pfsockopen')){
			$fp = @pfsockopen($url_array['host'], $port, $errno, $errstr, 30);
		}elseif(function_exists('stream_socket_client')){
			$fp = @stream_socket_client($url_array['host'].':'.$port,$errno,$errstr,30);
		} else {
			$fp = false;
		}
		if(!$fp){
			return false;
		}

		$getPath = $url_array['path'] ."?". @$url_array['query'];
		$header  = $method . " " . $getPath." ";
		$header .= "HTTP/1.1\r\n";
        $header .= "Host: ".$url_array['host']."\r\n"; //HTTP 1.1 Host域不能省略
        $header .= "Pragma: no-cache\r\n";
        if(!empty($cookie)){
        	$_cookie_s = strval(NULL);
        	foreach($cookie as $k => $v){
        		$_cookie_s .= $k."=".$v."; ";
        	}
        	$_cookie_s = rtrim($_cookie_s,"; ");
                $cookie_str =  "Cookie: " . base64_encode($_cookie_s) ." \r\n";	   //传递Cookie
                $header .= $cookie_str;
            }
            $post_str = '';
            if(!empty($post_data)){
            	$_post = strval(NULL);
            	foreach($post_data as $k => $v){
            		$_post .= $k."=".urlencode($v)."&";
            	}
            	$_post = rtrim($_post,"&");
                $header .= "Content-Type: application/x-www-form-urlencoded\r\n";//POST数据
                $header .= "Content-Length: ". strlen($_post) ." \r\n";//POST数据的长度	
                $post_str = $_post."\r\n"; //传递POST数据
            }
            $header .= "Connection: Close\r\n\r\n";
            $header .= $post_str;
            $data = fwrite($fp,$header);
            WechatLog::info($data." triggerRequest");
            if($io){		
            	while (!feof($fp)){ 
            		echo fgets($fp,1024);
            	}
            }   
            return true;
        }
	public function _sock($url) {
		$host = parse_url($url,PHP_URL_HOST);
		$port = parse_url($url,PHP_URL_PORT);
		$port = $port ? $port : 80;
		$scheme = parse_url($url,PHP_URL_SCHEME);
		$path = parse_url($url,PHP_URL_PATH);
		$query = parse_url($url,PHP_URL_QUERY);
		if($query) $path .= '?'.$query;
		if($scheme == 'https') {
			$host = 'ssl://'.$host;
		}

		$fp = fsockopen($host,$port,$error_code,$error_msg,1);
		if(!$fp) {
			return array('error_code' => $error_code,'error_msg' => $error_msg);
		}
		else {
		    stream_set_blocking($fp,true);//开启了手册上说的非阻塞模式
		    stream_set_timeout($fp,1);//设置超时
		    $header = "GET $path HTTP/1.1\r\n";
		    $header.="Host: $host\r\n";
		    $header.="Connection: close\r\n\r\n";//长连接关闭
		    fwrite($fp, $header);
		    usleep(1000); // 这一句也是关键，如果没有这延时，可能在nginx服务器上就无法执行成功
		    fclose($fp);
		    return array('error_code' => 0);
		}
	}
	/* 中间过度函数 */
	public function go_product_daojishi($yungou_id)
	{
		$url = url("/api/go_product_daojishi/".$yungou_id);

		// $url = "http://www.chkg99.com/api/go_product_daojishi/".$yungou_id; 
		// $url = "http://www.chkg.com/api/go_product_daojishi/".$yungou_id; 
		return $result = $this->triggerRequest($url);
	}

	/* 倒计时判断 */
	public function go_product_daojishi1(Request $request)
	{
		// dd('welkin');
		WechatLog::info('welkin 倒计时开始');
		
		ignore_user_abort(true);
		set_time_limit(0);
		$yungou_id = $request->yungou_id;
		$yungou_shop = McyYunGou::where('is_delete',0)->where('yungou_id',$yungou_id)->first();

		$date = date("Y-m-d H:i:s");
		$siteinfo = McySite::where('is_delete',0)->where('user_id',6)->first();
		
		$s = strtotime($request->show_time) + $siteinfo->site_time;
		$show_time = date("Y-m-d H:i:s",$s);
		if ($date > $show_time)
		{
			/* 当前时间已经超过倒计时时间 */
			/* 1.时间未正确配置 */
			/* 2.商品没有正常揭晓 */
				if ($yungou_shop->show_time == '0000-00-00 00:00:00' && $yungou_shop->shenyurenshu == 0)
				{
					/*  初始化时间 */
					// $yungou_shop->show_time = date("Y-m-d H:i:s",strtotime($date." + 1 mins"));
  					// $siteinfo = McySite::where('is_delete',0)->where('user_id',6)->first();
  					$s = strtotime($date) + $siteinfo->site_time;
					$yungou_shop->show_time = date("Y-m-d H:i:s",$s);
					$yungou_shop->check_people += 1;
					$yungou_shop->save();
					/* 触发倒计时 */
					@$this->go_product_daojishi($yungou_shop->yungou_id);
					// return true;
					return '';
				}else{
					// return "";
				}
		}else{

		}
		if ($yungou_shop->check_people >= 2) {return '';}else{}
			/* 正常倒计时，找出最后购买时间内，该商品的正确获奖码 */
			/* 判断是否已经获奖了 */
			/* 最后购买时间 */
			$e1 = strtotime($yungou_shop->show_time) - $siteinfo->site_time;
			$e = date("Y-m-d H:i:s",$e1);

			if ($yungou_shop->status == 1)
			{

				if ($yungou_shop->huode_id == 0)
				{
					/* 揭晓异常，已经更新状态，但是没有获奖人 */
					/* 重新获奖*/
					// return true;
				}else{
					/* 获奖正常，返回true*/
					// return true;
					// 检查是否发送模板消息
						$send_history = McySendHistory::where('is_delete',0)->where('qishu',$yungou_shop->qishu)->where('product_id',$yungou_shop->product_id)->where('mcy_user_id',$yungou_shop->huode_id)->first();
						if ($send_history)
						{

							/* 已经发送过了，返回*/
							// return true;
						}else{
							$product = McyProduct::where('is_delete',0)->where('product_id',$yungou_shop->product_id)->first();
							$mcy_user = McyUser::where('mcy_user_id',$yungou_shop->huode_id)->where('is_delete',0)->first();
							/* 没有发*/
							/*判断用户是否机器人*/
							if ($mcy_user->is_robot == 0)
							{

                                //发送中奖短信
								$send_history = new McySendHistory;
								$send_history->created_at = date('Y-m-d H:i:s');
								$send_history->updated_at = date('Y-m-d H:i:s');
								$ret = Tools\AliSMS::zhongjiang($mcy_user->mobile,$yungou_shop->huode_ma);
								$ret =json_decode($ret);
								if (@$ret->ret == 0) {
									WechatLog::info(" 发送消息：");
									$send_history->is_delete = 0;
									$send_history->qishu = $yungou_shop->qishu;
									@$send_history->product_name = @$product->product_name;
									$send_history->product_id = $yungou_shop->product_id;
									$send_history->mcy_user_id = $yungou_shop->huode_id;
									$send_history->save();
									$result = "请及时到个人中心-中奖商品填写资料";
									@$weixin_message = @$this->send_price_msg($mcy_user->openid, $product->product_name, $result);
									WechatLog::info(json_encode(@$weixin_message));
								}
							}else{
								WechatLog::info($d." 测试号不发送消息：");
							}
						}
				}

			}else{
				if (!($yungou_shop->huode_id == 0))
				{
					/*已经获奖了*/
					return true;
				}else{}
				// if ($yungou_shop->check_people >=1 )
				// {
				// 	return true;
				// }else{}
				/* 状态正常，进入获奖程序 */
				/* 找出最后购买时间前一百条记录 */
				$yungou_orders = McyYunGouOrder::where('is_delete',0)->where('created_at','<',$e)->limit(100)->select(array('created_at','mcy_user_id','is_update','yungouma','go_id'))->orderBy('created_at','desc')->get();
				$he = floatval(0);
				$ceshi_id = 0;

				foreach($yungou_orders as $key => $yungou_order)
				{
					if ($key == 0){$s2 = $yungou_order->created_at;}

					/* 合并用户信息 */
					// $mcy_u = McyUser::where('mcy_user_id',$yungou_order->mcy_user_id)->first();
					$he += strtotime($yungou_order->created_at);
					// $yungou_order->is_robot = $mcy_u->is_robot;
					// if (($mcy_u->is_robot == 1) && !($ceshi_id == 0))
					// {
						// if ($yungou_order->zhiding <= 1){
						// 	$yungou_order->zhiding = $mcy_u->mcy_user_id;
						// }else{}
						// $ceshi_id = $mcy_u->mcy_user_id;
						// $ceshi_ma = explode(",",$yungou_order->yungouma)[0];
						// $ceshi_order_id = $yungou_order->go_id;
						// $ceshi_order_time = $yungou_order->created_at;
					// }else{}
					// $yungou_order->yungouma = $mcy_u->yungouma;
					$e2 = $yungou_order->created_at;
				}
				$yu = fmod($he,$yungou_shop->zongshu);
				$huode_ma = 1 + $yu;
				/* 找出改产品的所有订单，历遍查询获奖单号*/
				$orders = McyYunGouOrder::where('qishu',$yungou_shop->qishu)->where('is_delete',0)->where('product_id',$yungou_shop->product_id)->get();
				$t11 = mt_rand(0,count($orders) - 1);
				foreach($orders as $key => $order)
				{
					$mcy_u = McyUser::where('mcy_user_id',$order->mcy_user_id)->first();
					if (($mcy_u->is_robot == 1) && ($ceshi_id == 0))
					{
						if ($yungou_shop->zhiding <= 1){
							if ($key >= $t11) {
								$yungou_shop->zhiding = $mcy_u->mcy_user_id;
								$ceshi_id = $mcy_u->mcy_user_id;
								@$ma = explode(",",$order->yungouma);
								$w_t = count($ma);
                                if($w_t == 1){ $t = 0;}else{ 
								    $t = mt_rand(0,($w_t - 1));
                                }
								$ceshi_ma = $ma[$w_t - 1];
                                #$ceshi_ma = explode(",",$order->yungouma)[0];
								WechatLog::info('welkin 测试码'.$ceshi_ma);
								WechatLog::info('welkin 测试码次数'.count($ma));
								$ceshi_order_id = $order->go_id;
								$ceshi_order_time = $order->created_at;
							}else{}
						}else{}
					}else{}

					/* 把购买的码数换成数组 */
					$goumai_ma = explode(",",$order->yungouma);
					if (in_array($huode_ma,$goumai_ma))
					{
						$huode_id = $order->mcy_user_id;
						$huode_order_id = $order->go_id;
						$huode_order_time = $order->created_at;
					}else{
						// 没有记录，正常不存在……
					}
				}

				if ($yungou_shop->zhiding <= 1 && $ceshi_id > 0)
				{
					$huode_id = $ceshi_id;
					$huode_ma = $ceshi_ma;
					$huode_order_id = $ceshi_order_id;
					$huode_order_time = $ceshi_order_time;
				}else{}
				$mcy_user = McyUser::where('is_delete',0)->where('mcy_user_id',$huode_id)->first();
				$yungou_shop->huode_id = $huode_id;
				$yungou_shop->huode_order_id = $huode_order_id;
				$yungou_shop->huode_order_time = $huode_order_time;
				$yungou_shop->huode_ma = 1000000 + $huode_ma;
				$yungou_shop->status = 1;
				/* 判断是否制定 */
				if ($yungou_shop->zhiding == 0)
				{
					
				}else{
					/* 是否全局指定机器人 */
					if ($yungou_shop->zhiding == 1)
					{
						/* 测试 */
						/* 判断获奖人是否机器人 */
						if ($mcy_user->is_robot == 0)
						{
							/* 非机器人，修改日期*/
							/* 找出购买记录中，有参与购买的测试账号 */
							/* 找出两码之间的差值修改数据 */
							if ($ceshi_id == 0)
							{
								/* 没有测试号，不管*/
							}else{
								if ($ceshi_ma > $huode_ma)
								{
									$cha = $ceshi_ma - $huode_ma;
								}else{
									$cha = $huode_ma - $ceshi_ma;
								}
								/* 找出差值区间数据 */
								// $s2 = date("Y-m-d H:i:s",(strtotime($s2) - $cha)); 
								// $e2 = date("Y-m-d H:i:s",(strtotime($e2) + $cha));
								@$yt = McyYunGouOrder::where('is_delete',0)->where('is_update',0)->whereBetween('created_at',[$e2,$s2])->orderBy('created_at','desc')->get()->random(1)->first();
								if ($yt)
								{
									// $yt->created_at = date("Y-m-d H:i:s",(strtotime($yt->created_at) - $cha));
									$yt->update_number = $cha;
									$yt->is_update = $mcy_user->mcy_user_id;
									$yt->save();
									// foreach($yungou_orders as $yo)
									// {
									// 	$yo->is_update = 1;
									// 	$yo->save();
									// }
									/* 狸猫换太子 */
									$yungou_shop->huode_id = $huode_id = $ceshi_id;
									$yungou_shop->huode_order_id = $huode_order_id =  $ceshi_order_id;
									$yungou_shop->huode_order_time = $huode_order_time =  $ceshi_order_time;
									$yungou_shop->huode_ma = $huode_ma = 1000000 + $ceshi_ma;
									$yungou_shop->status = 1;
									$mcy_user = McyUser::where('is_delete',0)->where('mcy_user_id',$ceshi_id)->first();
								}else{}
							}
						}else{}
					}else{
					// 特定编号狸猫换太子
						/*找出购买记录*/
						$t_order = McyYunGouOrder::where('qishu',$yungou_shop->qishu)->where('is_delete',0)->where('product_id',$yungou_shop->product_id)->where('mcy_user_id',$yungou_shop->zhiding)->first();
						if ($t_order)
						{
							$ceshi_id = $yungou_shop->zhiding;
							#$ceshi_ma = explode(",",$t_order->yungouma)[0];
                            @$ma = explode(",",$t_order->yungouma);
                            $w_t = count($ma);
                            if($w_t == 1){ $t = 0;}else{ 
                                $t = mt_rand(0,($w_t - 1));
                            }
                            $ceshi_ma = $ma[$w_t - 1];
                            WechatLog::info('welkin 测试码'.$ceshi_ma);
							$ceshi_order_id = $t_order->go_id;
							$ceshi_order_time = $t_order->created_at;
							if ($ceshi_ma > $huode_ma)
							{
								$cha = $ceshi_ma - $huode_ma;
							}else{
								$cha = $huode_ma - $ceshi_ma;
							}
							/* 找出差值区间数据 */
							// $s2 = date("Y-m-d H:i:s",(strtotime($s2) - $cha)); 
							// $e2 = date("Y-m-d H:i:s",(strtotime($e2) + $cha));
							@$yt = McyYunGouOrder::where('is_delete',0)->where('is_update',0)->whereBetween('created_at',[$e2,$s2])->orderBy('created_at','desc')->get()->random(1)->first();
							// if ($yt)
							// {
							// 	// $yt->created_at = date("Y-m-d H:i:s",(strtotime($yt->created_at) - $cha));
								@$yt->update_number = $cha;
								@$yt->is_update = $yungou_shop->zhiding;
								// $yt->is_update =1;
								@$yt->save();
								// foreach($yungou_orders as $yo)
								// {
								// 	$yo->is_update = 1;
								// 	$yo->save();
								// }
								/* 狸猫换太子 */
								$yungou_shop->huode_id = $huode_id = $ceshi_id;
								$yungou_shop->huode_order_id = $huode_order_id =  $ceshi_order_id;
								$yungou_shop->huode_order_time = $huode_order_time =  $ceshi_order_time;
								$yungou_shop->huode_ma = $huode_ma = 1000000 + $ceshi_ma;
								$yungou_shop->status = 1;
								$mcy_user = McyUser::where('is_delete',0)->where('mcy_user_id',$ceshi_id)->first();
							// }else{}

						}else{}
					}
					
				}
				// $yos = McyYunGouOrder::where('is_delete',0)->where('created_at','<',$e)->limit(100)->select(array('created_at','mcy_user_id','is_update','yungouma','go_id'))->orderBy('created_at','desc')->get();
				// foreach($yos as $yo)
				// {
				// 	$yo->is_update = 1;
				// 	$yo->save();
				// }
				if($yungou_shop->save())
				{
					/* 当期商品完成 ,进去下一期*/
					$product = McyProduct::where('is_delete',0)->where('product_id',$yungou_shop->product_id)->first();
					if ($product->qishu < $yungou_shop->qishu)
					{
						$qishu = $yungou_shop->qishu + 1;
						$result = $this->xyq($product,$qishu);
					}else{
						/* 期数已满,不进入下一期 */
					}
					/* 循环，等待时间发送消息*/
					while(1)
					{
						sleep(2);
						$d = date('Y-m-d H:i:s');
						WechatLog::info($d." => ".$yungou_shop->show_time);
						/* 判断时间是否到了 */
						// if (strtotime($d) >= strtotime($e))
						// {
							/* 找出是否已经发送了 */
							$send_history = McySendHistory::where('is_delete',0)->where('qishu',$yungou_shop->qishu)->where('product_id',$yungou_shop->product_id)->where('mcy_user_id',$huode_id)->first();
							if ($send_history)
							{
								/* 已经发送过了，返回*/
								// return true;
								break;
							}else{
								/* 没有发*/
								/*判断用户是否机器人*/
								if ($mcy_user->is_robot == 0)
								{
									//发送中奖短信
									$send_history = new McySendHistory;
									$send_history->created_at = date('Y-m-d H:i:s');
									$send_history->updated_at = date('Y-m-d H:i:s');
									$ret = Tools\AliSMS::zhongjiang($mcy_user->mobile,$yungou_shop->huode_ma);
									$ret =json_decode($ret);
									if (@$ret->ret == 0) {
										WechatLog::info(" 发送消息：");
										$send_history->is_delete = 0;
										$send_history->qishu = $yungou_shop->qishu;
										@$send_history->product_name = @$product->product_name;
										$send_history->product_id = $yungou_shop->product_id;
										$send_history->mcy_user_id = $yungou_shop->huode_id;
										$send_history->save();
										$result = "请及时到个人中心-中奖商品填写资料";
										@$weixin_message = @$this->send_price_msg($mcy_user->openid, $product->product_name, $result);
										WechatLog::info(json_encode(@$weixin_message));
									}
									break;
								}else{
									$d = date('Y-m-d H:i:s');
									WechatLog::info($d." 测试号不发送消息：");
									break;
								}
								// return true;
							}
						// }else{
						// }
					}
					return true;
				}else{
					return false;
				}
			}
		/* 判断时间 */
		// return $yungou_shop;
		// if ($yungou_shop)
		// {

		// 	/* 判断剩余人数 */
		// 	$shenyurenshu = $yungou_shop->shenyurenshu;
		// 	if ($shenyurenshu == 0)
		// 	{
		// 		/* 判断时间 */
		// 		/* 3分卡栈循环判断时间 */
		// 		while(1)
		// 		{
		// 			/* 当前时间 */
		// 			sleep(2);
		// 			$date = date('Y-m-d H:i:s');
		// 			WechatLog::info($date." => ".$yungou_shop->show_time);
		// 			if ($date > $yungou_shop->show_time)
		// 			{
		// 				/* 倒计时时间过了 判断是否已经有人获奖 */
		// 				if (($yungou_shop->status == 1) && !($yungou_shop->huode_id == 0))
		// 				{
		// 					/* 奖品已经产生获得者，不进入倒计时 */
		// 					/* 跳出循环 */
		// 					/* 判断是否有下一期*/
		// 					$product = McyProduct::where('is_delete',0)->where('product_id',$yungou_shop->product_id)->first();
		// 					if ($product->qishu < $yungou_shop->qishu)
		// 					{
		// 						$qishu = $yungou_shop->qishu + 1;
		// 						$result = $this->xyq($product,$qishu);
		// 					}else{
		// 						/* 期数已满,不进入下一期 */
		// 					}
		// 					// break;
		// 					return 1;
		// 				}else{
		// 					if ($yungou_shop->huode_id == 0)
		// 					{
		// 						/* 判断是否是指定产品 */
		// 						if ($yungou_shop->zhiding ==0)
		// 						{
		// 							/* 找出开奖时间最新购买的100条数据 */
		// 							$yungou_orders = McyYunGouOrder::where('is_delete',0)->where('created_at','<',$yungou_shop->show_time)->limit(100)->select('created_at')->orderBy('created_at','desc')->get();
		// 							$he = floatval(0);
		// 							foreach($yungou_orders as $yungou_order)
		// 							{
		// 								$he += strtotime($yungou_order->created_at);
		// 							}
		// 							// $yu = $he % $yungou_shop->zongshu;
		// 							$yu = fmod($he,$yungou_shop->zongshu);
		// 							$huode_ma = 1 + $yu;
		// 							// echo $he." ".$yu." ".$huode_ma;
		// 							/* 找出改产品的所有订单，历遍查询获奖单号*/
		// 							$orders = McyYunGouOrder::where('qishu',$yungou_shop->qishu)->where('is_delete',0)->where('product_id',$yungou_shop->product_id)->get();
		// 							foreach($orders as $order)
		// 							{
		// 								/* 把购买的码数换成数组 */
		// 								$goumai_ma = explode(",",$order->yungouma);
		// 								if (in_array($huode_ma,$goumai_ma))
		// 								{
		// 									$huode_id = $order->mcy_user_id;
		// 									$huode_order_id = $order->go_id;
		// 									$huode_order_time = $order->created_at;
		// 									// $huode_id = $order->mcy_user_id;
		// 								}else{
		// 									// echo $order->yungou_id;
		// 								}
		// 							}
		// 							$yungou_shop->huode_id = $huode_id;
		// 							$yungou_shop->huode_order_id = $huode_order_id;
		// 							$yungou_shop->huode_order_time = $huode_order_time;
		// 							$yungou_shop->huode_ma = 1000000 + $huode_ma;
		// 							$yungou_shop->status = 1;
		// 							if($yungou_shop->save())
		// 							{
		// 								/* 当期商品完成 ,进去下一期*/
		// 								$product = McyProduct::where('is_delete',0)->where('product_id',$yungou_shop->product_id)->first();
		// 								if ($product->qishu < $yungou_shop->qishu)
		// 								{
		// 									$qishu = $yungou_shop->qishu + 1;
		// 									$result = $this->xyq($product,$qishu);
		// 								}else{
		// 									/* 期数已满,不进入下一期 */
		// 								}
		// 								return true;
		// 							}else{
		// 								return false;
		// 							}

		// 						}else{
									
		// 							/* 找出开奖时间最新购买的100条数据 */
		// 							$yungou_orders = McyYunGouOrder::where('is_delete',0)->where('created_at','<',$yungou_shop->show_time)->limit(100)->select('created_at')->orderBy('created_at','desc')->get();
		// 							$he = floatval(0);
		// 							foreach($yungou_orders as $yungou_order)
		// 							{
		// 								$he += strtotime($yungou_order->created_at);
		// 							}
		// 							// $yu = $he % $yungou_shop->zongshu;
		// 							$yu = fmod($he,$yungou_shop->zongshu);
		// 							$huode_ma = 1 + $yu;
		// 							// echo $he." ".$yu." ".$huode_ma;
		// 							/* 找出改产品的所有订单，历遍查询获奖单号*/
		// 							$orders = McyYunGouOrder::where('qishu',$yungou_shop->qishu)->where('is_delete',0)->where('product_id',$yungou_shop->product_id)->get();
		// 							foreach($orders as $order)
		// 							{
		// 								/* 把购买的码数换成数组 */
		// 								$goumai_ma = explode(",",$order->yungouma);
		// 								if (in_array($huode_ma,$goumai_ma))
		// 								{
		// 									$huode_id = $order->mcy_user_id;
		// 									$huode_order_id = $order->go_id;
		// 									$huode_order_time = $order->created_at;
		// 									// 找出测试ID与实际的差值
		// 									// 改变原来的时间，更新字段
		// 									// 替换踢掉
		// 									// $huode_id = $order->mcy_user_id;
		// 								}else{
		// 									// echo $order->yungou_id;
		// 								}
		// 							}
		// 							$yungou_shop->huode_id = $huode_id;
		// 							$yungou_shop->huode_order_id = $huode_order_id;
		// 							$yungou_shop->huode_order_time = $huode_order_time;
		// 							$yungou_shop->huode_ma = 1000000 + $huode_ma;
		// 							$yungou_shop->status = 1;
		// 							if($yungou_shop->save())
		// 							{
		// 								/* 当期商品完成 ,进去下一期*/
		// 								$product = McyProduct::where('is_delete',0)->where('product_id',$yungou_shop->product_id)->first();
		// 								if ($product->qishu < $yungou_shop->qishu)
		// 								{
		// 									$qishu = $yungou_shop->qishu + 1;
		// 									$result = $this->xyq($product,$qishu);
		// 								}else{
		// 									/* 期数已满,不进入下一期 */
		// 								}
		// 								return true;
		// 							}else{
		// 								return false;
		// 							}
		// 						}
		// 					}else{
		// 						/* 奖品已经产生获得者，不进入倒计时 */
		// 						/* 改变云购记录状态 */
		// 						$yungou_shop->status = 1;
		// 						$yungou_shop->save();
		// 						return false;
		// 					}
		// 				}
		// 			}else{
		// 				/* 正在倒计时 */
		// 				// return false;
		// 				/* 当前时间比揭晓时间大，说明商品已经揭晓过了 */
		// 				/* 判断是否已经有获奖人数，没有的话重置倒计时 */
		// 				// sleep(1);
		// 				// if ((!$yungou_shop->huode_id ==0))
		// 				// {
		// 				// 	$yungou_shop->show_time = '0000-00-00 00:00:00';
		// 				// 	$yungou_shop->save();
		// 				// 	$this->go_product_daojishi($yungou_shop->yungou_id);
		// 				// 	return false;
		// 				// }else{
		// 				// 	return true;
		// 				// }
		// 			}
		// 		}
		// 	}else{

		// 		return 0;
		// 	}

		// }else{
		// 	return 0;
		// }

	}

	public function random_go_buy($product_ids)
	{
		/* 随机人数 */
		$all_robot_user = McyUser::where('is_delete',0)->where('is_robot',1)->count();
		if ($all_robot_user <= 0) { 
			echo $this->add_robot(3);
			return "没有机器人，请添加机器人后再开启测试";
		}
		$user_random = mt_rand(1,$all_robot_user);
		$admin_id = \Session::get('admin_id');
		$mcy_user = McyUser::where('user_id',$admin_id)->where('is_delete',0)->get()->random($user_random);

		/* 随机商品 */
		// 102行已经转换过了
		// $product_ids = explode(",", $product_ids);
		$products_count = count($product_ids); 

		$arr=$product_ids;
		shuffle($arr);
		$arr=array_slice($arr,0,$products_count);

		$buy_products = $arr;
		$products = McyProduct::whereIn('product_id',$buy_products)->where('is_delete',0)->get();

		/* 随机购买 */
		foreach ($mcy_user as $user) {
			/* 加入购物车并支付 */
			$q1 = $this->addToCart($user,$products);
			/* 支付完成 */
			if ((@$q1->ret)){ 
				return "加入购物车失败" ;
			}else{
				$str = "用户".$user->username.$q1->msg;
				return $str;
			}
			/*支付失败*/
		}
	}

	public function addToCart($user,$products)
	{
		$response = new ApiResponse;
		$cart = new McyYunGouCart;
		$cart->mcy_user_id = $user->mcy_user_id;
		$a = array();
		$all_price = 0;
		$str = '';

		DB::beginTransaction();
		foreach($products as $key =>  $product)
		{
			// var_dump($product->product_id);
			$a[$key]['product_id'] = $product->product_id;
			$yungou_shop = McyYunGou::where('product_id',$product->product_id)->where('shenyurenshu','>',0)->orderBy('sort','desc')->first();
			if ($yungou_shop)
			{
				if ($yungou_shop->shenyurenshu > 5)
				{
					$a[$key]['product_number'] = mt_rand(0,6);
				}else{
					$a[$key]['product_number'] = mt_rand(0,($yungou_shop->shenyurenshu));
				}
				$yungou_shop->shenyurenshu = $yungou_shop->shenyurenshu - $a[$key]['product_number'];
				$yungou_shop->save();
				$all_price += ($a[$key]['product_number'] * $yungou_shop->price);
				$str += "购买了".$a[$key]['product_number'].'人次的'.$yungou_shop->product_name.'商品ID:'.$yungou_shop->product_id;
				echo "购买了".$a[$key]['product_number'].'人次的'.$yungou_shop->product_name.'商品ID:'.$yungou_shop->product_id ;
				echo "<br>";
			}else{}
		
		}
		/* 先减去商品的剩余人数 防止卡栈*/
		$cart->products = json_encode($a);
		$cart->all_price = $all_price;

		$response->tmsg = $str;
		if ($cart->save())
		{
			/* 商品获取成功，查看钱包是否有钱，支付 */
			$q2 = $this->go_pay($user,$cart->products);
			if ($q2)
			{
				DB::commit();
				$response->ret = 0;
				return $response->toJson();
			}else{
				$response->ret = 1;
				DB::rollback();
				return $response->toJson();
			}
			// DB::commit();
			// return !false;
		}else{
			$response->ret = 1;
			DB::rollback();
			return $response->toJson();
		}
	}

	public function go_pay($user,$products)
	{
		// $cart = McyYunGouCart::where('is_delete',0)->where('status',0)->where('mcy_user_id',$user->mcy_user_id)->first();
		$products = json_decode($products);
		$product_number = count($products);
		if ($product_number > 0)
		{
			/* 判断金钱是否足够购买 */
			/* 并扣钱 */
			DB::beginTransaction();
			if ($user->money > $cart->all_price)
			{
				$user->money -= $cart->all_price;
				$user->save();
			}else{
				$user->money += 10000000;
				$user->save();
			}
			/* 循环购物生成云购码 */
			/* 写入云购单数据库　*/
			foreach($products as $key => $product)
			{
				echo $product->product_id;
			}
		}else{
			return "购物车空空，快去购物吧！";
		}
	}

	public function add_robot($number = 1)
	{
		$array = array();
		$array[] = 'welkin';
		$array[] = '老爷保号';
		$array[] = '坐等上钩';
		$array[] = '我要中车';
		$array[] = '怪狼人';
		$array[] = '感觉要中车的样子';
		$array[] = '来个大奖行不行';
		$array[] = '永恒科技';
		$array[] = 'app软件开发';
		$array[] = '奋斗的小青年';
		$array[] = '别放弃';
		$array[] = '手机壳厂家';
		$array[] = '浪迹天涯';
		$array[] = '潮州尚浪险';
		$array[] = '漫天风沙李';
		$array[] = '中无册除';
		$array[] = '木可';
		$array[] = '能让我中一次吗';
		$array[] = '平凡就好';
		$array[] = '中支大浪';
		$array[] = '自由的心';
		$array[] = '梦想家';
		$array[] = '短信响起来';
		$array[] = '老伯公保号我中';
		$array[] = '王者农药神坑';
		$array[] = '爱我吗潮惠';
		$array[] = '小邱邱';
		$array[] = '再不中毛都给你了';
		$array[] = '细姨找细丈';
		$array[] = '隔壁老婶';
		$array[] = '旅行的意义';
		$array[] = '我是奥特曼';
		$array[] = '幸福人生';
		$array[] = '深攻鲍';
		$array[] = '听天由命吧';
		$array[] = '云狗你黑我';
		$array[] = '坚持就能中';
		$array[] = '铺领姨个鸡';
		$array[] = '让我开车回家';
		$array[] = '真真假假';
		$array[] = 'sky';
		$array[] = '斌';
		$array[] = '林总';
		$array[] = '金金金杰';
		$array[] = '老4';
		$array[] = '狗逼删除';
		$array[] = 'WS毒';
		$array[] = '德古仔';
		$array[] = '老蛤蟆';
		$array[] = '八嘎不中';
		$array[] = '鲁弟';
		$array[] = '揪心的云购';
		$array[] = '老饶妹';
		$array[] = '江西人在潮州';
		$array[] = '娘娘腔';
		$array[] = '可爱的小猪';
		$array[] = '不中就成哭包';
		$array[] = '瘦子也疯狂';
		$array[] = '矮犊子';
		$array[] = '萍儿';
		$array[] = '卫浴批发';
		$array[] = '沂蒙货运';
		$array[] = 'smile life'; 
		$array[] = '十八乡之一';
		$array[] = '好扑住让我中';
		$array[] = '555-555';
		$array[] = '幸运者11';
		$array[] = '奇迹总会发生';
		$array[] = '幸运之神眷顾我';
		$array[] = '仑苍龙头组装';
		$array[] = 'I  miss u';
		$array[] = '等待手机叮咚';
		$array[] = '有下正会赢';
		$array[] = '虾丫内块鸡';
		$array[] = '欧巴桑。';
		$array[] = 'yg-先生';
		$array[] = '阿忠';
		$array[] = '小黄人123';
		$array[] = '阿童木';
		$array[] = 'AA人生回忆';
		$array[] = '春暖花开、';
		$array[] = '电器商行';
		$array[] = '广告策划';
		$array[] = '萍水相逢';
		$array[] = '昵称。';
		$array[] = '想个名太难';
		$array[] = '难得糊涂';
		$array[] = '那滋味…';
		$array[] = '梦de旋律';
		$array[] = '么么哒';
		$array[] = '梦醒人离';
		$array[] = '玛丽宝宝';
		$array[] = 'MMMMM';
		$array[] = 'mabel';
		$array[] = 'superman';
		$array[] = '小米粒';
		$array[] = '牛仔很忙';
		$array[] = '啪啪啪';
		$array[] = '钱王';
		$array[] = '水清一色';
		$array[] = '三朵兰花';
		$array[] = '杀破狼';
		$array[] = '小山';
		$array[] = '上若止水1';
		$array[] = 'YG神秘人';
		$array[] = '胜算在握';
		$array[] = '寂寞沙洲冷';
		$array[] = '数码配件供应商';
		$array[] = '说好幸福呢';
		$array[] = 'SLL';
		$array[] = '苏XXXXX';
		$array[] = 'SUNNY DAY'; 
		$array[] = '童叟无欺';
		$array[] = '未来会更好';
		$array[] = '为梦想加油';
		$array[] = 'what？?';
		$array[] = '秀美人生';
		$array[] = '无钱也快乐';
		$array[] = '习惯就好。';
		$array[] = '古道西风瘦马';
		$array[] = '啊树茶具';
		$array[] = '凤凰单丛茶批发';
		$array[] = '性福的人';
		$array[] = '敢敢术落克';
		$array[] = '输住来借钱';
		$array[] = '武哥00';
		$array[] = '大炮兄';
		$array[] = '我爸是李刚';
		$array[] = '叽叽歪歪';
		$array[] = '职业云狗';
		$array[] = '小车还是梦';
		$array[] = '天天做慈善';
		$array[] = '兴兴一下住好了';
		$array[] = '潮惠忠实粉丝';
		$array[] = '付出总有回报';
		$array[] = '遇见你最好qq';
		$array[] = '傻逼真多';
		$array[] = '陈生。';
		$array[] = '1元实现梦';
		$array[] = '老婆靠潮惠';
		$array[] = '爱做尼住做尼';
		$array[] = '改个名会好点';
		$array[] = '可以不要这样吗';
		$array[] = '该来的总会来';

		$addr = array('广东省揭阳市','广东省潮州市','广东省汕头市');
		for ($i=0; $i < count($array); $i++) { 
			$admin_id = \Session::get('admin_id');
			$site = McySite::where('is_delete',0)->where('user_id',$admin_id)->first();
			$mcy_user = new McyUser;
			$mcy_user->is_robot = 1;
			$mcy_user->user_id = $admin_id;
			$mcy_user->nickname =   $array[$i];
			$mcy_user->username =  $array[$i];
			$mcy_user->mobile =  Tools::getRandomMobile();
			$mcy_user->email =  Tools::getRandomEmail();
			$mcy_user->ip =  Tools::getRandomIP();
			$mcy_user->ip_addr = $addr[mt_rand(0,2)];
			$mcy_user->avator_img = $site->site_m_logo;
			$mcy_user->sex = mt_rand(0,2);
			$mcy_user->money = mt_rand(0,200);
			$mcy_user->score  = 0;
			$mcy_user->jingyan = 0;
			$mcy_user->is_slave = 0;
			$mcy_user->master_id = 0;
			$mcy_user->site_id = $site->site_id;
			$mcy_user->slave_money = 0;
			$mcy_user->save();
		}
	}

	public function sendBuyProductMessage($user_id,$product_id,$type)
	{
		if ($type == 1)
		{
			/* 购买产品微信消息通知 */
		}elseif ($type == 2)
		{
			/* 购买产品手机消息通知 */
		}elseif ($type == 3){
			/* 奖品获取微信通知 */
		}elseif ($type == 4){
			/* 奖品获取手机通知 */
			
		}
	}

	  /* 检查商品出错判断 */
	  public function apiFixBugProduct($product_id)
	  {
	  	$response = new ApiResponse;
	  	$product_id = $product_id;
	  	$product = McyProduct::where('product_id',$product_id)->where('is_delete',0)->first();
	  	if ($product)
	  	{

	  		$yungou_shop = McyYunGou::where('product_id',$product_id)->where('is_delete',0)->where('qishu',$product->go_now_qishu)->orderBy('sort','desc')->first();
	  		/*检查人数是否满了*/
	  		if (($yungou_shop->huode_id == 0))
	  		{
	  			$auto_result = $this->checkProductIsSellOut($product_id,$yungou_shop->yungou_id);
	  			return 1;
	  		}else{
	  			return 0;
	  		}
	  	}else{
	  		return 0;
	  		echo "没有这件商品"; 
	  	}
	  }
	  public function xyq($product,$qishu)
	  {
	  	$yungou = new McyYunGou;
	  	$yungou->product_id = $product->product_id;
	  	$yungou->qishu = $qishu;
	  	$yungou->product_name = $product->product_name;
	  	$yungou->price = $product->go_price;
	  	$yungou->shenyurenshu = $product->go_number;
	  	$yungou->zongshu = $product->go_number;
	  	$yungou->zhiding = 1;
	  	$product->go_now_qishu = $qishu;
	  	$product->go_qishu -= 1;
	  	//  判断是否已经有其他进程生成数据了
	  	sleep(0.5);
	  	$check = McyYunGou::where('product_id',$product->product_id)->where('is_delete',0)->where('qishu',$qishu)->where('product_name',$product->product_name)->first();
	  	if ($check)
	  	{
	  		return true;
	  	}else{
	  		//  判断是否show_time 正确 
	  		$c = McyYunGou::where('product_id',$product->product_id)->where('is_delete',0)->where('qishu','<',$qishu)->where('show_time','0000-00-00 00:00:00')->where('product_name',$product->product_name)->first();
	  		if ($c){
	  			return true;
	  		}else{}
	  	}
	  	$product->save();
	  	if ($product->go_number > 4000)
	  	{
	  		/*暂时不写大于4000人次数的产品*/
	  		$yungou->sort = 0;
	  	}else{
	  		$yungou->sort = 0;
	  	}
	  	$a = array();
	  	for ($i=1; $i <= ($product->go_number); $i++) { 
	  		$a[] = $i;
	  	}
	  	$yungou->shengyuma = implode(",",$a);
	  	if ($yungou->save())
	  	{
	  		return true;
	  	}else{
	  		return false;
	  	}
	  }
	 
    public function send_price_msg($touser, $name, $result){
            ignore_user_abort(true); 
            set_time_limit(0);
            $postData['touser'] = $touser;
            $postData['template_id'] = 'AbHyycX9vKiv7iMrKDTvqar8PPzlitQ8rubO6wj7KUc';
            $postData['url'] = "http://yyg2.chkg99.com/mcy/user/huode_list";
            $postData['data'] = array(
                "first" => array(
                    "value" => "尊敬的客户，您购买的商品已中奖",
                    "color" => "#173177"
                ),
                "keyword1" => array(
                    "value" => $name,
                    "color" => "#173177"
                ),
                "keyword2" => array(
                    "value" => $result,
                    "color" => "#173177"
                ),
                "keyword3" => array(
                    "value" => '',
                    "color" => "#173177"
                ),
                "keyword4" => array(
                    "value" => '',
                    "color" => "#173177"
                ),
                "keyword5" => array(
                    "value" => '',
                    "color" => "#173177"
                ),
                "remark" => array(
                    "value" => "感谢您的购买",
                    "color" => "#173177"
                )
            );

            //提交数据
            $wxinfo = McyWxInfo::where('wxinfo_id',8)->first();
            WxPayConfig::$APPID = $wxinfo->appid;
            WxPayConfig::$APPSECRET = $wxinfo->appsecret;
            $accessToken = WeixinUtil::get_access_token();
            $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$accessToken}";
            $json = json_encode($postData);
            $result = json_decode($this->postCurl($url, $json), true);
        } 
      public function postCurl($url,$post){
       $ch = curl_init();                    
       curl_setopt($ch, CURLOPT_URL, $url);//url  
       curl_setopt($ch, CURLOPT_POST, 1);  //post
       curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       $res =  curl_exec($ch); //输出
       curl_close($ch);
      }
}
