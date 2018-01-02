<?php

namespace App\Http\Controllers\Mcy;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Response;
use App\Tools;
use App\Tools\MyLog\SiteLog;
use App\Model\McyUser;
use App\Model\McySite;
use App\Model\McyOrder;
use App\Model\McyTopUp;
use App\Model\McyPay;
use App\Tools\MyLog\WechatLog;
use App\Tools\swiftpass\Utils;
use App\Model\McyActivity;
use Illuminate\Support\Facades\DB;

class McyPayInfoController extends Controller
{    
   /**
   * 用户管理
   * @AiHuanGou
   * @DateTime      2017-04-07T10:52:48+0800
   * @param         Request                  $request 
   * @return        view                            
   */
  public function payinfo(Request $request)
  {
  	
  	$starttime = empty($request->input('starttime',''))?'1971-1-1':$request->input('starttime').' 00:00:00';
  	$endtime = empty($request->input('endtime',''))?'2099-12-31':$request->input('endtime').' 23:59:59';
  	$searchtext = $request->input('searchtext','');
    $admin_id = $request->session()->get('admin_id');
  	if (!($searchtext == ''))
  	{
  		$payinfos = McyPay::where('is_delete',0)->where('user_id',$admin_id)->where('pay_name','like','%'.$searchtext.'%')->whereBetween('created_at',[$starttime,$endtime])->orderBy('sort','desc')->paginate(20);
  	}else{
  		$payinfos = McyPay::where('is_delete',0)->where('user_id',$admin_id)->whereBetween('created_at',[$starttime,$endtime])->orderBy('sort','desc')->paginate(20);
  	}

  	return view('welkin.mcy.pays',compact('payinfos','starttime','endtime','searchtext'));
  }

  public function payInfoCreate(Request $request)
  {
    return view('welkin.mcy.payinfo_create');
  }

  public function payInfoUpdate(Request $request)
  {
    $admin_id = $request->input('admin_id');
    $payinfo_id = $request->input('payinfo_id');
    $payinfo = McyPay::where('is_delete',0)->where('payinfo_id',$payinfo_id)->first();
    return view('welkin.mcy.payinfo_update',compact('payinfo'));
  }

