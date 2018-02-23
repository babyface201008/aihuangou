<?php

namespace App\Http\Controllers\Mcy\Front;

use App\Model\FubiDuihuan;
use App\Model\McySupermasterApply;
use App\Model\Yongjing;
use App\Tools;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\McyProduct;
use App\Model\McyYunGou;
use App\Model\McyYunGouOrder;
use App\Model\McyOrder;
use App\Model\McyTopUp;
use App\Model\McyUser;
use App\Model\McyPay;
use App\Model\McySite;
use App\Model\McyShaiDan;
use App\Model\McyQianDao;
use App\Tools\WeixinUtil;
use App\Tools\WXPAY\Lib\WxPayConfig;
use App\Model\McyWxInfo;
use App\Model\McyWithDraw;
use App\Model\McyAddress;
use App\Tools\MyLog\WechatLog;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Cache;
use DB;


class McyFrontUserController extends Controller
{    
  public $site_id = 3;
  public $user_id = 6;

  /**
   * 登录
   */
  public function login(Request $request){
      $site = McySite::getInfo();
    return view('mcy.login',compact('site'));
  }

  /**
   * 注册
   */
  public function register(Request $request){

      $user_id = session('user_id');
      if($user_id){
          return redirect('/mcy/user');
      }
      $site = McySite::getInfo();
      return view('mcy.register',compact('site'));
  }

  /**
   * 忘记密码
   */
  public function password(Request $request){
    $site = McySite::getInfo();
    return view('mcy.password',compact('site'));
  }

    /**
     * 用户协议
     */
    public function  terms(){
        $site = McySite::getInfo();
        return view('mcy.terms',compact('site'));
    }

  public function user(Request $request)
  {

    //$openid = $request->session()->forget('openid');

    // if ($openid == 'o7RM2wOlsHXF14CJv2Bmq3TuA7bM'){
    //    $request->session()->forget('openid');
    //    return redirect('/mcy/user');
    // }else{}

      $mcy_user = McyUser::getUserInfo();

    if ($mcy_user){
      $site = McySite::where('user_id',$this->user_id)->where('site_id',$this->site_id)->first();

        $url = McyUser::getQRcode($mcy_user->mcy_user_id);

      WechatLog::info('账号进入个人中心： openid: '.$request->session()->get('openid').'异常ID: '.@$request->session()->get('error_code'));
      return view('mcy.mcyuser',compact('mcy_user','site','url'));
    }else{
     /* $rand_id = mt_rand(0,2000000);
      WechatLog::info('异常账号： openid: '.$request->session()->get('openid').' 异常ID:'.$rand_id);
      $request->session()->put('error_code',$rand_id,120);
      $request->session()->forget('openid');
      $msg = '账号异常，请刷新页面，或者请联系客服';
      $type = 2;
      return view('mcy.msg',compact('msg','type'));*/
      return redirect('/login');
    }
  }

