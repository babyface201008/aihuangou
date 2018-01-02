<?php

namespace App\Http\Controllers\Mcy\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Mcy\McyAutoManController as AutoMan;
use App\Response;
use App\Tools;
use App\Tools\MyLog\SiteLog;
use App\Model\McyProduct;
use App\Model\McyLoopImg;
use App\Model\McyYunGou;
use App\Model\McyUser;
use App\Model\Category;
use App\Model\McySite;
use App\Model\McyYunGouOrder;
use Cache;
use App\Tools\WeixinUtil;
use App\Tools\WXPAY\Lib\WxPayConfig;
use App\Model\McyWxInfo;
use App\Model\McySendSms;

class McyIndexController extends Controller
{    
  public $site_id = 3;
  public $user_id = 6;
  public function index(Request $request)
  {

      /* $site = Cache::remember('index.site',120,function(){
         return McySite::where('site_id',$this->site_id)->where('user_id',$this->user_id)->first();
       });*/
     $site = McySite::getInfo();
    $categorys = Category::where('user_id',$this->user_id)->where('is_delete',0)->orderBy('created_at','desc')->get();
    /*$categorys = Cache::remember('index.categorys',120,function(){
      return Category::where('user_id',$this->user_id)->where('is_delete',0)->orderBy('created_at','desc')->get();
    });*/

    $loopimgs = McyLoopImg::where('is_delete',0)->where('user_id',$this->user_id)->where('status',0)->orderBy('sort','desc')->get();
    $products = McyProduct::where('user_id',$this->user_id)->where('is_delete',0)->where('product_type',1)->where('hot',1)->orderBy('sort','desc')->paginate(20);
    foreach($products as $key => $product)
    {
    	$yungou_shop = McyYunGou::where('product_id',$product->product_id)->where('is_delete',0)->where('qishu',$product->go_now_qishu)->first();
      if ($yungou_shop->shenyurenshu == 0)
      {
        unset($products[$key]);
      }else{
      	$product->has_go = @$yungou_shop->shenyurenshu;
      	$product->level_go = @$product->go_number - $product->has_go;
      }
    }
    $lotterying = McyYunGou::where('huode_id','<>',0)->where('status',1)->orderBy('show_time','desc')->limit(4)->get();
    foreach($lotterying as $lottery)
    {
      $p = McyProduct::where('product_id',$lottery->product_id)->select('product_img')->first();
      $u = McyUser::where('mcy_user_id',$lottery->huode_id)->select(array('mcy_user_id','username'))->first();
      $lottery->product_img = @$p->product_img;
      $lottery->username = @$u->username;
      $lottery->mcy_user_id = @$u->mcy_user_id;
      $lottery->cha = strtotime($lottery->show_time) - strtotime(date("Y-m-d H:i:s"));
      if ($lottery->cha < 0)  $lottery->cha = "0";
    }
      $wxinfo = @McyWxInfo::where('wxinfo_id',8)->first();
      @WxPayConfig::$APPID = $wxinfo->appid;
      @WxPayConfig::$APPSECRET = $wxinfo->appsecret;
      $params = @WeixinUtil::get_weixin_params();
    return view('mcy.index',compact('site','loopimgs','categorys','products','lotterying','params'));
  }

  public function productList(Request $request)
  {
	 $site = McySite::where('site_id',$this->site_id)->where('user_id',$this->user_id)->first();
	 $category_id = $request->input('category_id',0);
	 if($category_id !== 0)
	 {
	 	$products = McyProduct::where('user_id',$this->user_id)->where('product_type',1)->where('category_id',$category_id)->where('is_delete',0)->paginate(20);
	 }else{
	 	$products = McyProduct::where('user_id',$this->user_id)->where('is_delete',0)->where('product_type',1)->paginate(20);
	 }
	 return view('mcy.product_list',compact('products','site'));
  }

