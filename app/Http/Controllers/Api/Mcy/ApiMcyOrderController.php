<?php

namespace App\Http\Controllers\Api\Mcy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Mcy\McyAutoManController as AutoMan;
use App\Tools;
use App\Response;
use App\ApiResponse;
use App\Model\McyUser;
use App\Model\McyProduct;
use App\Model\McyYunGou;
use App\Model\Category;
use App\Model\McyOrder;
use App\Model\McyYunGouOrder;
use App\Model\McyPay;
use App\Tools\WeixinUtil;
use App\Tools\WXPAY\Lib\WxPayConfig;
use App\Tools\MyLog\WechatLog;
use App\Model\McyWxInfo;

class ApiMcyOrderController extends Controller
{
	public function apiOrderZhiDing(Request $request)
	{
		$response = new ApiResponse;
		$yungou_id = $request->input('yungou_id');
		$mcy_user_id = $request->input('mcy_user_id');
		$yungou_shop = McyYunGou::where('is_delete',0)->where('yungou_id',$yungou_id)->first();
		$mcy_user = McyUser::where('mcy_user_id',$mcy_user_id)->where('is_delete',0)->first();
		if ($yungou_shop)
		{
			if ($mcy_user)
			{
				$yungou_shop->zhiding = $mcy_user->mcy_user_id;
				if ($yungou_shop->save())
				{
					return $response->reply(0,'ok');
				}else{
					return $response->reply(3,'bad');
				}
			}
		}
		$response->input = $request->input;
		return $response->reply(3,'参数错误');
	}
	public function apiSendOrderUpdate(Request $request)
	{
		$response = new ApiResponse;
		$yungou_id = $request->input('yungou_id');
		$admin_id = $request->input('admin_id');
		$order_kd = $request->input('order_kd');
		$order_kd_number = $request->input('order_kd_number');
		$model = 'App\Model\McyYungou';
		$data = array(
			'order_kd' => $order_kd,
			'order_kd_number' => $order_kd_number,
            'order_deal'=>3//已发货处理
			);
		$search = array(
			'yungou_id'=>$yungou_id,
			'is_delete'=>0,
			);
		
		$result = $response->update($model,$search,$data);
		return $response->toJson();
	}
	public function apiWithDrawOk(Request $request)
	{
		$response = new ApiResponse;
		$admin_id = $request->session()->get('admin_id');
		if ($admin_id)
		{

		}else{
			return $response->reply(3,'请重新登录');
		}
		$withdraw_id = $request->input('withdraw_id');
		$response->withdraw_id = $withdraw_id;
		$model = 'App\Model\McyWithDraw';
		$search = array(
			'withdraw_id' => $withdraw_id,
			'is_delete' => 0,
			'status' => 0,
			);
		$data = array(
			'status'=>1,
			);
		$result = $response->update($model,$search,$data);
		return $response->toJson();
	}
	public function apiSendOrderSendMessage(Request $request)
	{
		$response = new ApiResponse;
		$order_id = $request->input('sends_id');
		$product_name = $request->input('product_name');
		$order = McyOrder::where('is_delete',0)->where('order_id',$order_id)->first();
		if ($order)
		{

			if(empty($order->order_mobile) || empty($order->order_addr) || empty($order->order_people)){
				return $response->reply(2,'客户还没填写发货信息');
			}
			//$mcy_user = McyUser::where('is_delete',0)->where('mcy_user_id',$order->order_user_id)->first();
			// $yungou_order = @McyYunGouOrder::where('is_delete',0)->where('huode_id',$order->order_user_id)->first();
			//发送发货短信通知
			Tools\AliSMS::shipping($order->order_mobile,$order->order_no);
			return $response->reply(0,'ok');
		}else{
			return $response->reply(23,'bad');
		}
	}
	public function apiSendOrderSendMessage1(Request $request)
	{
		$response = new ApiResponse;
		$order_id = $request->input('sends_id');
		$order = McyOrder::where('is_delete',0)->where('order_id',$order_id)->first();
		if ($order)
		{
			$mcy_user = McyUser::where('is_delete',0)->where('mcy_user_id',$order->order_user_id)->first();
			// $yungou_order = McyYunGouOrder::where('is_delete',0)->where('order_id',$order->order_id)->first();
			$send_weixin = $this->send_tixing_msg($mcy_user->openid,$order->created_at);
			return $response->reply(0,'发送成功');
		}else{
			return $response->reply(23,'bad');
		}
	}
	public function send_price_msg($touser, $name, $kd,$kd_number,$addr){
            $postData['touser'] = $touser;
            $postData['template_id'] = 'vXKpPcwv2jEIz2Ph72aJ7TOh6uSvn34kSEayk7kBjfo';
            $postData['url'] = "http://yyg2.chkg99.com/mcy/user";
            $postData['data'] = array(
                "first" => array(
                    "value" => "尊敬的客户，您购买的商品已发货,请注意查收",
                    "color" => "#173177"
                ),
                "keyword1" => array(
                    "value" => $name,
                    "color" => "#173177"
                ),
                "keyword2" => array(
                    "value" => $kd,
                    "color" => "#173177"
                ),
                "keyword3" => array(
                    "value" => $kd_number,
                    "color" => "#173177"
                ),
                "keyword4" => array(
                    "value" => $addr,
                    "color" => "#173177"
                ),
                "remark" => array(
                    "value" => "欢迎您再次光临!",
                    "color" => "#173177"
                )
            );

            $wxinfo = McyWxInfo::where('wxinfo_id',8)->first();
            WxPayConfig::$APPID = $wxinfo->appid;
            WxPayConfig::$APPSECRET = $wxinfo->appsecret;
            $accessToken = WeixinUtil::get_access_token();
            $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$accessToken}";
            $json = json_encode($postData);
            // $result = json_decode($this->postCurl($url, $json), true);     
            $result = $this->postCurl($url, $json);     
        } 
	public function send_tixing_msg($touser, $time){
            $postData['touser'] = $touser;
            $postData['template_id'] = '6ZiUh5ijkI_zdGT0AYtRPfUBHMZUnfb6Qien9PvmKWo';
            $postData['url'] = "http://yyg2.chkg99.com/mcy/user";
            $postData['data'] = array(
                "first" => array(
                    "value" => "尊敬的客户，请您及时填写收货地址",
                    "color" => "#173177"
                ),
                "time" => array(
                    "value" => $time,
                    "color" => "#173177"
                ),
                "remark" => array(
                    "value" => "您有奖品尚未填写地址信心，请在24小时内提交!",
                    "color" => "#173177"
                )
            );

            $wxinfo = McyWxInfo::where('wxinfo_id',8)->first();
            WxPayConfig::$APPID = $wxinfo->appid;
            WxPayConfig::$APPSECRET = $wxinfo->appsecret;
            $accessToken = WeixinUtil::get_access_token();
            $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$accessToken}";
            $json = json_encode($postData);
            // $result = json_decode($this->postCurl($url, $json), true);     
            $result = $this->postCurl($url, $json);     
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