  public function userCartList(Request $request)
  {
  	$user_id = $request->session()->get('user_id');
  	if ($user_id)
  	{
  		$mcy_user = McyUser::getUserInfo();
      // if ($mcy_user->username == '潮惠新成员'){
      //   $type = 2;
      //   $msg = '快给自己来个个性名称吧！然后可以快购啦！';
      //   return view('mcy.msg',compact('msg','type'));
      // }else{}
      if ($mcy_user->mobile == ''){
        $type = 3;
        $msg = '您还没有通过手机验证，点击下方按钮，验证通过就可以尽情快购了！大奖等着你来拿！';
        return view("mcy.msg",compact('msg','type'));
      }else{}
  		$site = McySite::getInfo();
  		$cartlists = $request->session()->get('cart');
  		if (!$cartlists){ $cartlists = array();}
      $all_price = 0;
      $all_count = 0;
      foreach($cartlists as $key => $cartlist)
      {
        $yungou_shop =  McyYunGou::where('qishu',$cartlist['qishu'])->where('is_delete',0)->where('product_id',$key)->first();
        $product =  McyProduct::where('go_now_qishu',$cartlist['qishu'])->where('is_delete',0)->where('product_id',$key)->first();
        $cartlists[$key]['product'] = $product;
        $cartlists[$key]['yungou_shop'] = $yungou_shop;
        $all_count += 1;
        $all_price += $yungou_shop->price * intval($cartlist['number']);
  		}
  		return view('mcy.cartlist',compact('cartlists','site','mcy_user','all_price','all_count'));
  	}else{
  		return redirect('/mcy/login');
  	}
  }
  public function userCartPay(Request $request)
  {
    $user_id = $request->session()->get('user_id');
    if ($user_id)
    {
      $mcy_user = McyUser::where('mcy_user_id',$user_id)->where("is_delete",0)->first();
      $site = McySite::getInfo();
      $cartlists = $request->session()->get('cart');
      if (!$cartlists){ $cartlists = array();}
      $all_price = 0;
      $all_count = 0;
      foreach($cartlists as $key => $cartlist)
      {
          $yungou_shop =  McyYunGou::where('qishu',$cartlist['qishu'])->where('is_delete',0)->where('product_id',$key)->first();
          $product =  McyProduct::where('go_now_qishu',$cartlist['qishu'])->where('is_delete',0)->where('product_id',$key)->first();
          $cartlists[$key]['product'] = $product;
          $cartlists[$key]['yungou_shop'] = $yungou_shop;
          $all_count += 1;
          $all_price += $yungou_shop->price * intval($cartlist['number']);
      }
      return view('mcy.payment',compact('cartlists','site','mcy_user','all_price','all_count','site'));
    }else{
      return redirect('/mcy/login');
    }
  }
  /* 用户充值 */
  public function userTopUp(Request $request)
  {
    $openid = $request->session()->get('openid');
    $mcy_user = McyUser::where('openid',$openid)->where("is_delete",0)->where('is_robot',0)->first();
    if ($mcy_user)
    {
      $topups = McyPay::where('is_delete',0)->where('status',0)->orderBy('sort','desc')->get();
      $payinfos = McyPay::where('is_delete',0)->where('status',0)->orderBy('sort','desc')->get();
      if ($mcy_user->mcy_user_id == '51142')
      {
        $payinfos = McyPay::where('is_delete',0)->orderBy('sort','desc')->get();
      }else{}
      return view("mcy.user_topup",compact('topups','payinfos','mcy_user'));
    }else{
      $msg = '帐号异常，请重新登录';
      $type = 2;
      return view('mcy.msg',compact("msg",'type'));
    }
  }
  /* 分享赚钱 */
  public function userInviteFriends(Request $request)
  {
    $openid = $request->session()->get('openid');
    $mcy_user = McyUser::where('openid',$openid)->where('is_delete',0)->first();
    if ($mcy_user)
    {
      return redirect("/mcy/user/invite/friends/$mcy_user->mcy_user_id");
    }else{
      return redirect('/mcy/user');
    }
  }


  public function userInviteHistory(Request $request)
  {

    $mcy_user = McyUser::getUserInfo();
    if ($mcy_user)
    {
      $wxinfo = McyWxInfo::where('wxinfo_id',8)->first();
      WxPayConfig::$APPID = $wxinfo->appid;
      WxPayConfig::$APPSECRET = $wxinfo->appsecret;
      $params = WeixinUtil::get_weixin_params();
      $select  = array('username','created_at');
      $history_list = McyUser::where('is_delete',0)->where('master_id',$mcy_user->mcy_user_id)->select($select)->get();
      return view('mcy.user_share_history',compact('mcy_user','history_list','params'));
    }else{
      return redirect('/mcy/user');
    }
  }

  public function userWithDrawList(Request $request)
  {

    $mcy_user = McyUser::getUserInfo();
    if ($mcy_user)
    {
      $wxinfo = McyWxInfo::where('wxinfo_id',8)->first();
      WxPayConfig::$APPID = $wxinfo->appid;
      WxPayConfig::$APPSECRET = $wxinfo->appsecret;
      $params = WeixinUtil::get_weixin_params();
      $select  = array('withdraw_price','created_at','bank_id','status');
      $withdraw_list = McyWithDraw::where('is_delete',0)->where('mcy_user_id',$mcy_user->mcy_user_id)
          ->select($select)->orderby('status','asc')->orderby('created_at','desc')->paginate(10);
      return view('mcy.user_withdraw_list',compact('mcy_user','withdraw_list','params'));
    }else{
      return redirect('/mcy/user');
    }
  }

  public function userWithDraw(Request $request)
  {
    $openid = $request->session()->get('openid');
    $mcy_user = McyUser::where('openid',$openid)->where('is_delete',0)->first();
    if ($mcy_user)
    {
      $wxinfo = McyWxInfo::where('wxinfo_id',8)->first();
      WxPayConfig::$APPID = $wxinfo->appid;
      WxPayConfig::$APPSECRET = $wxinfo->appsecret;
      $params = WeixinUtil::get_weixin_params();
      return view('mcy.user_withdraw',compact('mcy_user','params'));
    }else{
      return redirect('/mcy/user');
    }
  }