  public function product(Request $request)
  {
        $qishu = $request->input('qishu',0);
  	 $site = McySite::where('site_id',$this->site_id)->where('user_id',$this->user_id)->first();
  	 $product_id = $request->input('product_id');
  	 $product = McyProduct::where('user_id',$this->user_id)->where('is_delete',0)->where('product_id',$product_id)->first();
  	 if ($product)
  	 {
      
  	 	$product->product_loop_imgs = explode(",",$product->product_loop_imgs);
  	 	$yungou_shop = McyYunGou::where('product_id',$product->product_id)->where('is_delete',0)->where('qishu',$product->go_now_qishu)->first();
      if ($yungou_shop->shenyurenshu == 0) 
      {
        // return $this->goingProduct($request);
        return redirect("/going/product?product_id=$product_id&qishu=$product->go_now_qishu");
      }else{
        if ($qishu == 0){}else{
          $yungou_shop = McyYunGou::where('product_id',$product->product_id)->where('is_delete',0)->where('qishu',$qishu)->first();
        }
	  	 return view('mcy.product',compact('site','product','yungou_shop'));
      }
  	 }else{
        $product = McyProduct::where('user_id',$this->user_id)->where('product_id',$product_id)->first();
        if ($product->is_delete == 1)
        {
           return redirect("/going/product?product_id=$product_id&qishu=$qishu");
        }else{}
        $msg = "找不到该商品";
        $type = 2;
        return view('mcy.msg',compact('msg','type'));
  	 }
  }
  public function goingProduct(Request $request)
  {
    /* 正在进行倒计时的商品 */
    $site = McySite::where('site_id',$this->site_id)->where('user_id',$this->user_id)->first();
    $product_id = $request->input('product_id');
    $product = McyProduct::where('user_id',$this->user_id)->where('product_id',$product_id)->first();
    $site = McySite::getInfo();
    if ($product)
    {
       $qishu = $request->input('qishu',$product->go_now_qishu);
       $product->product_loop_imgs = explode(",",$product->product_loop_imgs);
        $yungou_shop = McyYunGou::where('product_id',$product->product_id)->where('is_delete',0)->where('qishu',$qishu)->first();
        if($yungou_shop){}else{ 
          $type = 2;
          $msg = '该期数商品已经下架';
          return view('mcy.msg',compact('msg','type'));
        }
        // 判断是否有下一期
        if($product->go_now_qishu == $yungou_shop->qishu && !($yungou_shop->huode_id == 0) )
        {
          $p = McyProduct::where('user_id',$this->user_id)->where('is_delete',0)->where('product_id',$product_id)->first();
          $automen = new AutoMan;
          $q = $yungou_shop->qishu + 1;
          $result = $automen->xyq($p,$q);
        }else{}

        $date = date('Y-m-d H:i:s');
        if ($yungou_shop->shenyurenshu == 0){

        }else{ 
          if ($product->is_delete == 1)
          {
            $type =2;
            $msg = "该商品已经下架";
            return view('mcy.msg',compact('msg','type'));
          }else{}
          return redirect("/product?product_id=$product->product_id&qishu=$qishu");
        }
      if (($qishu == $product->go_now_qishu ) || ($yungou_shop->show_time > $date) )
      {
        /* 提前触碰 */
           $url = url('api/go_product_daojishi/'.$yungou_shop->yungou_id);
           $automen = new AutoMan;
           @$result = $automen->triggerRequest($url);
        /* 现在的时间 */
        $type = 1;
        $chazhi = strtotime($yungou_shop->show_time) - strtotime($date);
        return view('mcy.going_product',compact('site','product','yungou_shop','chazhi','type'));
      }else{
        /* 已将开过奖的页面 */
        $yungou_shop = McyYunGou::where('product_id',$product->product_id)->where('is_delete',0)->where('qishu',$qishu)->first();
        $type = 2; 
        if ($yungou_shop)
        {
          $mcy_user = McyUser::where('mcy_user_id',$yungou_shop->huode_id)->first();
          /* 找出这个人云购这件商品的次数 */
          $orders = McyYunGouOrder::where('product_id',$yungou_shop->product_id)->where('qishu',$yungou_shop->qishu)->where('is_delete',0)->where('mcy_user_id',$yungou_shop->huode_id)->get();
          $count = 0;
          foreach($orders as $order)
          {
            $c = explode(",",$order->yungouma);
            $count += count($c);
          }
          $mcy_user->count = @$count;
          return view('mcy.going_product',compact('site','product','yungou_shop','type','mcy_user'));
        }else{
          return "商品出错";
        }
        return view('mcy.going_product',compact('site','product','yungou_shop','type'));
      }
    }else{
     $msg = "该产品已经下架";
     $type = 2;
     return view('mcy.msg',compact('msg','type'));
    }
  }