  public function ReturnUrl(Request $request)
  {
    $method = $request->method;

    if ($method == 'qianfang1') {
       $out_trade_no = $request->input('outTradeNo');
       $money = intval($request->input("orderPrice"));
       $topup = McyTopUp::where('is_delete',0)->where('order_no',$out_trade_no)->first();
       if ($topup->status == 1)
       {
         $type = 5;
         $msg = "充值成功";
         return view('mcy.msg',compact("type",'msg'));
       }else{
         return redirect('/mcy/user');
       }
       dd($topup);
       $type = 4;
      
    }else{

    }
    $money = $request->input("money");
    /* 判断是否购买还是充值 */
    $payway = $request->input("payway");
    $out_trade_no = $request->input('out_trade_no');
    $openid = $request->session()->get('openid');
    if ($openid)
    {
      $topup = McyTopUp::where('is_delete',0)->where('order_no',$out_trade_no)->where('price',$money)->first();
      if ($topup)
      {
       
        sleep(2);
        if ($topup->status ==1)
        {
           WechatLog::info("openid: $openid 的订单号 $out_trade_no 充值 $money");
          if ($payway == 1)
          {
            $type = 1;
            $msg = "充值成功";
          }else{
            $type = 1;
            $msg = "购买成功";
          }
        }else{
           WechatLog::info("延迟订单  openid: $openid 的订单号 $out_trade_no 充值 $money");
          if ($payway == 1)
          {
            $type = 1;
            $msg = "充值成功，服务器繁忙<br>正在加紧处理订单";
          }else{
            $type = 1;
            $msg = "购买成功，服务器繁忙<br>正在加紧处理订单";
          }
        }
        return view('mcy.msg',compact('type','msg'));
      }else{
        WechatLog::info("找不到 ：openid: $openid 的订单号 $out_trade_no 充值 $money");
         if ($payway == 1)
        {
            $type = 2;
            $msg = "充值失败";
        }else{
            $type = 2;
            $msg = "购买失败";
        }
        return view('mcy.msg',compact("type",'msg'));
      }
    }else{
      return "操作失败";
    }
  }
  public function NotifyUrl(Request $request)
  {
    WechatLog::info('回调开始：');
    $method = $request->method;
    switch ($method) {
      case 'swiftpass':
        $r =  $this->swiftpass_n($request);
        break;
      case 'qianfang':
        $r = $this->qianfang_n($request);
        break;
      case 'qianfang1':
        $r = $this->qianfang_n($request);
        break;
      case 'aihuangoutoqianfang':
        $r = $this->aihuangoutoqianfang($request);
        break;
      case 'aihuangoutoqqpay':
        $r = $this->aihuangoutoqqpay($request);
        break;
      case 'aihuangou':
        $r = $this->aihuangou($request);
        break;
      case 'aihuangou1':
        $r = $this->aihuangou($request);
        break;
      default:
        $r =  $this->swiftpass_n($request);
        break;
    }

    return $r;
  }
  public function qianfang_n($request)
  {
    WechatLog::info($request->input());
    $rdata = $request->input();
    $out_trade_no = @$rdata['outTradeNo'];
    WechatLog::info($out_trade_no);
    if ($out_trade_no)
    {
      $topup = McyTopUp::where('is_delete',0)->where('order_no',$out_trade_no)->first();
      if ($topup)
      {
        if ($topup->status == 0)
        {
          $payinfo_id = $topup->payinfo_id;
          $payinfo = McyPay::where('payinfo_id',$payinfo_id)->first();
          if ($payinfo)
          {
            if ($payinfo->pay_account == $rdata['payKey'])
            {
              /* 充值 */
              $mcy_user = McyUser::where('mcy_user_id',$topup->mcy_user_id)->first();
              if (!($rdata['orderPrice'] == $topup->price))
              {
                return 'fail';
              }else{}
              $mcy_user->money += ($rdata['orderPrice']);
              $mcy_user->jingyan += ($rdata['orderPrice']);
              $mcy_user->save();

              $topup->status = 1;
              $topup->save();
              $this->yongjing_chongzhi($topup);
              return  "success";
            }else{
              return  'fail';
            }
          }else{
            return  'fail';
          }
        }else{
          return  'success';
        }
      }else{
        return  'fail';
      }
      return  'success';
    }else{
      return  'fail';
    }
    // file_put_contents('s_return', $xml);
  }
  public function aihuangoutoqianfang($request)
  {
    WechatLog::info($request->input());
    $rdata = $request->input();
    $out_trade_no = @$rdata['outTradeNo'];
    $tradeStatus = @$rdata['tradeStatus'];
    WechatLog::info($out_trade_no);

    $site = McySite::getInfo();


    if ($tradeStatus=='SUCCESS') {
      if ($out_trade_no)
      {
        $topup = McyTopUp::where('is_delete',0)->where('order_no',$out_trade_no)->first();
        if ($topup)
        {
          if ($topup->status == 0)
          {
            $payinfo_id = $topup->payinfo_id;
            $payinfo = McyPay::where('payinfo_id',$payinfo_id)->first();
            if ($payinfo)
            {
              if ($payinfo->pay_account == $rdata['payKey'])
              {
                /* 充值 */
                $mcy_user = McyUser::where('mcy_user_id',$topup->mcy_user_id)->first();
                if (!($rdata['orderPrice'] == $topup->price))
                {
                  return 'fail';
                }else{}

                //1.开启事务
                DB::beginTransaction();
                try{
                  //2.账户余额增加
                  $mcy_user->money += ($rdata['orderPrice']);
                  $mcy_user->jingyan += ($rdata['orderPrice']);
                  $mcy_user->save();


                  //3.充值成功记录状态
                  $topup->status = 1;
                  $topup->save();
                  $this->yongjing_chongzhi($topup);

                  //4.判断是否超级代理商推广的
                  if(!empty($mcy_user->super_master_id)){

                    $super_master_score = round(($rdata['orderPrice']*$site->rage_chongzhi_master/100)/$site->score_money,2);//总费用*佣金百分比等于超级代理商所获得福分

                    $super_user = McyUser::getUserByUserId($mcy_user->super_master_id);
                    if($super_user){

                      //福分增加
                      $super_user->score += $super_master_score;
                      $super_user->save();
                      //写入记录
                      $mcy_yongjing = new Yongjing();
                      $mcy_yongjing->get_user_id = $mcy_user->super_master_id;
                      $mcy_yongjing->pay_user_id = $mcy_user->mcy_user_id;
                      $mcy_yongjing->type = 2;
                      $mcy_yongjing->add_plus = 1;
                      $mcy_yongjing->qty = $super_master_score;
                      $mcy_yongjing->rage = $site->rage_buy_master.'%';
                      $mcy_yongjing->jishu = $rdata['orderPrice'];
                      $mcy_yongjing->yungou_id = $topup->topup_id;
                      $mcy_yongjing->remark = '充值';
                      $mcy_yongjing->save();
                    }
                  }

                  DB::commit(); //提交
                }catch (\Exception $e) {
                  DB::rollBack(); //回滚
                }

                return  "success";
              }else{
                return  'fail';
              }
            }else{
              return  'fail';
            }
          }else{
            return  'success';
          }
        }else{
          return  'fail';
        }
        return  'success';
      }else{
        return  'fail';
      }
    }

    // file_put_contents('s_return', $xml);
  }