  public function userInviteFriend(Request $request)
  {
    $param = '';
    /* 分享不用手机认证 */
    // $mcy_user_id = $request->session()->get('mcy_user_id');

    // $mcy_user = McyUser::where('openid',$openid)->where('mcy_user_id',$mcy_user_id);
    $mcy_user = McyUser::getUserInfo();
    $user_id = $request->userid;
    $date = date("Y-m-d H:i:s");
    if ($mcy_user->created_at > date("Y-m-d H:i:s",strtotime(" - 10 min")))
    {
      //  刚注册的
      if ($mcy_user->mcy_user_id == $user_id){
        // 自己不用管
      }else{
        // 成为下属，判断是否已经有主人了。
        if ($mcy_user->is_slave == 0){
          /* 没有主人 */
          $mcy_user->is_slave = 1;
          $mcy_user->master_id = $user_id;
          $mcy_user->save();
        }else{
        }
      }
    }else{  
      // 注册时间超过10分钟的，不管
    }
    $slave_count = McyUser::where('is_delete',0)->where('master_id',$mcy_user->mcy_user_id)->count();
    // 分享参数
    $wxinfo = McyWxInfo::where('wxinfo_id',8)->first();
    WxPayConfig::$APPID = $wxinfo->appid;
    WxPayConfig::$APPSECRET = $wxinfo->appsecret;
    $params = WeixinUtil::get_weixin_params();
    return view('mcy.user_share',compact('params','mcy_user','slave_count'));
  }



  public function userLogOut(Request $request)
  {
    $request->session()->forget('mcy_user_id');
    $request->session()->forget('openid');
    $request->session()->forget('user_id');
    return redirect('/');
  }