  public function productDesc(Request $request)
  {
  	$site = McySite::where('site_id',$this->site_id)->where('user_id',$this->user_id)->first();
  	$product_id = $request->product_id;
  	$product = McyProduct::where('user_id',$this->user_id)->where('is_delete',0)->where('product_id',$product_id)->first();
  	if ($product)
  	{
  		$product->product_loop_imgs = explode(",",$product->product_loop_imgs);
  		$yungou_shop = McyYunGou::where('product_id',$product->product_id)->where('is_delete',0)->where('qishu',$product->go_now_qishu)->first();
  		return view('mcy.product_desc',compact('site','product','yungou_shop'));	
  	}else{
  		$msg = "该产品已经下架";
  		return view('mcy.msg',compact('msg'));
  	}
  	// if ($product)
  	// {
  	// 	$product->product_loop_imgs = explode(",",$product->product_loop_imgs);
  	// 	$yungou_shop = McyYunGou::where('product_id',$product->product_id)->where('is_delete',0)->where('qishu',$product->go_now_qishu)->first();
  	// 	return view('mcy.product_desc',compact('site','product','yungou_shop'));
  	// }else{
  	// 	dd('welkin');
  	// 	return "该产品已经下架";
  	// }
  }

  public function glist(Request $request)
  {
   $category_id = $request->input('category_id',0);
   /* 是否热门，人气，价格高低 */
   $order = $request->input('order',0);
   $site = McySite::getInfo($this->site_id);
   $categorys = Category::where('user_id',$this->user_id)->where('is_delete',0)->orderBy('created_at','desc')->get();
   if ($category_id !== 0)
   {
     $products = McyProduct::where('user_id',$this->user_id)->where('category_id',$category_id)->where('is_delete',0)->where('product_type',1)->paginate(20);
   }else{
     $products = McyProduct::where('user_id',$this->user_id)->where('is_delete',0)->where('product_type',1)->paginate(20);
   }
   return view('mcy.glist',compact('categorys','products','site','category_id','order'));
 }

 public function msg(Request $requets)
 {
  $msg = $requets->input('msg','消息页面');
  $type = intval($requets->input('type',2));
  if ($type == 1)
  {
    $icon = '<i class="weui-icon-success"></i>';
  }else{
    $icon = '<i class="weui-icon-warn"></i>';
  }
  return view('mcy.msg',compact('icon','msg'));
 }
 // 所有云购记录
 public function buyrecords(Request $request)
 {
  $product_id = $request->product_id;
  $qishu = $request->qishu;
  return view('mcy.record',compact('product_id','qishu'));
 }

 public function calResult(Request $request)
 {
  $yungou_id = $request->yungou_id;
  $yungou_shop = McyYUnGou::where('is_delete',0)->where('yungou_id',$yungou_id)->where('huode_id','<>',0)->where('status',1)->first();
  if ($yungou_shop)
  {
    $select = array(
      'mcy_user.mcy_user_id',
      'mcy_user.username',
      'mcy_yungou_order.created_at',
      'mcy_yungou_order.order_id',
      'mcy_yungou_order.is_update',
      'mcy_yungou_order.update_number',
      );
    $siteinfo = McySite::where('is_delete',0)->where('user_id',6)->first();
    $e1 = strtotime($yungou_shop->show_time) - $siteinfo->site_time;
    $e = date("Y-m-d H:i:s",$e1);
    // 100条记录
    // $lists = McyYunGouOrder::where('is_delete',0)->where('created_at','<',$yungou_shop->show_time)->limit(100)->select('created_at')->orderBy('created_at','desc')->select(array('created_at','order_id')->get();
    $lists = McyYunGouOrder::join('mcy_user','mcy_user.mcy_user_id','=','mcy_yungou_order.mcy_user_id','left')->where('mcy_yungou_order.created_at','<',$e)->limit(100)->select($select)->orderBy('mcy_yungou_order.created_at','desc')->get();
    $all = floatval(0);
    foreach($lists as $list)
    {
      $all += strtotime($list->created_at);
    }
    $yu = fmod($all,$yungou_shop->zongshu);
    $huode_ma = 1 + $yu + 1000000; 
    $cha = $yungou_shop->huode_ma - $huode_ma;
    $all = $all + $cha;
    return view("mcy.cal_result",compact('yungou_id','lists','yungou_shop','all','cha'));
  }else{
    $type = 2;
    $msg = "没有这个计算详情";
    return view('mcy.msg',compact('type','msg'));
  }
 }
}
