<?php

namespace App\Http\Controllers\Mcy;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Response;
use App\Tools;
use App\Tools\MyLog\SiteLog;
use App\Model\Category;
use App\Model\McyShaiDan;
use App\Model\McyYunGou;
use App\Model\McyYunGouOrder;
use App\Model\McyUser;
class McyShaiDanController extends Controller
{    
   /**
   * 用户管理
   * @AiHuanGou
   * @DateTime      2017-04-07T10:52:48+0800
   * @param         Request                  $request 
   * @return        view                            
   */
  public function shaidan(Request $request)
  {
  	
  	$starttime = empty($request->input('starttime',''))?'1971-1-1':$request->input('starttime').' 00:00:00';
  	$endtime = empty($request->input('endtime',''))?'2099-12-31':$request->input('endtime').' 23:59:59';
    $admin_id = $request->session()->get('admin_id');

    $shaidans = McyShaiDan::where(array('is_delete'=>0,'user_id'=>$admin_id))->whereBetween('created_at',[$starttime,$endtime])->orderBy('created_at','desc')->paginate(20);

  	return view('welkin.mcy.shaidans',compact('shaidans','starttime','endtime'));
  }

  public function shaiDanCreate(Request $request)
  {
    $yungou_id = $request->input('yungou_id');
    $yungou_shop = McyYunGou::where('yungou_id',$yungou_id)->where('is_delete',0)->first();
    $mcy_user = McyUser::where('mcy_user_id',$yungou_shop->huode_id)->where('is_delete',0)->first();
    return view('welkin.mcy.shaidan_create',compact('yungou_id','mcy_user'));
  }

  public function shaiDanUpdate(Request $request)
  {
    $admin_id = $request->session()->get('admin_id');
    $shaidan_id = intval($request->input('shaidan_id'));
    $shaidan = McyShaiDan::where('user_id',$admin_id)->where('is_delete',0)->where('shaidan_id',$shaidan_id)->first();
    // $shaidan->shaidan_imgs = explode(",",$shaidan->shaidan_imgs);
    return view('welkin.mcy.shaidan_update',compact('shaidan'));
  }
  public function fshaidan(Request $request)
  {
    $shaidans = McyShaiDan::join('mcy_user','mcy_user.mcy_user_id','=','mcy_shaidan.mcy_user_id','left')->where('mcy_shaidan.is_delete',0)->where('status',0)->orderBy('mcy_shaidan.created_at','desc')->paginate(20);
    return view('mcy.fshaidan',compact('shaidans'));
  }
  public function fshaidanDetail(Request $request)
  {
    $shaidan_id = $request->input('shaidan_id');
    $shaidan = McyShaiDan::where('shaidan_id',$shaidan_id)->where('is_delete',0)->first();
    if ($shaidan)
    {
      $mcy_user = McyUser::where('is_delete',0)->where('mcy_user_id',$shaidan->mcy_user_id)->first();
      $yungou_shop = McyYunGou::where('shaidan_id',$shaidan_id)->where('is_delete',0)->first();
      $orders = McyYunGouOrder::where('product_id',$yungou_shop->product_id)->where('qishu',$yungou_shop->qishu)->where('is_delete',0)->where('mcy_user_id',$yungou_shop->huode_id)->get();
      $count = 0;
      foreach($orders as $order)
      {
        $c = explode(",",$order->yungouma);
        $count += count($c);
      }
      $shaidan->count = $count;
      return view('mcy.fshaidan_detail',compact('shaidan','mcy_user','yungou_shop'));
    }else{
      return "没有该订单";
    }
  }
  public function goodspost(Request $request)
  {
    $product_id = $request->product_id;
    $qishu = $request->qishu;
    $shaidan = McyShaiDan::where('product_id',$product_id)->where('qishu',$qishu)->first();
    if ($shaidan)
    {
      $mcy_user = McyUser::where('is_delete',0)->where('mcy_user_id',$shaidan->mcy_user_id)->first();
      $yungou_shop = McyYunGou::where('shaidan_id',$shaidan->shaidan_id)->where('is_delete',0)->first();
      $orders = McyYunGouOrder::where('product_id',$yungou_shop->product_id)->where('qishu',$yungou_shop->qishu)->where('is_delete',0)->where('mcy_user_id',$yungou_shop->huode_id)->get();
      $count = 0;
      foreach($orders as $order)
      {
        $c = explode(",",$order->yungouma);
        $count += count($c);
      }
      $shaidan->count = $count;
      return view('mcy.fshaidan_detail',compact('shaidan','mcy_user','yungou_shop'));
    }else{
      $type = 2;
      $msg = "该商品尚未晒单";
      return view('mcy.msg',compact('type','msg'));
    }
    return view('mcy.goodspost',compact('shaidan'));
  }
}
