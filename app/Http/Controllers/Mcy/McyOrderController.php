<?php

namespace App\Http\Controllers\Mcy;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Response;
use App\Tools;
use App\Tools\MyLog\SiteLog;
use App\Model\Category;
use App\Model\McyOrder;
use App\Model\McyYunGouOrder;
use App\Model\McyYunGou;
use App\Model\McyProduct;
use App\Model\TopUp;
use App\Model\McyWithDraw;


class McyOrderController extends Controller
{    
   /**
   * 用户管理
   * @AiHuanGou
   * @DateTime      2017-04-07T10:52:48+0800
   * @param         Request                  $request 
   * @return        view                            
   */
   public function orders(Request $request)
   {
    $starttime = empty($request->input('starttime',''))?'1971-1-1':$request->input('starttime').' 00:00:00';
    $endtime = empty($request->input('endtime',''))?'2099-12-31':$request->input('endtime').' 23:59:59';
    $searchtext = $request->input('searchtext','');
    $order_status = $request->input('order_status',1);
    $searchid = $request->input('searchid');
    $t1 = microtime(true);
    $productid = $request->input('productid');
    $select = array(
      'mcy_order.order_id',
      'mcy_order.order_no',
      'mcy_yungou_order.product_name',
      'mcy_yungou_order.mcy_user_id',
      'mcy_yungou_order.product_id',
      'mcy_yungou_order.qishu',
      'mcy_yungou_order.allprice',
      'mcy_yungou_order.yungouma',
      'mcy_order.order_status',
      'mcy_order.order_username',
      'mcy_order.order_mobile',
      'mcy_order.created_at',
      'mcy_product.product_price',
      // 'mcy_yungou.huode_id',
      // 'mcy_yungou.zhiding',
      // 'mcy_yungou.huode_ma',
      // 'mcy_yungou.is_shaidan',
      // 'mcy_yungou.shaidan_id',
      // 'mcy_yungou.yungou_id',
      // 'mcy_yungou.huode_order_time'
      );
     $welkin = 0;
     $order_array = array(
      'mcy_order.order_id',
      'mcy_order.order_no',
      'mcy_order.order_status',
      'mcy_order.order_username',
      'mcy_order.order_mobile',
      'mcy_order.created_at',
      );
    if ($productid == '')
    {
      if ($searchid == ''){
        if ($searchtext !== '')
        {
          $orders = McyYunGouOrder::join('mcy_order','mcy_order.order_id','=','mcy_yungou_order.order_id','left')->join('mcy_product','mcy_product.product_id','=','mcy_yungou_order.product_id')->where('mcy_yungou_order.is_delete',0)->where('mcy_order.order_username','like','%'.$searchtext.'%')->whereBetween('mcy_order.created_at',[$starttime,$endtime])->orderBy('mcy_yungou_order.created_at','desc')->select($select)->paginate(10);
        }else{
          $orders = McyYunGouOrder::where('mcy_yungou_order.is_delete',0)->whereBetween('mcy_yungou_order.created_at',[$starttime,$endtime])->orderBy('mcy_yungou_order.go_id','desc')->paginate(10);
          $welkin = 1;
          // $orders = McyYunGouOrder::join('mcy_order','mcy_order.order_id','=','mcy_yungou_order.order_id','left')->join('mcy_product','mcy_product.product_id','=','mcy_yungou_order.product_id')->where('mcy_yungou_order.is_delete',0)->whereBetween('mcy_order.created_at',[$starttime,$endtime])->orderBy('mcy_yungou_order.go_id','desc')->select($select)->paginate(100);
        }
      }else{
        $orders = McyYunGouOrder::join('mcy_order','mcy_order.order_id','=','mcy_yungou_order.order_id','left')->join('mcy_product','mcy_product.product_id','=','mcy_yungou_order.product_id')->where('mcy_yungou_order.is_delete',0)->where('mcy_yungou_order.mcy_user_id',$searchid)->orderBy('mcy_yungou_order.created_at','desc')->select($select)->paginate(10);
      }
    }else{
       $orders = McyYunGouOrder::join('mcy_order','mcy_order.order_id','=','mcy_yungou_order.order_id','left')->join('mcy_product','mcy_product.product_id','=','mcy_yungou_order.product_id')->where('mcy_yungou_order.is_delete',0)->where('mcy_yungou_order.product_id',$productid)->orderBy('mcy_yungou_order.created_at','desc')->select($select)->paginate(10);
    }

    foreach($orders as $order)
    {
      if ($welkin = 1){
        $mcy_order = McyOrder::where('mcy_order.order_id','=',$order->order_id)->where('is_delete',0)->select($order_array)->first();
        // $mcy_order = McyOrder::find($order->order_id);
        $mcy_product = McyProduct::where('mcy_product.product_id',$order->product_id)->select('product_price')->first();
        $order->product_price = $mcy_product->product_price;
        $order->order_id = $mcy_order->order_id;
        $order->order_no = $mcy_order->order_no;
        $order->order_status = $mcy_order->order_status;
        $order->order_username = $mcy_order->order_username;
        $order->order_mobile = $mcy_order->order_mobile;
        $order->created_at = $mcy_order->created_at;
      }else{}
      $yungou_shop = McyYunGou::where('mcy_yungou.qishu',$order->qishu)->where('mcy_yungou.product_id',$order->product_id)->first();
      $order->huode_id = $yungou_shop->huode_id;
      $order->zhiding = $yungou_shop->zhiding;
      $order->huode_ma = $yungou_shop->huode_ma;
      $order->is_shaidan = $yungou_shop->is_shaidan;
      $order->shaidan_id = $yungou_shop->shaidan_id;
      $order->yungou_id = $yungou_shop->yungou_id;
      $order->huode_order_time = $yungou_shop->huode_order_time;
      $order->count = count(explode(",",$order->yungouma));
      $order->order_deal = $yungou_shop->order_deal;
    }

    return view('welkin.mcy.orders',compact('orders','order_type','order_status','starttime','endtime','searchtext','searchid','productid'));
   }


