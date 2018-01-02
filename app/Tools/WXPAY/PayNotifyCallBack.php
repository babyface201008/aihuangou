<?php namespace App\Tools\WXPAY;

use App\Tools\WXPAY\Lib\WxPayOrderQuery;
use App\Tools\HttpsResponse;
use App\Models\ServiceOrder;
use App\Models\Order;
use Log;
use DB;
use Exception;

class PayNotifyCallBack extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		Log::DEBUG("call back:" . json_encode($data));
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}
		
		$attach = json_decode($data['attach']);
		
		if($attach->table_name == "service_order")
		{
			DB::beginTransaction();
			
			try
			{
				$order = ServiceOrder::find($attach->order_id);
			
				Log::info("order::".json_encode($order));
				if($order != null && $order->pay_status == 0)
				{
					$order->pay_type = 1;
					$order->pay_status = 1;
					$order->status = 1;
					$order->transaction_id = $data["transaction_id"];
					$order->save();
				}
				
				DB::commit();
				
				
			}catch(Exception $e)
			{
				DB::rollback();
			 	Log::info("支付套餐出现异常");
			}
		}
		else
		{
			DB::beginTransaction();
			try
			{
				$order = Order::find($attach->order_id);
			
				if($order != null && $order->pay_status == 0)
				{
					$order->pay_type = 1;
					$order->pay_at = date("Y-m-d H:i:s");
					$order->pay_status = 1;
					$order->status = 1;
					$order->transaction_id = $data["transaction_id"];
					$order->save();
				}	
				
				DB::commit();
				
			}catch(Exception $e)
			{
				DB::rollback();
			 	Log::info("支付商品出现异常");
			}
		}
		
		Log::info("支付流程完成");
		return true;
	}
	
}