  public function aihuangoutoqqpay($request)
  {
    WechatLog::info($request->input());
    $rdata = $request->input();
    $out_trade_no = @$rdata['outTradeNo'];
    $tradeStatus = @$rdata['tradeStatus'];
    WechatLog::info($out_trade_no);

    $site = McySite::getInfo();

    if ($tradeStatus=='SUCCESS') {
      if ($out_trade_no)
      {
        $topup = McyTopUp::where('is_delete',0)->where('order_no',$out_trade_no)->first();
        if ($topup)
        {
          if ($topup->status == 0)
          {
            $payinfo_id = $topup->payinfo_id;
            $payinfo = McyPay::where('payinfo_id',$payinfo_id)->first();
            if ($payinfo)
            {
              if ($payinfo->pay_account == $rdata['payKey'])
              {
                /* 充值 */
                $mcy_user = McyUser::where('mcy_user_id',$topup->mcy_user_id)->first();
                if (!($rdata['orderPrice'] == $topup->price))
                {
                  return 'fail';
                }else{}

                //1.开启事务
                DB::beginTransaction();
                try{
                  //2.账户余额增加
                  $mcy_user->money += ($rdata['orderPrice']);
                  $mcy_user->jingyan += ($rdata['orderPrice']);
                  $mcy_user->save();


                  //3.充值成功记录状态
                  $topup->status = 1;
                  $topup->save();
                  $this->yongjing_chongzhi($topup);

                  //4.判断是否超级代理商推广的
                  if(!empty($mcy_user->super_master_id)){

                    $super_master_score = round(($rdata['orderPrice']*$site->rage_chongzhi_master/100)*$site->score_money,2);//总费用*佣金百分比等于超级代理商所获得福分

                    $super_user = McyUser::getUserByUserId($mcy_user->super_master_id);
                    if($super_user){

                      //福分增加
                      $super_user->score += $super_master_score;
                      $super_user->save();
                      //写入记录
                      $mcy_yongjing = new Yongjing();
                      $mcy_yongjing->get_user_id = $mcy_user->super_master_id;
                      $mcy_yongjing->pay_user_id = $mcy_user->mcy_user_id;
                      $mcy_yongjing->type = 2;
                      $mcy_yongjing->add_plus = 1;
                      $mcy_yongjing->qty = $super_master_score;
                      $mcy_yongjing->rage = $site->rage_buy_master.'%';
                      $mcy_yongjing->jishu = $rdata['orderPrice'];
                      $mcy_yongjing->yungou_id = $topup->topup_id;
                      $mcy_yongjing->remark = '充值';
                      $mcy_yongjing->save();
                    }
                  }

                  DB::commit(); //提交
                }catch (\Exception $e) {
                  DB::rollBack(); //回滚
                }

                return  "success";
              }else{
                return  'fail';
              }
            }else{
              return  'fail';
            }
          }else{
            return  'success';
          }
        }else{
          return  'fail';
        }
        return  'success';
      }else{
        return  'fail';
      }
    }

    // file_put_contents('s_return', $xml);
  }

