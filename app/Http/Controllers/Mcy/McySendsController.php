<?php

namespace App\Http\Controllers\Mcy;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Response;
use App\Tools;
use App\Tools\MyLog\SiteLog;
use App\Model\McyUser;
use App\Model\McyOrder;
use App\Model\McyYunGou;
class McySendsController extends Controller
{    
   /**
   * 用户管理
   * @AiHuanGou
   * @DateTime      2017-04-07T10:52:48+0800
   * @param         Request                  $request 
   * @return        view                            
   */
  public function sends(Request $request)
  {
  	
  	$starttime = empty($request->input('starttime',''))?'1971-1-1':$request->input('starttime').' 00:00:00';
  	$endtime = empty($request->input('endtime',''))?'2099-12-31':$request->input('endtime').' 23:59:59';
  	$searchtext = $request->input('searchtext','');
    $is_robot = $request->input('is_robot',0);
    $status = $request->input('status',1);
    $order_status = $request->input('order_status',2);
  	if ($searchtext !== '')
  	{
  	    if($order_status==2){
  	        $field = 'mcy_order.order_status';
        }elseif($order_status==3){
            $field = 'mcy_yungou.order_deal';
        }
        $sends = McyYunGou::join('mcy_user','mcy_user.mcy_user_id','=','mcy_yungou.huode_id','left')
                                          ->join('mcy_yungou_order','mcy_yungou.huode_order_id','=','mcy_yungou_order.go_id','left')
                                          ->join('mcy_order','mcy_order.order_id','=','mcy_yungou_order.order_id','left')
                                          ->where('mcy_order.order_username','like','%'.$searchtext.'%')
                                          ->where('mcy_yungou.huode_id','<>',0)
                                          ->where('mcy_yungou.status',$status)
                                          ->where($field,$order_status)
                                          ->where('mcy_user.is_robot',$is_robot)
                                          ->whereBetween('mcy_yungou_order.created_at',[$starttime,$endtime])
                                          ->orderBy('mcy_yungou.updated_at','desc')
                                          ->select(
                                            'mcy_order.order_username',
                                            'mcy_user.mcy_user_id',
                                            'mcy_user.mobile',
                                            'mcy_order.order_no',
                                            'mcy_order.order_status',
                                            'mcy_yungou.order_addr',
                                            'mcy_yungou.order_mobile',
                                            'mcy_yungou.order_people',
                                            'mcy_yungou.order_desc',
                                            'mcy_yungou.order_kd',
                                            'mcy_yungou.order_kd_number',
                                            'mcy_order.order_id',
                                            'mcy_yungou_order.product_name',
                                            'mcy_yungou_order.qishu',
                                            'mcy_yungou_order.product_id',
                                            'mcy_order.created_at',
                                              'mcy_yungou.yungou_id',
                                              'mcy_yungou.order_deal'
                                            )
                                          ->paginate(100);
                                        }else{
                                          $sends = McyYunGou::join('mcy_user','mcy_user.mcy_user_id','=','mcy_yungou.huode_id','left')
                                          ->join('mcy_yungou_order','mcy_yungou.huode_order_id','=','mcy_yungou_order.go_id','left')
                                          ->join('mcy_order','mcy_order.order_id','=','mcy_yungou_order.order_id','left')
                                          ->where('mcy_yungou.huode_id','<>',0)
                                          ->where('mcy_order.order_status',$order_status)
                                          ->where('mcy_yungou.status',$status)
                                          ->where('mcy_user.is_robot',$is_robot)
                                          ->whereBetween('mcy_yungou_order.created_at',[$starttime,$endtime])
                                          ->orderBy('mcy_yungou.updated_at','desc')
                                          ->select(
                                            'mcy_order.order_username',
                                            'mcy_user.mcy_user_id',
                                            'mcy_user.mobile',
                                            'mcy_order.order_no',
                                            'mcy_order.order_status',
                                            'mcy_yungou.order_addr',
                                            'mcy_yungou.order_mobile',
                                            'mcy_yungou.order_people',
                                            'mcy_yungou.order_desc',
                                            'mcy_yungou.order_kd',
                                            'mcy_yungou.order_kd_number',
                                            'mcy_order.order_id',
                                            'mcy_yungou_order.product_name',
                                            'mcy_yungou_order.qishu',
                                            'mcy_yungou_order.product_id',
                                            'mcy_order.created_at',
                                              'mcy_yungou.yungou_id',
                                              'mcy_yungou.order_deal'
                                            )
                                          ->paginate(100);
  	}

  	return view('welkin.mcy.sends',compact('sends','starttime','endtime','searchtext','is_robot','order_status'));
  }


  public function sendUpdate(Request $request)
  {
    $yungou_id = $request->input("yungou_id");
    $yungou = McyYunGou::where('yungou_id',$yungou_id)->where('is_delete',0)->first();
    if ($yungou)
    {
      return view('welkin.mcy.send_update',compact('yungou'));
    }else{
      return " 没有这个订单";
    }
  }
}