   public function orderUpdate(Request $request)
   {
    $order_id = $request->input('order_id');
    $order = McyOrder::where('order_id',$order_id)->where('is_delete',0)->first();
    if ($order)
    {
      return view('welkin.mcy.order_update',compact('order'));
    }else{
      return redirect('/welkin/mcy/orders');
    }
   }

  /* 充值管理 */
  public function topUp(Request $request)
  {
    $sday = date('Y-m-d');
    $starttime = empty($request->input('starttime',''))?$sday.' 00:00:00':$request->input('starttime');
    $endtime = empty($request->input('endtime',''))?$sday.' 23:59:59':$request->input('endtime');
    $searchtext = $request->input('searchtext','');
    $admin_id = $request->session()->get('admin_id');
    $order_no = $request->input('order_no','');
    $is_robot = $request->input('is_robot',0);
    $status = $request->input('status',1);
    $select = array(
      'mcy_user.mcy_user_id',
      'mcy_user.is_robot',
      'mcy_user.username',
      'mcy_user.jingyan',
      'mcy_topup.status',
      'mcy_topup.order_no',
      'mcy_topup.is_delete',
      'mcy_topup.payinfo_id',
      'mcy_topup.price',
      'mcy_topup.created_at',
      );
    if (!($order_no == ''))
    {
      $topups = TopUp::join('mcy_user','mcy_user.mcy_user_id','=','mcy_topup.mcy_user_id')->where('mcy_user.is_robot',$is_robot)->where('mcy_topup.status',$status)->where('mcy_topup.order_no',$order_no)->where('mcy_topup.is_delete',0)->select($select)->paginate(1000);
      $money = array_sum(explode(",",$topups->implode('price',',')));
      return view('welkin.mcy.topups',compact('is_robot','topups','starttime','endtime','searchtext','status','money','order_no'));
    }else{}
    if (!($searchtext == ''))
    { 
         $topups = TopUp::join('mcy_user','mcy_user.mcy_user_id','=','mcy_topup.mcy_user_id')->where('mcy_user.is_robot',$is_robot)->where('mcy_topup.status',$status)->where(array('mcy_topup.is_delete'=>0))->where('mcy_user.username','like','%'.$searchtext.'%')->whereBetween('mcy_topup.created_at',[$starttime,$endtime])->orderBy('mcy_topup.created_at','desc')->select($select)->paginate(1000);
         $money = array_sum(explode(",",$topups->implode('price',',')));
    }else{
         $topups = TopUp::join('mcy_user','mcy_user.mcy_user_id','=','mcy_topup.mcy_user_id')->where('mcy_user.is_robot',$is_robot)->where('mcy_topup.status',$status)->where(array('mcy_topup.is_delete'=>0))->whereBetween('mcy_topup.created_at',[$starttime,$endtime])->orderBy('mcy_topup.created_at','desc')->select($select)->paginate(1000);    }
         $money = array_sum(explode(",",$topups->implode('price',',')));
    return view('welkin.mcy.topups',compact('is_robot','topups','starttime','endtime','searchtext','status','money','order_no'));
  }      
    
  public function topUpCreate(Request $request)
  {
    return view('welkin.mcy.tupup_create');
  }
  
  public function topUpUpdate(Request $request)
  {
    $admin_id = $request->session()->get('admin_id');
    $tupup_id = intval($request->input('tupup_id'));
    $topup = TopUp::where(array('is_delete'=>0))->where('topup_id',$topup_id)->first();
    return view('welkin.mcy.tupup_update',compact('topup'));
  } 

  public function zhiding(Request $request)
  {
    $admin_id = $request->session()->get('admin_id');
    $yungou_id = $request->input('yungou_id');
    $yungou_shop = McyYunGou::where('yungou_id',$yungou_id)->first();
    if ($yungou_shop)
    {
      return view('welkin.mcy.zhiding',compact('yungou_shop'));
    }else{
      return "没哟";
    }
  }
  public function withdraw(Request $request)
  {
     $starttime = empty($request->input('starttime',''))?'1971-1-1':$request->input('starttime').' 00:00:00';
    $endtime = empty($request->input('endtime',''))?'2099-12-31':$request->input('endtime').' 23:59:59';
    $searchtext = $request->input('searchtext','');
    $admin_id = $request->session()->get('admin_id');
    $bank_username = $request->input('bank_username','');
    if (!($bank_username == ''))
    {
      $withdraws = McyWithDraw::where('bank_username',$bank_username)->where('is_delete',0)->paginate(20);
      return view('welkin.mcy.withdraw',compact('withdraws','starttime','endtime','searchtext','bank_username'));
    }else{}
    if (!($searchtext == ''))
    { 
         $withdraws = McyWithDraw::where(array('is_delete'=>0))->where('username','like','%'.$searchtext.'%')->whereBetween('created_at',[$starttime,$endtime])->orderBy('created_at','desc')->paginate(20);
    }else{
         $withdraws = McyWithDraw::where(array('is_delete'=>0))->whereBetween('created_at',[$starttime,$endtime])->orderBy('created_at','desc')->paginate(20);
    }
    return view('welkin.mcy.withdraw',compact('withdraws','starttime','endtime','searchtext','bank_username'));
  }
}