  public function qianfang_n1($request)
  {
    WechatLog::info($request->input());
    $rdata = $request->input();
    $out_trade_no = @$rdata['outTradeNo'];
    WechatLog::info($out_trade_no);
    if ($out_trade_no)
    {
      $topup = McyTopUp::where('is_delete',0)->where('order_no',$out_trade_no)->first();
      if ($topup)
      {
        if ($topup->status == 0)
        {
          $payinfo_id = $topup->payinfo_id;
          $payinfo = McyPay::where('payinfo_id',$payinfo_id)->first();
          if ($payinfo)
          {
            if ($payinfo->pay_account == $rdata['payKey'])
            {
              /* 充值 */
              $mcy_user = McyUser::where('mcy_user_id',$topup->mcy_user_id)->first();
              if (!($rdata['orderPrice'] == $topup->price))
              {
                return 'fail';
              }else{}
              $mcy_user->money += ($rdata['orderPrice']);
              $mcy_user->jingyan += ($rdata['orderPrice']);
              $mcy_user->save();

              $topup->status = 1;
              $topup->save();
              $this->yongjing_chongzhi($topup);
              return  "success";
            }else{
              return  'fail';
            }
          }else{
            return  'fail';
          }
        }else{
          return  'success';
        }
      }else{
        return  'fail';
      }
      return  'success';
    }else{
      return  'fail';
    }
    // file_put_contents('s_return', $xml);
  }
  public function aihuangou($request)
  {
    $rdata = $request->input();
    WechatLog::info(@$rdata);
    $out_trade_no = @$rdata['orderNo'];
    if ($rdata['respCode'] == '0000')
    {
      $topup = McyTopUp::where('is_delete',0)->where('order_no',$out_trade_no)->first();
      if ($topup)
      {
        if ($topup->status == 0)
        {
          $payinfo_id = $topup->payinfo_id;
          $payinfo = McyPay::where('payinfo_id',$payinfo_id)->where('is_delete',0)->first();
          if ($payinfo)
          {
            WechatLog::info(json_encode($payinfo));
            WechatLog::info(json_encode($payinfo->pay_account));
            WechatLog::info(json_encode($rdata['merNo']));
            WechatLog::info(json_encode($rdata['transAmt']));
            WechatLog::info(json_encode($topup->price));
            if ($payinfo->pay_account == $rdata['merNo'])
            {
              $rdata['transAmt'] = $rdata['transAmt'] / 100;
              /* 充值 */
              $mcy_user = McyUser::where('mcy_user_id',$topup->mcy_user_id)->first();
              if (!($rdata['transAmt'] == $topup->price))
              {
                return 'fail';
              }else{}
              $mcy_user->money += ($rdata['transAmt']);
              $mcy_user->jingyan += ($rdata['transAmt']);
              $mcy_user->save();

              $topup->status = 1;
              $topup->save();
              $this->yongjing_chongzhi($topup);
              return  "success";
            }else{
              return  'fail';
            }
          }else{
            return  'fail';
          }
        }else{
          return  'success';
        }
      }else{
        return  'fail';
      }
      return  'success';
    }else{
      return  'fail';
    }
    // file_put_contents('s_return', $xml);
  }
  public function swiftpass_n($request)
  {
    WechatLog::info(json_encode($request));
    $xml = file_get_contents('php://input');
    WechatLog::info(json_encode($xml));
    $rdata = Utils::parseXML($xml);
    $out_trade_no = @$rdata['out_trade_no'];
    if ($out_trade_no)
    {
      $topup = McyTopUp::where('is_delete',0)->where('order_no',$out_trade_no)->first();
      if ($topup)
      {
        if ($topup->status == 0)
        {
          $payinfo_id = $topup->payinfo_id;
          $payinfo = McyPay::where('payinfo_id',$payinfo_id)->first();
          if ($payinfo)
          {
            if ($payinfo->pay_account == $rdata['mch_id'])
            {
              /* 充值 */
              $mcy_user = McyUser::where('mcy_user_id',$topup->mcy_user_id)->first();
              $mcy_user->money += ($rdata['total_fee'] / 100);
              $mcy_user->jingyan += ($rdata['total_fee'] / 100);
              $mcy_user->save();

              $topup->status = 1;
              $topup->save();
              $this->yongjing_chongzhi($topup);
              return  "success";
            }else{
              return  'fail';
            }
          }else{
            return  'fail';
          }
        }else{
          return  'success';
        }
      }else{
        return  'fail';
      }
      return  'success';
    }else{
      return  'fail';
    }
    // file_put_contents('s_return', $xml);
  }
  public function yongjing_chongzhi($topup)
  {
    /* 判断是否有活动 */
    $activity = McyActivity::where('is_delete',0)->where('user_id',6)->first();
    if ($activity)
    {
      if ($activity->activity_status == 0)
      {
        // 启用
        if ($activity->activity_type == 0)
        {
          //  首冲
          $topups = McyTopUp::where('is_delete',0)->where('mcy_user_id',$topup->mcy_user_id)->whereBetween('created_at',[$activity->activity_start_time,$activity->activity_end_time])->where('status',1)->count();
          if ($topups == 1)
          {
            // 确实第一次充值
            if ($topup->price >= $activity->money_full)
            {
              $mcy_user = McyUser::where('is_delete',0)->where('mcy_user_id',$topup->mcy_user_id)->first();
              $mcy_user->money += $activity->money_get;
              $mcy_user->save();
            }else{
              // 充值钱数不够
            }
          }else{
           // 不是第一次充值，不管;
          }
        }else{
          // 冲满
          if ($topup->price >= $activity->money_full)
          {
              $mcy_user = McyUser::where('is_delete',0)->where('mcy_user_id',$topup->mcy_user_id)->first();
              $mcy_user->money += $activity->money_get;
              $mcy_user->save();
          }else{
              // 充值钱数不够
          }
        }
      }else{

      }
    }else{

    }
    /* 判断是否有佣金 */
    $mcy_user = McyUser::where('mcy_user_id',$topup->mcy_user_id)->where('is_delete',0)->first();
    if ($mcy_user)
    {
      if ($mcy_user->is_slave == 1)
      {
        /*是，给佣金*/
        $master_id = $mcy_user->master_id;
        $master = McyUser::where('is_delete',0)->where('mcy_user_id',$master_id)->first();
        if ($master)
        {
          $siteinfo = McySite::where('is_delete',0)->where('user_id',6)->first();
          $master->slave_money += ($topup->price) * ( $siteinfo->rate_yongjin / 100 );
          $master->save();
        }else{

        }

      }else{

      }
    }else{

    }
  }



}