  public function userQianDao(Request $request)
  {
    $weekday = array();
    $weekstart = date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1,date("Y")));
    $weekend = date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y")));
    $mcy_user = McyUser::where('is_delete',0)->where('openid',$request->session()->get('openid'))->first();

    // 进入签到，送福分
    $days = date("Y-m-d")." 00:00:00";
    $daye = date("Y-m-d")." 23:59:59";
    $qday = McyQianDao::where('is_delete',0)->where('mcy_user_id',$mcy_user->mcy_user_id)->whereBetween('created_at',[$days,$daye])->first();

    if ($qday)
    {
      // 今天已经签到过了，不管
    }else{
        $day = new McyQianDao;
        $day->mcy_user_id  = $mcy_user->mcy_user_id;
        $day->qiandao_day  = date("Y-m-d H:i:s");
        $day->score = 0;

        $mcy_user->score += 30;
        // 判断是否三连签
        $qdayss = date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w"),date("Y"))) ;
        $qdayse = date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+6,date("Y")));
        $qdays = McyQianDao::where('is_delete',0)->where('mcy_user_id',$mcy_user->mcy_user_id)->where('is_get',0)->whereBetween('created_at',[$qdayss,$qdayse])->get();
        $has_qdays = McyQianDao::where('is_delete',0)->where('mcy_user_id',$mcy_user->mcy_user_id)->where('is_get',1)->whereBetween('created_at',[$qdayss,$qdayse])->get();
        if ((count($qdays) >= 2) && (count($has_qdays) == 0))
        {
            /*判断是否3连签*/
            $qdayss1 = date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w"),date("Y"))) ;
            $qdayss = date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d") - 3,date("Y"))) ;
            $qdayse = date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+6,date("Y")));
            $check_day = McyQianDao::where('is_delete',0)->where('mcy_user_id',$mcy_user->mcy_user_id)->where('is_get',0)->where('created_at','>',$qdayss1)->whereBetween('created_at',[$qdayss,$qdayse])->get();
            if (count($check_day) >= 2)
            {
                $mcy_user->score += 60;
                $day->score += 60;
                $day->save();
                foreach($qdays as $d)
                {
                  $d->is_get = 1;
                  $d->save();
                }
            }else{
            }
        }elseif (count($qdays) + count($has_qdays) >= 6 )
        {
            /* 判断是否断签 */
            $mcy_user->score += 60;
            $day->score += 60;
            $day->save();
            foreach($qdays as $d)
            {
              $d->is_get = 1;
              $d->save();
            }
        }
        $mcy_user->save();
      // 默认签到
    
      $day->score += 30;
      $day->is_get = 0;
      $day->save();
    }
    $d_count = 0;
    $week = array();
    for ($i=0; $i < 7; $i++) { 
      $week[$i]['day'] = date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+$i,date("Y")));
      $check = McyQianDao::where('is_delete',0)->where('mcy_user_id',$mcy_user->mcy_user_id)->whereBetween('qiandao_day',[$week[$i]['day'],date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+$i,date("Y")))])->count();
      $week[$i]['check'] = $check;
      if ($check == 1){ $d_count += 1;}
    }
    $all_qdays = McyQianDao::where('is_delete',0)->where('mcy_user_id',$mcy_user->mcy_user_id)->orderBy('qiandao_day','desc')->limit(30)->get();
    return view('mcy.user_qiandao',compact('mcy_user','d_count','week','all_qdays'));
  }

  public function userHuodeList(Request $request)
  {
     $select = array(
              'mcy_product.product_name',
              'mcy_product.product_price',
              'mcy_product.go_now_qishu',
              'mcy_product.product_img',
              'mcy_yungou_order.product_id',
              'mcy_yungou_order.qishu',
              'mcy_product.product_price',
              'mcy_yungou_order.mcy_user_id',
              'mcy_yungou.shenyurenshu',
              'mcy_yungou.zongshu',
              'mcy_yungou.huode_id',
              'mcy_yungou.huode_order_time',
              'mcy_yungou.huode_order_id',
              'mcy_yungou.huode_ma',
              'mcy_yungou.order_addr',
              'mcy_yungou.order_mobile',
              'mcy_yungou.order_desc',
              'mcy_yungou.order_kd',
              'mcy_yungou.order_kd_number',
              'mcy_yungou.order_deal',
              'mcy_yungou.yungou_id',
              );

    $mcy_user = McyUser::getUserInfo();
    // $huode_list = McyYunGouOrder::join('mcy_product','mcy_product.product_id','=','mcy_yungou_order.product_id')
    //                              ->join('mcy_yungou',function($join){
    //                                 $join->on("mcy_yungou.qishu",'=','mcy_yungou_order.qishu');
    //                                 $join->on("mcy_yungou.product_id",'=','mcy_yungou_order.product_id');
    //                               })
    //                              ->join('mcy_order','mcy_yungou_order.order_id','mcy_order.order_id')
    //                              ->where('mcy_yungou.huode_id',$mcy_user->mcy_user_id)
    //                              ->where('mcy_yungou_order.mcy_user_id',$mcy_user->mcy_user_id)
    //                              ->select($select)
    //                              ->orderBy('mcy_yungou_order.created_at','desc')
    //                              ->get();
    $huode_list = McyYunGou::join('mcy_yungou_order','mcy_yungou_order.go_id','mcy_yungou.huode_order_id')
                                 ->join('mcy_order','mcy_yungou_order.order_id','mcy_order.order_id')
                                 ->join('mcy_product','mcy_yungou_order.product_id','mcy_product.product_id')
                                 ->where('mcy_yungou.huode_id',$mcy_user->mcy_user_id)
                                 ->select($select)
                                 ->orderBy('mcy_yungou.huode_order_time','desc')
                                 ->get();
    foreach($huode_list as  $key => $value)
    {
      if (!($value->huode_id == ''))
      {
        $value->codeState = 3;
        $huode = McyUser::where('mcy_user_id',$value->huode_id)->where('is_delete',0)->first();
      }
      $value->shopid = $value->product_id;
      $value->thumb = $value->product_img;
      $value->LoadPic = $value->product_img;
      $value->qishu = $value->qishu;
      $value->title = $value->product_name;
      $value->money = $value->product_price;
      $value->q_uid = $value->mcy_user_id;
      $value->q_user = @$huode->username;
      $value->huode_code = $value->huode_ma;
      $value->zongrenshu = $value->zongshu;
      $value->canyurenshu = $value->shenyurenshu;
      $value->q_end_time = $value->huode_order_time;
    }
    return view('mcy.user_huode',compact('huode_list'));
  }
  public function userBuyList(Request $request)
  {

    $mcy_user = McyUser::getUserInfo();

    $buylist = McyYunGouOrder::join('mcy_product','mcy_product.product_id','=','mcy_yungou_order.product_id')
                                 ->join('mcy_yungou',function($join){
                                    $join->on("mcy_yungou.qishu",'=','mcy_yungou_order.qishu');
                                    $join->on("mcy_yungou.product_id",'=','mcy_yungou_order.product_id');
                                  })
                                  ->where('mcy_yungou_order.mcy_user_id',$mcy_user->mcy_user_id)->orderBy('mcy_yungou_order.created_at','desc')->limit(50)->get();
    return view("mcy.user_buy_list",compact('buylist'));
  }
  public function userData(Request $request)
  {
    //$openid = $request->session()->get('openid');
    $mcy_user = McyUser::getUserInfo();
    /* 充值记录最近50条 */
    $charge = McyTopUp::where('is_delete',0)->where('mcy_user_id',$mcy_user->mcy_user_id)->where('status',1)->limit(50)->orderBy('created_at','desc')->get();
    /* 消费记录最近50条 */
    $consumption = McyOrder::where('is_delete',0)->where('order_user_id',$mcy_user->mcy_user_id)->where('order_status',">=",2)->limit(50)->orderBy('created_at','desc')->get();

    return view("mcy.user_info",compact('mcy_user','charge','consumption'));
  }
  public function userInfo(Request $request)
  {
    $mcy_user_id = $request->mcy_user_id;
    $mcy_user = McyUser::where('is_delete',0)->where('mcy_user_id',$mcy_user_id)->first();
    if ($mcy_user)
    {
      return view('mcy.user_data',compact('mcy_user'));
    }else{
      $type = 2;
      $msg = "该用户已经设置了好友权限查看，如需设置，请联系管理员";
      return view('mcy.msg',compact('type','msg'));
    }
  }

  public function userProfile(Request $request)
  {
    $mcy_user = McyUser::getUserInfo();
    return view("mcy.user_profile",compact('mcy_user'));
  }

  public function userShaiDan(Request $request)
  {
    $openid = $request->session()->get('openid');
    $mcy_user = McyUser::where('openid',$openid)->where('is_delete',0)->first();
    $shaidans = McyShaiDan::where('is_delete',0)->where('mcy_user_id',$mcy_user->mcy_user_id)->get();
    return view('mcy.user_shaidan',compact('mcy_user','shaidans'));
  }


  /* 钱方支付 */
  public function QianDangPay(Request $request)
  {
    $openid = $request->session()->get('openid');
    $mcy_user = McyUser::where('openid',$openid)->first();
    /* 临时保存 */
    // $session = $request->session()->get('welkin_s');
    // if ($request->session()->has('welkin_s'))
    // {
    //  $params = $request->session()->get('welkin_s');
    // }else{
      // $session = $request->session()->get('params');
      // $request->session()->put('welkin_s',$session,120);
      $params = $request->session()->get('params');
    // }
 
    return view('mcy.pay',compact('params'));
  }
  public function userMyCode(Request $request)
  {

      $mcy_user_id = session('user_id');
      $url = McyUser::getQRcode($mcy_user_id);

      echo  QrCode::format('png')->size(200)->encoding('UTF-8')->generate($url);
      exit;
  }
  public function userRedBag(Request $request)
  {
    $openid = $request->session()->get('openid');
    $mcy_ser = McyUser::where('openid',$openid)->where('is_delete',0)->first();
    $type = 2;
    $msg = "该功能正在开发中";
    return view('mcy.msg',compact('type','msg'));
  }

  public function userCreateShaiDan(Request $request)
  {
    $yungou_id = $request->yungou_id;
    $yungou_shop = McyYunGou::where('is_delete',0)->where('yungou_id',$yungou_id)->first();
    if ($yungou_shop->is_shaidan == 0)
    {
      /* 没有晒单 空白填写*/
      $shaidan = '';
    }else{
      /* 已经晒单 修改晒单*/
      $shaidan = McyShaiDan::where('is_delete',0)->where('shaidan_id',$yungou_shop->shaidan_id)->first();
    }
    return view('mcy.fshaidan_create',compact('shaidan','yungou_id'));
  }
  public function userHuodeListCreateKuaiDi(Request $request)
  {
    $yungou_id = $request->yungou_id;
    $yungou = McyYunGou::where('yungou_id',$yungou_id)->where('is_delete',0)->first();
    if ($yungou->order_mobile == '')
    {

      $mcy_user = McyUser::getUserInfo();
      return view('mcy.kuaidi',compact('yungou','mcy_user'));
    }else{
      return "我们正在发货，请稍后，如有问题，请联系客服";
    }
  }
  public function userAddMobile(Request $request)
  {
    $openid = $request->session()->get('openid');
    $mcy_user = McyUser::where('is_delete',0)->where('openid',$openid)->first();
    if ($mcy_user)
    {
      return view('mcy.user_mobile',compact('mcy_user'));
    }else{
      return redirect('/mcy/user');
    }
  }

  /* 地址管理 */
  public function userAddress(Request $request)
  {
    $openid = $request->session()->get('openid');
    $mcy_user = McyUser::where('is_delete',0)->where('openid',$openid)->first();
    if ($mcy_user)
    {
      $address = McyAddress::where('mcy_user_id',$mcy_user->mcy_user_id)->where('is_delete',0)->get();
      return view('mcy.user_address',compact('address','mcy_user'));
    }else{
      $type = 2;
      $msg = "请重新登录";
      return view('mcy.msg',compact('msg','type'));
    }
  }

  public function userAddressCreate(Request $request)
  {
    $openid = $request->session()->get('openid');
    $mcy_user = McyUser::where('is_delete',0)->where('openid',$openid)->first();
    if ($mcy_user)
    {
      return view('mcy.user_address_create',compact('mcy_user'));
    }else{
      $type = 2;
      $msg = "请重新登录";
      return view('mcy.msg',compact('msg','type'));
    }
  }

  public function userAddressUpdate(Request $request)
  {
    $openid = $request->session()->get('openid');
    $mcy_user = McyUser::where('is_delete',0)->where('openid',$openid)->first();
    if ($mcy_user)
    {
      $address_id = $request->address_id;
      $address = McyAddress::where('mcy_user_id',$mcy_user->mcy_user_id)->where('is_delete',0)->where('address_id',$address_id)->first();
      if ($address)
      {
        return view('mcy.user_address_update',compact('mcy_user','address'));
      }else{
        $type = 2;
        $msg = "没有这个地址或者改地址已经被删除";
        return view('mcy.msg',compact('msg','type'));
      }
    }else{
      $type = 2;
      $msg = "请重新登录";
      return view('mcy.msg',compact('msg','type'));
    }
  }


    /**
     * 福分提现申请
     */
    public function userFubiWithdraw(Request $request)
    {

        $mcy_user = McyUser::getUserInfo();
        if ($mcy_user)
        {
            $wxinfo = McyWxInfo::where('wxinfo_id',8)->first();
            WxPayConfig::$APPID = $wxinfo->appid;
            WxPayConfig::$APPSECRET = $wxinfo->appsecret;
            $params = WeixinUtil::get_weixin_params();

            //计算正在冻结的福分
            $dongjie =  McyWithDraw::where("is_delete",0)->where('mcy_user_id',$mcy_user->mcy_user_id)->where('status',0)->sum('score');

            return view('mcy.user_fubiwithdraw',compact('mcy_user','params','dongjie','active_fubi'));
        }else{
            return redirect('/mcy/user');
        }
    }

    /**
     * 兑换福分记录
     */
    public function userDuihuanHistory(Request $request){

        //用户信息
        $mcy_user = McyUser::getUserInfo();
        if($mcy_user){
            //获取福分记录
            $fubi_duihuan_list = FubiDuihuan::where("mcy_user_id",$mcy_user->mcy_user_id)->orderby('created_at','desc')->paginate(10);
            //遍历获取商品
            if($fubi_duihuan_list){
                foreach ($fubi_duihuan_list  as $key=>$val){
                    $yungou_shop = McyYunGou::where("yungou_id",$val['yungou_id'])->select('product_name','qishu')->first();

                    if($yungou_shop){

                        $val['zhongjiang'] = '(第'.$yungou_shop->qishu.'期)'.$yungou_shop->product_name;
                        $fubi_duihuan_list[$key] = $val;
                    }else{
                        unset($fubi_duihuan_list[$key]);
                    }

                }
            }

            return view('mcy.user_duihuan_history',compact('fubi_duihuan_list'));
        }else{
            return redirect('/mcy/user');
        }

    }

    /**
     * 佣金记录
     */
    public function userYongjingHistory(Request $request){

        //用户信息
        $mcy_user = McyUser::getUserInfo();
        if($mcy_user){
            //获取佣金记录
            $yongjing_list = Yongjing::where("get_user_id",$mcy_user->mcy_user_id)->paginate(10);
            //遍历获取用户
            if($yongjing_list){
                foreach ($yongjing_list  as $key=>$val){
                    $pay_user = McyUser::where("mcy_user_id",$val['pay_user_id'])->select('username')->first();
                    if($val['type']==1){
                        $val['typename'] = '兑换福分';
                    }elseif($val['type']==2){
                        $val['typename'] = '充值';
                    }else{
                        $val['typename'] = '';
                    }
                    $val['username'] = $pay_user?$pay_user->username:'';
                    $yongjing_list[$key] = $val;

                }
            }

            return view('mcy.user_yongjing_history',compact('yongjing_list'));
        }else{
            return redirect('/mcy/user');
        }
    }


    /**
     * 申请超级代理商页面
     */
    public function userSupperMaster(Request $request)
    {

        $mcy_user = McyUser::getUserInfo();
        if ($mcy_user)
        {

            $wxinfo = McyWxInfo::where('wxinfo_id',8)->first();
            WxPayConfig::$APPID = $wxinfo->appid;
            WxPayConfig::$APPSECRET = $wxinfo->appsecret;
            $params = WeixinUtil::get_weixin_params();


          //检查用户是否提交过申请
          $supper_master_apply = McySupermasterApply::where("mcy_user_id",$mcy_user->mcy_user_id)->first();
          if($supper_master_apply){
              $url = McySupermasterApply::getSuperQRcode($supper_master_apply->token);
          }else{
              $url = '';
          }

          return view('mcy.user_suppermaster',compact('mcy_user','params','supper_master_apply','url'));
        }else{
            return redirect('/mcy/user');
        }
    }

    /**
     * 好友管理首页
     */
    public function userHomeFriend(Request $request){

      return view('mcy.user_home_friend');
    }

    /**
     * 好友管理详情页
     */
    public function userHomeFriends(Request $request){

      //用户信息
      $mcy_user = McyUser::getUserInfo();
      //网站配置信息
      $site = McySite::getInfo();

      //查看用户是否超级代理商
      $mcy_super_master = McySupermasterApply::checkSuperUser($mcy_user->mcy_user_id);

      $inviteUser = array();
      if($mcy_super_master){//超级
        //成功邀请的会员
        $inviteCount = McyUser::where("super_master_id",$mcy_user->mcy_user_id)->where('is_delete','0')->count();
        $inviteUser  = McyUser::where("super_master_id",$mcy_user->mcy_user_id)->where('is_delete','0')->paginate(10);
      }else{//普通
        //成功邀请的会员
        $inviteCount =  McyUser::where("master_id",$mcy_user->mcy_user_id)->where('is_delete','0')->count();
        $inviteUser  = McyUser::where("master_id",$mcy_user->mcy_user_id)->where('is_delete','0')->paginate(10);
      }

      //已参与购买会员数
      $hasBuyCount = 0;
      if($inviteUser){
        foreach($inviteUser as $key=>$val){

          //是否充值
          $mcy_top_up = McyTopUp::where('mcy_user_id',$val->mcy_user_id)->where('status',1)->first();
          $inviteUser[$key]['is_chongzhi'] = $mcy_top_up?'已充值':'未充值';
          if($mcy_top_up){
            $hasBuyCount++;
          }
        }
      }



      return view('mcy.user_home_friends',compact('mcy_user','site','inviteCount','hasBuyCount','inviteUser'));
    }

  /**
   * 好友管理明细
   */
  public function userInviteCommissions(Request $request){

    //用户信息
    $mcy_user = McyUser::getUserInfo();
    //网站配置信息
    $site = McySite::getInfo();

    //获取所有邀请客户
    $invite_user = McyUser::getInviteUser($mcy_user->mcy_user_id);

    //累计收入和提现
    $shouru_fufen = Yongjing::where('get_user_id',$mcy_user->mcy_user_id)->where('add_plus',1)->sum('qty');
    $tixian_fufen = Yongjing::where('get_user_id',$mcy_user->mcy_user_id)->where('add_plus',2)->sum('qty');
    //福分转元
    $shouru_count = Tools::formatMoney($shouru_fufen*$site->score_money);
    $tixian_count = Tools::formatMoney($tixian_fufen*$site->score_money);

    //活动福分转元
    $active_money = Tools::formatMoney($mcy_user->score*$site->score_money);
    //计算正在冻结的福分
    $dongjie_score =  McyWithDraw::where("is_delete",0)->where('mcy_user_id',$mcy_user->mcy_user_id)->where('status',0)->sum('score');
    $dongjie_money = Tools::formatMoney($dongjie_score*$site->score_money);

    //佣金福币明细
    $mcy_yongjin = Yongjing::where('get_user_id',$mcy_user->mcy_user_id)->orderby('created_at','desc')->paginate(20);
    if($mcy_yongjin){
      foreach($mcy_yongjin as $key=>$val){

            if($val->add_plus==1){
              $mcy_yongjin[$key]['fuhao'] = '+';
            }elseif($val->add_plus==2){
              $mcy_yongjin[$key]['fuhao'] = '-';
            }
            if($val->get_user_id==$val->pay_user_id){
                $mcy_yongjin[$key]['username'] = $mcy_user->username;
            }else{
                //客户名
                $mcy_yongjin[$key]['username'] = isset($invite_user[$val->pay_user_id])? $invite_user[$val->pay_user_id]:'';
            }

            //描述
            $mcy_yongjin[$key]['desc'] = Yongjing::getType($val->type);
            //福分小数转
            $mcy_yongjin[$key]['qty'] = Tools::formatMoney($val->qty);
            //购买拼接云购的商品页
            $mcy_yongjin[$key]['url'] = '#';
            //提现的基数显示
            if($val->type==4){
                $val->jishu = '-';
            }
            if($val->type==3){
                $mcy_yungou = McyYunGou::where("yungou_id",$val->yungou_id)->select('product_id','qishu','status')->first();
                if($mcy_yungou){
                  if($mcy_yungou->status==1){
                    $mcy_yongjin[$key]['url'] = url('/going/product?product_id='.$mcy_yungou->product_id.'&qishu='.$mcy_yungou->qishu);
                  }else{
                    $mcy_yongjin[$key]['url'] = url('/product?product_id='.$mcy_yungou->product_id.'&qishu='.$mcy_yungou->qishu);
                  }
                }

            }

      }
    }
    return view('mcy.user_invite_commissions',compact('mcy_user','site','shouru_count','tixian_count','mcy_yongjin','dongjie_money','active_money'));
  }

  /**
   * 好友管理提现
   */
  public function userInviteCashout(Request $request){

    //用户信息
    $mcy_user = McyUser::getUserInfo();
    //网站配置信息
    $site = McySite::getInfo();

    //活动福分转元
    $active_money = Tools::formatMoney($mcy_user->score*$site->score_money);
    //计算正在冻结的福分
    $dongjie_score =  McyWithDraw::where("is_delete",0)->where('mcy_user_id',$mcy_user->mcy_user_id)->where('status',0)->sum('score');
    $dongjie_money = Tools::formatMoney($dongjie_score*$site->score_money);

    //提现记录
    $select  = array('withdraw_price','created_at','bank_id','status');
    $withdraw_list = McyWithDraw::where('is_delete',0)->where('mcy_user_id',$mcy_user->mcy_user_id)
        ->select($select)->orderby('status','asc')->orderby('created_at','desc')->paginate(10);

    return view('mcy.user_invite_cashout',compact('mcy_user','site','dongjie_money','active_money','withdraw_list'));
  }


  /**
   * 中奖兑换福分页面
   */
  public function userDuihuan(Request $request){

    //要兑换的云购商品
    $yungou_id = $request->yungou_id;
    $mcy_user = McyUser::getUserInfo();
    $yungou_shop = McyYunGou::where('yungou_id',$yungou_id)->where('is_delete',0)->first();

    if ($mcy_user &&  $yungou_shop)
    {

      if($yungou_shop->huode_id!=$mcy_user->mcy_user_id){
        return Tools::showMessage('这个云购单的中奖用户并非当前用户',url('mcy/user'));
      }


      //网站配置信息
      @$site = McySite::getInfo();

      //兑换回扣
      $rate_duihuan = $site->rage_duihuan;

      //福分和元比值
      $score_money =  $site->score_money;
      //兑换比例100-回扣
      $rate_user = 100-$rate_duihuan;

      //兑换福分换算
      $product = McyProduct::find($yungou_shop->product_id);
      $add_score =   floor($product->product_price*$rate_user/100/$score_money);

      return view('mcy.user_duihuan',compact('mcy_user','add_score','yungou_shop','product'));
    }else{
      return redirect('/mcy/user');
    }
  }
}
