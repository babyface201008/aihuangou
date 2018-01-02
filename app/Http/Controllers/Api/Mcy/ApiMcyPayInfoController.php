<?php

namespace App\Http\Controllers\Api\Mcy;
use App\Model\Yongjing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Mcy\McyAutoManController as AutoMan;
use App\Tools;
use App\Tools\Swiftpass;
use App\Tools\QianFang;
use App\Tools\QianFang1;
use App\Tools\Aihuangou1;
use App\Response;
use App\ApiResponse;
use App\Model\McyUser;
use App\Model\McyProduct;
use App\Model\McyPay;
use App\Model\McySite;
use App\Model\McyTopUp;
use App\Model\McyYunGou;
use App\Model\McyOrder;
use App\Model\McyYunGouOrder;
use App\Tools\WeixinUtil;
use App\Tools\WXPAY\Lib\WxPayConfig;
use App\Tools\MyLog\WechatLog;
use App\Model\McyWxInfo;
use Illuminate\Support\Facades\DB;

class ApiMcyPayInfoController extends Controller
{
    public $url  = '';
    public $secret_key  = '';
    public $mch_id  = '';

    public function apiMcyPayInfoCreate(Request $request)
    {
        $response = new ApiResponse;
        parse_str($request->input('data') , $data);
        $admin_id = $request->session()->get('admin_id');
        if ($admin_id)
        {
          $model = 'App\Model\McyPay';
          $d = array();
          $d['status'] = @$data['status'];
          $d['pay_name'] = @$data['pay_name'];
          $d['pay_account'] = @$data['pay_account'];
          $d['pay_secret'] = @$data['pay_secret'];
          $d['product_type'] = @$data['product_type'];
          $d['method'] = @$data['method'];
          $d['sort'] = @$data['sort'];
          $d['pay_logo'] = @$request->input('pay_logo')?$request->input('pay_logo'):'';
          $d['user_id'] = $admin_id;
          $result = $response->create($model,$d);
          return $response->toJson();
        }else{
          return $response->reply(2,'会话过期，请重新登录');
        }
        
    }
    public function apiMcyPayInfoUpdate(Request $request)
    {
        $response = new ApiResponse;
        parse_str($request->input('data') , $data);
        $admin_id = $request->session()->get('admin_id');
        if ($admin_id)
        {
          $model = 'App\Model\McyPay';
          $search = array(
            'payinfo_id'=>$data['payinfo_id'],
            'user_id'=>$admin_id
            );
          $d = array();
          $d['pay_name'] = @$data['pay_name'];
          $d['pay_account'] = @$data['pay_account'];
          $d['pay_secret'] = @$data['pay_secret'];
          $d['product_type'] = @$data['product_type'];
          $d['method'] = @$data['method'];
          $d['status'] = @$data['status'];
          $d['sort'] = @$data['sort'];
          $d['pay_logo'] = @$request->input('pay_logo')?$request->input('pay_logo'):'';
          $result = $response->update($model,$search,$d);
          return $response->toJson();
        }else{
          return $response->reply(2,'会话过期，请重新登录');
        }
     
    }
    public function apiMcyPayInfoDelete(Request $request)
    {
      $response = new ApiResponse;
      $admin_id = $request->session()->get('admin_id');
      if ($admin_id) 
      {
        $payinfo_id = $request->input('payinfo_id');
        $model = 'App\Model\McyPay';
        $data = array();
        $data['payinfo_id'] = $payinfo_id;
        $data['user_id'] = $admin_id;
        $response->payinfo_id = $payinfo_id;
        $request = $response->delete($model,$data);
        return $response->toJson();
      }else{
        return $response->reply(3,'会话过期，请重新登录');
      }
    }

    public function chaofenPay(Request $request)
    {
      /* 福分转换 */
      $type = 2;
      return $this->chaobiPay($request,$type);
    }


    /* 余额支付 */
    public function chaobiPay(Request $request,$type_welkin=1)
    {
      $response = new ApiResponse;
      $automan = new AutoMan;
      /* 找出支付用户 */
        $mcy_user =  McyUser::getUserInfo();
        $site = McySite::getInfo();
      // 判断是否有ip地址
      if ($mcy_user)
      {
       if($mcy_user->ip_addr == '')
       {
         $wxinfo = McyWxInfo::where('wxinfo_id',8)->first();
         WxPayConfig::$APPID = $wxinfo->appid;
         WxPayConfig::$APPSECRET = $wxinfo->appsecret;
         /*@$info = json_decode(WeixinUtil::gain_openid($openid));
         @$mcy_user->ip = $request->ip();
         if (!isset($info->errcode) && $info->subscribe == 1)
         {
              if ($info->province == ''){
              }else{
                @$ip_addr = @$info->province.'省';
                @$ip_addr .= @$info->city.'市';
                @$mcy_user->ip_addr = $ip_addr;
              }
         }else{
         }*/
      }else{}
    }else{
      $msg = '账号异常，请联系客服';
      $type = 2;
      @$request->session()->forget('openid');
      return view('mcy.msg',compact('msg','type'));
    }
   

      /* 找出支付产品信息 */
      $cartlists = $request->session()->get('cart');
      $all_count = 0;
      $all_price = 0;
      if ($cartlists)
      {

      }else{
          return redirect('/cartlist');        
      }       
      foreach($cartlists as $key => $cartlist)
      {
          $yungou_shop =  McyYunGou::where('qishu',$cartlist['qishu'])->where('is_delete',0)->where('product_id',$key)->select(array('price','shenyurenshu'))->first();
          if ($yungou_shop->shenyurenshu < intval($cartlist['number'])){
            // if ($yungou_shop->shenyurenshu == 0){
                  unset($cartlists[$key]);
                  // if (count($cartlists) > 0){

                  // }else{
                   $request->session()->put('cart',$cartlists,120);
                   $type = 2;
                   $msg = "对不起，您来晚了，货源不足啦！";
                   return view('mcy.msg',compact('type','msg'));
                 // }
            // }else{
            //   intval($cartlist['number']) = $yungou_shop->shenyurenshu;
            // }
          }else{
            if ($cartlist['number'] <= 0)
            {
                 $request->session()->forget('cart');
                 $type = 2;
                 $msg = "商品数量不足";
                 return view('mcy.msg',compact('type','msg'));
            }else{
              $all_count += 1;
              $all_price += $yungou_shop->price * intval($cartlist['number']);
            }
          }
      }

      $fp = fopen("lock.txt", "r");
      if(flock($fp,LOCK_EX | LOCK_NB))
      {
      //..处理订单
      /* 生成订单 */
      $order = new McyOrder;
      $order->product_id = 1;
      $order->product_name = $site->site_name."-充值";
      $order->order_type = 1;
      $order->order_no = date("YmdHis",time()).mt_rand(0,9).mt_rand(0,9).mt_rand(0,9);
      $order->order_price = $all_price;
      $order->order_user_id = $mcy_user->mcy_user_id;
      $order->order_username = $mcy_user->username;
      $order->save();

          /*本次云购总费用*/
          $total_price = $all_price;

      if ($type_welkin == 1)
      {

            /*扣除余额*/
            if ($mcy_user->money >= $all_price)
            {
              // $mcy_user->money -= $all_price;
              // $mcy_user->save();
            }else{
              $type = 2;
              $msg = "余额不足，支付失败";
              return view('mcy.msg',compact('type','msg'));
            }
      }elseif ($type_welkin == 2) {
                 if ($mcy_user->score >= $all_price * $site->score_money)
        {
            /*$mcy_user->score -= $all_price * 150;
            $mcy_user->save();*/
        }else{
           $type = 2;
           $msg = "福分不足，支付失败";
           return view('mcy.msg',compact('type','msg'));
        }
      }else{
        $type = 2;
        $msg = "支付失败";
        return view('mcy.msg',compact('type','msg'));
      }

      $order->order_status = 2;
      $order->save();

          foreach($cartlists as $key => $cartlist)
          {
              /* 生成云购码 */
              // 找出现有的剩余码
              $yungou_shop1 = McyYunGou::where('is_delete',0)->where('shenyurenshu','>',0)->where('product_id',$cartlist['product_id'])->orderBy('qishu','desc')->orderBy('sort','desc')->first();
              // $mcy_user = McyUser::where('is_delete',0)->where('mcy_user_id',$order->order_user_id)->first();
              $shengyuma = explode(",",$yungou_shop1->shengyuma);
              /* 从中剔除购买的两 */
              // echo $yungou_number;
              $yungou_number = intval($cartlist['number']);
              $yungouma = collect($shengyuma)->random($yungou_number)->toArray();

              /* 判断价钱是否正确*/
               if ($type_welkin == 1)
               {
                  $a_price = $yungou_shop1->price * $yungou_number;
                  if ($mcy_user->money >= $a_price)
                  {
                    $mcy_user->money -= $a_price;
                  }else{
                     $type = 2;
                     $msg = "余额不足，支付失败";
                     return view('mcy.msg',compact('type','msg'));
                  }

               }elseif ($type_welkin ==2){
                  $a_price = $yungou_shop1->price * $yungou_number /$site->score_money;

                  if ($mcy_user->score >= $a_price)
                  {
                      $mcy_user->score -= $a_price;
                      $a_price = $a_price * $site->score_money;
                  }else{
                     $type = 2;
                     $msg = "福分不足，支付失败";
                     return view('mcy.msg',compact('type','msg'));
                  }
               }


              /* 购买之后剩下的码数*/
              $sym = array_diff($shengyuma,$yungouma);
              /* 购买之后的剩余人数 */
              $syrs = $yungou_shop1->shenyurenshu - $yungou_number;
              /* 生成云购订单 */
              $yungou_order = new McyYunGouOrder;
              $yungou_order->product_id = $cartlist['product_id'];
              $yungou_order->order_id = $order->order_id;
              $yungou_order->status = $order->order_status;
              $yungou_order->qishu = $yungou_shop1->qishu;
              $yungou_order->mcy_user_id = $order->order_user_id;
              $yungou_order->product_name = $yungou_shop1->product_name;
              $yungou_order->yungouma = implode(",",$yungouma);
              $yungou_order->allprice = $a_price;
              \DB::beginTransaction();
              /* 成功就commit */
                      if ($yungou_order->save())
                      {
                            /* 去掉购物信息*/
                            $yungou_shop1->shengyuma =  @implode(",",$sym);;
                            $yungou_shop1->shenyurenshu = $syrs;

                                    /*福分增加*/
                                    $mcy_user->score += $a_price;

                                  /*如果是超级代理商推荐的客户,则可以佣金*/
                                  if(!empty($mcy_user->super_master_id)){

                                      $super_master_money = $a_price*$site->rage_buy_master/100;//总费用*佣金百分比等于超级代理商回佣元
                                      //转福分
                                      $super_master_score = Tools::formatMoney($super_master_money/$site->score_money);

                                      $super_user = McyUser::getUserByUserId($mcy_user->super_master_id);
                                      if($super_user){

                                          //福分增加
                                          $super_user->score += $super_master_score;
                                          $super_user->save();
                                          //写入记录
                                          $mcy_yongjing = new Yongjing();
                                          $mcy_yongjing->get_user_id = $mcy_user->super_master_id;
                                          $mcy_yongjing->pay_user_id = $mcy_user->mcy_user_id;
                                          $mcy_yongjing->type = 3;
                                          $mcy_yongjing->add_plus = 1;
                                          $mcy_yongjing->qty = $super_master_score;
                                          $mcy_yongjing->rage = $site->rage_buy_master.'%';
                                          $mcy_yongjing->jishu = $a_price;
                                          $mcy_yongjing->yungou_id = $yungou_shop1->yungou_id;
                                          $mcy_yongjing->remark = '购买';
                                          $mcy_yongjing->save();
                                      }
                                  }

                                    if ($yungou_shop1->save())
                                    {
                                                        if ($mcy_user->save())
                                                        {


                                                                  if ($a_price == ($yungou_shop1->price * $yungou_number))
                                                                  {
                                                                    \DB::commit();
                                                                  }else{
                                                                    \DB::rollback();
                                                                    $type = 2;
                                                                    $msg = "支付失败";
                                                                    return view('mcy.msg',compact('type','msg'));
                                                                    return $response->reply(2,'支付失败');
                                                                  }

                                                        }else{
                                                                      \DB::rollback();
                                                                      $type = 2;
                                                                      $msg = "支付失败";
                                                                      return view('mcy.msg',compact('type','msg'));
                                                                      return $response->reply(2,'支付失败');
                                                         }
                                     }else{
                                                    \DB::rollback();
                                                    $type = 2;
                                                    $msg = "支付失败";
                                                    return view('mcy.msg',compact('type','msg'));
                                                    return $response->reply(2,'支付失败');
                                    }

                                    /* 购买成功发送短信和发送微信模板消息 */
                                    // $send_weixin = $automan->sendBuyProductMessage($order->mcy_user_id,$product_id,1);
                                    $url  = 'http://yyg2.chkg99.com/mcy/user/buylist';
                                    @$send_weixin = $this->send_template_msg($mcy_user->openid,$yungou_shop1->product_name,$a_price,$url);
                                    WechatLog::info("购买发送消息 : 购买人".$mcy_user->username." 购买产品 ：".$yungou_shop1->product_name.' 购买信息'.$send_weixin);
                                    // $send_mobile = $automan->sendBuyProductMessage($order->mcy_user_id,$product_id,2);
                                    /* 购买成功后判断是否商品已经售罄*/
                                    @$sq = $automan->checkProductIsSellOut($order->product_id,$yungou_shop1->yungou_id);
                                    // return true;
                          }else{
                            /* 支付失败就返回现金 */
                            // $mcy_user->money += $order->order_price;
                            // if ($mcy_user->save())
                            // {
                            //   \DB::commit();
                            // }else{
                            //   \DB::rollback();
                            // }

                                $type = 2;
                                $msg = "支付失败";
                                return view('mcy.msg',compact('type','msg'));
                                return $response->reply(2,'支付失败');
                        // return false;
                        }
          }


               /* 购买成功后清空购物车 */
               $request->session()->forget('cart');
               $type = 1;
               $msg = "支付成功";
               return view('mcy.msg',compact('type','msg'));
               // return $response->reply(0,'支付成功');

               flock($fp,LOCK_UN);
          }
      else
      {
        $type = 2;
        $msg = "系统繁忙,请稍候再试";
        fclose($fp);
        return view('mcy.msg',compact('type','msg'));
      }
    }
    public function topUpPay1(Request $request)
    {
      return "请输入确定具体充值金额";
    }
    public function topUpPay(Request $request)
    {
      $response = new ApiResponse;
      $pid = $request->pid;
      $money = $request->money;

      $payinfo  = McyPay::where('payinfo_id',$pid)->where('is_delete',0)->where('status',0)->first();

      if($payinfo)
      {
        if ($money < 10) {
          $msg = "充值金额不能少于10元";
          $type = 2;
          return view('mcy.msg',compact('msg','type'));
            
        }else{
         /* @$payinfo->openid = $request->input('openid');*/
          $method = $payinfo->method;



          return $this->$method($money,$payinfo);
        }
      }else{
        return "充值信息不全";
      }
    }
  /* ***************************************************** 钱方支付函数 ***********************************************************/
    public function qianfang($money,$payinfo)
    {
      $response = new ApiResponse;
      if (@isset($payinfo->openid)){
        @$openid = $payinfo->openid;
      }else{
        $openid = \Session::get('openid');
      }
      $mcy_user = McyUser::where('openid',$openid)->where('is_delete',0)->first();
      $this->url = $url = 'http://pay.x314.cn';
      $secret_key = $this->secret_key = $payinfo->pay_secret;
      $mch_id = $this->mch_id = $payinfo->pay_account;
      $config = array(); 
      $topup = json_decode($this->topuporder($mcy_user,$money,$payinfo));
      if ($topup->ret == 0)
      {
       $config['code']  = $topup->order_no;
       $config['money']  = $money;
       $config['title']  = '充值';
       $config['ReturnUrl'] = "http://" . $_SERVER['HTTP_HOST'] . '/payinfo/return_url/qianfang';
       $config['NotifyUrl'] = "http://" . $_SERVER['HTTP_HOST'] . '/payinfo/notify_url/qianfang';

        $data["out_trade_no"] = $config['code'];
        $data["sub_openid"] = $openid;
        $data["body"] = '潮惠乐购--'.$config['title'];
        $data["total_fee"] = (double)$config['money'];   //单位：分
        $data["mch_create_ip"] = getenv('HTTP_CLIENT_IP')?getenv('HTTP_CLIENT_IP'):'127.0.0.1';   //单位：分
        $data['notify_url'] = $config['NotifyUrl'];
        $data["callback_url"] = $config['ReturnUrl'].'?money='.$config['money'].'&out_trade_no='.$data["out_trade_no"].'&payway=1';
        $data['openid'] = $openid;
        $pay = new QianFang();
        $data['name']= $config['title'];
        $res=$pay->pay($data);
        $r = json_decode($res['payMessage']);
        $params = array();
        $params["appId"] = @$r->appId; 
        $params["timeStamp"] = @$r->timeStamp; 
        $params["signType"] = @$r->signType; 
        $params["package"] = @$r->packageStr; 
        $params["nonceStr"] = @$r->nonceStr; 
        $params["paySign"] = @$r->paySign;   
        $params = json_encode($params);      
        return redirect('/m/product/pay/1')->with('params',$params);
        // return view('mcy.pay',compact('params'));
        // echo '<img src=" https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='.$res['payMessage'].'">';
      }else{
        return $response->reply(3,$topup->msg);
      }
    }
    public function qianfang2($money,$payinfo)
    {
      $response = new ApiResponse;
      if (@isset($payinfo->openid)){
        @$openid = $payinfo->openid;
      }else{
        $openid = \Session::get('openid');
      }
      $pay_openid = \Session::get('openid');
      $mcy_user = McyUser::where('openid',$openid)->where('is_delete',0)->first();
      $this->url = $url = 'http://pay.x314.cn';
      $secret_key = $this->secret_key = $payinfo->pay_secret;
      $mch_id = $this->mch_id = $payinfo->pay_account;
      $config = array(); 
      $topup = json_decode($this->topuporder($mcy_user,$money,$payinfo));
      if ($topup->ret == 0)
      {
       $config['code']  = $topup->order_no;
       $config['money']  = $money;
       $config['title']  = '充值';
       $config['ReturnUrl'] = "http://" . $_SERVER['HTTP_HOST'] . '/payinfo/return_url/qianfang';
       $config['NotifyUrl'] = "http://" . $_SERVER['HTTP_HOST'] . '/payinfo/notify_url/qianfang';

        $data["out_trade_no"] = $config['code'];
        $data["sub_openid"] = $pay_openid;
        $data["body"] = '潮惠乐购--'.$config['title'];
        $data["total_fee"] = (double)$config['money'];   //单位：分
        $data["mch_create_ip"] = getenv('HTTP_CLIENT_IP')?getenv('HTTP_CLIENT_IP'):'127.0.0.1';   //单位：分
        $data['notify_url'] = $config['NotifyUrl'];
        $data["callback_url"] = $config['ReturnUrl'].'?money='.$config['money'].'&out_trade_no='.$data["out_trade_no"].'&payway=1';
        $data['openid'] = $pay_openid;
        $pay = new QianFang();
        $data['name']= $config['title'];
        $res=$pay->pay($data);
        $r = json_decode($res['payMessage']);
        $params = array();
        $params["appId"] = @$r->appId; 
        $params["timeStamp"] = @$r->timeStamp; 
        $params["signType"] = @$r->signType; 
        $params["package"] = @$r->packageStr; 
        $params["nonceStr"] = @$r->nonceStr; 
        $params["paySign"] = @$r->paySign;   
        $params = json_encode($params);      
        return redirect('/m/product/pay/1')->with('params',$params);
        // return view('mcy.pay',compact('params'));
        // echo '<img src=" https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='.$res['payMessage'].'">';
      }else{
        return $response->reply(3,$topup->msg);
      }
    }
    public function  aihuangoutoqianfang($money,$payinfo)
    {
      $response = new ApiResponse;

      $mcy_user = McyUser::getUserInfo();
        $site =  McySite::getInfo();
      // $this->url = $url = 'http://pay.x314.cn';
      // $this->url = $url = 'https://gateway.iexbuy.com/quickGateWayPay/initPay';
      $this->url = $url = 'https://gateway.iexbuy.cn/quickGateWayPay/initPay';
      $secret_key = $this->secret_key = $payinfo->pay_secret;

      $mch_id = $this->mch_id = $payinfo->pay_account;
      $config = array(); 
      $topup = json_decode($this->topuporder($mcy_user,$money,$payinfo));
      if ($topup->ret == 0)
      {
       $config['code']  = $topup->order_no;
       $config['money']  = $money;
       $config['title']  = $topup->order_no;
       $config['ReturnUrl'] = "http://" . $_SERVER['HTTP_HOST'] . '/mcy/user';
       $config['NotifyUrl'] = "http://" . $_SERVER['HTTP_HOST'] . '/payinfo/notify_url/aihuangoutoqianfang';
        // $pay = new Aihuangou1();
        $param = array();
        $param['payKey'] = $payinfo->pay_account;
        $param['paySecret'] = $payinfo->pay_secret;
        $param['orderPrice']    = $config['money'];//订单金额，单位：元保留小数点后两位
        $param['outTradeNo']    = $config['code'];//商户支付订单号
        $param['productType']   = "40000503";//产品类型
        $param['orderTime']     = date('Ymdhis',time());//下单时间，格式yyyyMMddHHmmss
        $param['productName']   = $config['title'];//商品名称
        $param['orderIp']       = @$_SERVER['SERVER_ADDR'];//下单IP
        $param['ReturnUrl'] = $config['ReturnUrl'];
        $param['NotifyUrl'] = $config['NotifyUrl'];
        $param["ip"] = getenv('HTTP_CLIENT_IP')?getenv('HTTP_CLIENT_IP'):'127.0.0.1';   
        $param['remark']        = "";//备注
        $param['subPayKey']        = "";//备注
        $zd="notifyUrl=".$param['NotifyUrl']."&orderIp=".$param['ip']."&orderPrice=".$param['orderPrice']."&orderTime=".$param['orderTime']."&outTradeNo=".$param['outTradeNo']."&payKey=".$param['payKey']."&productName=".$param['productName']."&productType=".$param['productType']."&returnUrl=".$param['ReturnUrl']."&paySecret=".$param['paySecret'];

        $sign=strtoupper(md5($zd));
        WechatLog::info("{{$site->site_name}}签名开始");
        WechatLog::info($zd);
        WechatLog::info($sign);
        WechatLog::info("{{$site->site_name}}签名结束");
        $postData['payKey'] = $param['payKey'];
        $postData['orderPrice'] = $param['orderPrice'];
        $postData['outTradeNo'] = $param['outTradeNo'];
        $postData['productType'] = $param['productType'];
        $postData['orderTime'] = $param['orderTime'];
        $postData['productName'] = $param['productName'];
        $postData['orderIp'] = $param['ip'];
        $postData['returnUrl'] = $param['ReturnUrl'];
        $postData['notifyUrl'] = $param['NotifyUrl'];
        $postData['subPayKey'] = $param['subPayKey'];
        // $postData['remark'] = $param['remark'];
        $postData['sign'] = $sign;

        //$data = $this->postCurl($url,$postData);
        /*$btn = $pay->pay($pram);
        return redirect($btn);*/
          //$this->testChongZhi($postData);
          return view('mcy.pay_aihuangou',compact('postData','url'));
      }else{
        return $response->reply(3,$topup->msg);
      }
    }


    public function  aihuangoutoqqpay($money,$payinfo)
    {
        $response = new ApiResponse;
        $site =  McySite::getInfo();
        $mcy_user = McyUser::getUserInfo();
        // $this->url = $url = 'http://pay.x314.cn';
        // $this->url = $url = 'https://gateway.iexbuy.com/quickGateWayPay/initPay';
        $this->url = $url = 'https://gateway.iexbuy.com/cnpPay/initPay';
        $secret_key = $this->secret_key = $payinfo->pay_secret;

        $mch_id = $this->mch_id = $payinfo->pay_account;
        $config = array();
        $topup = json_decode($this->topuporder($mcy_user,$money,$payinfo));
        if ($topup->ret == 0)
        {
            $config['code']  = $topup->order_no;
            $config['money']  = $money;
            $config['title']  = $topup->order_no;
            $config['ReturnUrl'] = "http://" . $_SERVER['HTTP_HOST'] . '/mcy/user';
            $config['NotifyUrl'] = "http://" . $_SERVER['HTTP_HOST'] . '/payinfo/notify_url/aihuangoutoqianfang';
            // $pay = new Aihuangou1();
            $param = array();
            $param['payKey'] = $payinfo->pay_account;
            $param['paySecret'] = $payinfo->pay_secret;
            $param['orderPrice']    = $config['money'];//订单金额，单位：元保留小数点后两位
            $param['outTradeNo']    = $config['code'];//商户支付订单号
            $param['productType']   = $payinfo->product_type;//产品类型
            $param['orderTime']     = date('Ymdhis',time());//下单时间，格式yyyyMMddHHmmss
            $param['productName']   = $config['title'];//商品名称
            $param['orderIp']       = @$_SERVER['SERVER_ADDR'];//下单IP
            $param['ReturnUrl'] = $config['ReturnUrl'];
            $param['NotifyUrl'] = $config['NotifyUrl'];
            $param["ip"] = getenv('HTTP_CLIENT_IP')?getenv('HTTP_CLIENT_IP'):'127.0.0.1';
            $param['remark']        = "";//备注
            $param['subPayKey']        = "";//备注
            $zd="notifyUrl=".$param['NotifyUrl']."&orderIp=".$param['ip']."&orderPrice=".$param['orderPrice']."&orderTime=".$param['orderTime']."&outTradeNo=".$param['outTradeNo']."&payKey=".$param['payKey']."&productName=".$param['productName']."&productType=".$param['productType']."&returnUrl=".$param['ReturnUrl']."&paySecret=".$param['paySecret'];

            $sign=strtoupper(md5($zd));
            WechatLog::info("{{$site->site_name}}签名开始");
            WechatLog::info($zd);
            WechatLog::info($sign);
            WechatLog::info("{{$site->site_name}}签名结束");

            $postData['payKey'] = $param['payKey'];
            $postData['orderPrice'] = $param['orderPrice'];
            $postData['outTradeNo'] = $param['outTradeNo'];
            $postData['productType'] = $param['productType'];
            $postData['orderTime'] = $param['orderTime'];
            $postData['productName'] = $param['productName'];
            $postData['orderIp'] = $param['ip'];
            $postData['returnUrl'] = $param['ReturnUrl'];
            $postData['notifyUrl'] = $param['NotifyUrl'];
            //$postData['subPayKey'] = $param['subPayKey'];
            //$postData['remark'] = $param['remark'];
            $postData['sign'] = $sign;

            $result = $this->curl_post($url,$postData);
           // $result = '{"resultCode":"0000","sign":"DC9812228FD2AF618EE607961F4C3B65","payMessage":"wxp://f2f1yYc7B_oFi1Jz9vkOoviwWc9kgvpFb6QG","returnMsg":"付款即时到账 未到账可联系我们","errMsg":""}';
            $result = json_decode($result);
            if($result->resultCode=='0000'){
                //调用成功生成二维码
                $payORcode = $result->payMessage;
                return view('mcy.pay_aihuangou',compact('payORcode'));
            }
            /*$btn = $pay->pay($pram);
            return redirect($btn);*/
           //return view('mcy.pay_aihuangou',compact('postData','url'));
        }else{
            return $response->reply(3,$topup->msg);
        }
    }
    public function qianfang1($money,$payinfo)
    {
      $response = new ApiResponse;
      $openid = \Session::get('openid');
      $mcy_user = McyUser::where('openid',$openid)->where('is_delete',0)->first();
      $this->url = $url = 'http://pay.x314.cn';
      $secret_key = $this->secret_key = $payinfo->pay_secret;
      $mch_id = $this->mch_id = $payinfo->pay_account;
      $config = array(); 
      $topup = json_decode($this->topuporder($mcy_user,$money,$payinfo));
      if ($topup->ret == 0)
      {
       $config['code']  = $topup->order_no;
       $config['money']  = $money;
       $config['title']  = '充值';
       $config['ReturnUrl'] = "http://" . $_SERVER['HTTP_HOST'] . '/payinfo/return_url/qianfang1';
       $config['NotifyUrl'] = "http://" . $_SERVER['HTTP_HOST'] . '/payinfo/notify_url/qianfang1';
        $pay = new QianFang1();
        $pram = array();
        $pram['orderPrice']    = $config['money'];//订单金额，单位：元保留小数点后两位
        $pram['outTradeNo']    = $config['code'];//商户支付订单号
        $pram['productType']   = "40000503";//产品类型
        $pram['orderTime']     = date('Ymdhis',time());//下单时间，格式yyyyMMddHHmmss
        $pram['productName']   = $config['title'];//商品名称
        $pram['orderIp']       = @$_SERVER['SERVER_ADDR'];//下单IP
        $pram['ReturnUrl'] = $config['ReturnUrl'];
        $pram['NotifyUrl'] = $config['NotifyUrl'];
        $pram['remark']        = "";//备注
        $btn = $pay->pay($pram);
        return redirect($btn);
        // $res=$pay->pay($data);
        // $r = json_decode($res['payMessage']);
        // $params = array();
        // $params["appId"] = @$r->appId; 
        // $params["timeStamp"] = @$r->timeStamp; 
        // $params["signType"] = @$r->signType; 
        // $params["package"] = @$r->packageStr; 
        // $params["nonceStr"] = @$r->nonceStr; 
        // $params["paySign"] = @$r->paySign;   
        // $params = json_encode($params);      
        // return redirect('/m/product/pay/1')->with('params',$params);
        // return view('mcy.pay',compact('params'));
        // echo '<img src=" https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='.$res['payMessage'].'">';
      }else{
        return $response->reply(3,$topup->msg);
      }
    }

  /* ***************************************************** 钱方支付函数 ***********************************************************/
  /* ***************************************************** {{$site->site_name}}支付函数 ***********************************************************/
  public function aihuangou($money,$payinfo)
  {
     $response = new ApiResponse;
     $openid = \Session::get('openid');
     $mcy_user = McyUser::where('openid',$openid)->where('is_delete',0)->first();
     $this->url = $url="http://spdbweb.chinacardpos.com/payment-gate-web/gateway/api/backTransReq";
     // $this->url = $url="http://121.201.32.197:9080/payment-gate-web/gateway/api/backTransReq";
     $secret_key = $this->secret_key = $payinfo->pay_secret;
     $mch_id = $this->mch_id = $payinfo->pay_account;
     $config = array(); 
     $topup = json_decode($this->topuporder($mcy_user,$money,$payinfo));
     if ($topup->ret == 0)
     {
       $config['code']  = $topup->order_no;
       $config['money']  = $money;
       $config['title']  = $topup->order_no;
       $config['ReturnUrl'] = "http://" . $_SERVER['HTTP_HOST'] . '/payinfo/return_url/aihuangou';
       $config['NotifyUrl'] = "http://" . $_SERVER['HTTP_HOST'] . '/payinfo/notify_url/aihuangou';
       $arrHashCode = array(
            'requestNo'=>time().srand().srand(), //请求流水号
            'version'=>'V1.1', //版本号
            'productId'=>'0112',
            'subOpenId'=>$openid,
            'transId'=>'16',
            'clientIp'=>'39.108.51.243',
            'merNo'=>'310440300029448',
            'subMchId'=>'43163609',
            'orderDate'=>date('Ymd'),
            'orderNo'=>$config['code'],
            'returnUrl'=> $config['ReturnUrl'],
            'notifyUrl'=> $config['NotifyUrl'],
            'transAmt'=> $config['money'] * 100,
            'commodityName'=>$config['title']
            );
       $dateEncrypt = new encrypt();
       $util = new Util();
        //验签处理字段
       $arrHashCode['signature']= urlencode($dateEncrypt->sign($util->SinParamsToString($arrHashCode)));
       $post_data=$util->arrayToString($arrHashCode);
       // var_dump($post_data);
        //数据返回
       $rdata = $util->postData($url,$post_data);
       parse_str($rdata,$d);
       if ($d['respCode'] == '0000'){
          $r = json_decode($d['formfield']);
          $params["appId"] = @$r->appId; 
          WechatLog::info(@$r->appId);
          $params["timeStamp"] = @$r->timeStamp; 
          $params["signType"] = @$r->signType; 
          $params["package"] = @$r->package; 
          $params["nonceStr"] = @$r->nonceStr; 
          $params["paySign"] = @$r->paySign;   
          $params = json_encode($params);      
          return redirect('/m/product/pay/1')->with('params',$params);
          // $payinfo_url = base64_decode($d['payInfo']);
          // return redirect($payinfo_url);
       }else{
        $msg = $d['respDesc'];
        $type = 2;
        return view('mcy.msg',compact('msg','type'));
       }
      }else{
        return $response->reply(3,$topup->msg);
      }
  }
  /* ***************************************************** {{$site->site_name}}支付函数 ***********************************************************/
  /* ***************************************************** {{$site->site_name}}1支付函数 ***********************************************************/
  public function aihuangou1($money,$payinfo)
  {
     $response = new ApiResponse;
     $openid = \Session::get('openid');
     $mcy_user = McyUser::where('openid',$openid)->where('is_delete',0)->first();
     $this->url = $url="http://spdbweb.chinacardpos.com/payment-gate-web/gateway/api/backTransReq";
     // $this->url = $url="http://121.201.32.197:9080/payment-gate-web/gateway/api/backTransReq";
     $secret_key = $this->secret_key = $payinfo->pay_secret;
     $mch_id = $this->mch_id = $payinfo->pay_account;
     $config = array(); 
     $topup = json_decode($this->topuporder($mcy_user,$money,$payinfo));
     if ($topup->ret == 0)
     {
       $config['code']  = $topup->order_no;
       $config['money']  = $money;
       $config['title']  = $topup->order_no;
       $config['ReturnUrl'] = "http://" . $_SERVER['HTTP_HOST'] . '/payinfo/return_url/aihuangou1';
       $config['NotifyUrl'] = "http://" . $_SERVER['HTTP_HOST'] . '/payinfo/notify_url/aihuangou1';
       $arrHashCode = array(
            'requestNo'=>time().srand().srand(), //请求流水号
            'version'=>'V1.1', //版本号
            'productId'=>'0112',
            'subOpenId'=>$openid,
            'transId'=>'16',
            'clientIp'=>getenv('HTTP_CLIENT_IP')?getenv('HTTP_CLIENT_IP'):'127.0.0.1',
            'merNo'=>'310440300110957',
            'subMchId'=>'47562981',
            'orderDate'=>date('Ymd'),
            'orderNo'=>$config['code'],
            'returnUrl'=> $config['ReturnUrl'],
            'notifyUrl'=> $config['NotifyUrl'],
            'transAmt'=> $config['money'],
            'commodityName'=>$config['title']
            );
       $dateEncrypt = new encrypt();
       $util = new Util();
        //验签处理字段
       $arrHashCode['signature']= urlencode($dateEncrypt->sign($util->SinParamsToString($arrHashCode)));
       $post_data=$util->arrayToString($arrHashCode);
       // var_dump($post_data);
        //数据返回
       $rdata = $util->postData($url,$post_data);
       parse_str($rdata,$d);
       if ($d['respCode'] == '0000'){
          $r = json_decode($d['formfield']);
          $params["appId"] = @$r->appId; 
          WechatLog::info(@$r->appId);
          $params["timeStamp"] = @$r->timeStamp; 
          $params["signType"] = @$r->signType; 
          $params["package"] = @$r->package; 
          $params["nonceStr"] = @$r->nonceStr; 
          $params["paySign"] = @$r->paySign;   
          $params = json_encode($params);      
          return redirect('/m/product/pay/1')->with('params',$params);
          // $payinfo_url = base64_decode($d['payInfo']);
          // return redirect($payinfo_url);
       }else{
        $msg = $d['respDesc'];
        $type = 2;
        return view('mcy.msg',compact('msg','type'));
       }
      }else{
        return $response->reply(3,$topup->msg);
      }
  }
  /* ***************************************************** {{$site->site_name}}支付函数 ***********************************************************/

  /* ***************************************************** {{$site->site_name}}66支付函数 ***********************************************************/
  public function aihuangou66($money,$payinfo)
  {
     $response = new ApiResponse;
     $openid = \Session::get('openid');
     $mcy_user = McyUser::where('openid',$openid)->where('is_delete',0)->first();
     $this->url = $url="http://spdbweb.chinacardpos.com/payment-gate-web/gateway/api/backTransReq";
     // $this->url = $url="http://121.201.32.197:9080/payment-gate-web/gateway/api/backTransReq";
     $secret_key = $this->secret_key = $payinfo->pay_secret;
     $mch_id = $this->mch_id = $payinfo->pay_account;
     $config = array(); 
     $topup = json_decode($this->topuporder($mcy_user,$money,$payinfo));
     if ($topup->ret == 0)
     {
       $config['code']  = $topup->order_no;
       $config['money']  = $money;
       $config['title']  = $topup->order_no;
       $config['ReturnUrl'] = "http://" . $_SERVER['HTTP_HOST'] . '/payinfo/return_url/aihuangou66';
       $config['NotifyUrl'] = "http://" . $_SERVER['HTTP_HOST'] . '/payinfo/notify_url/aihuangou66';
       $arrHashCode = array(
            'requestNo'=>time().srand().srand(), //请求流水号
            'version'=>'V1.1', //版本号
            'productId'=>'0112',
            'subOpenId'=>$openid,
            'transId'=>'16',
            'clientIp'=>getenv('HTTP_CLIENT_IP')?getenv('HTTP_CLIENT_IP'):'127.0.0.1',
            'merNo'=>'310440300111006',
            'subMchId'=>'47562981',
            'orderDate'=>date('Ymd'),
            'orderNo'=>$config['code'],
            'returnUrl'=> $config['ReturnUrl'],
            'notifyUrl'=> $config['NotifyUrl'],
            'transAmt'=> $config['money'],
            'commodityName'=>$config['title']
            );
       $dateEncrypt = new encrypt();
       $util = new Util();
        //验签处理字段
       $arrHashCode['signature']= urlencode($dateEncrypt->sign($util->SinParamsToString($arrHashCode)));
       $post_data=$util->arrayToString($arrHashCode);
       // var_dump($post_data);
        //数据返回
       $rdata = $util->postData($url,$post_data);
       parse_str($rdata,$d);
       if ($d['respCode'] == '0000'){
          $r = json_decode($d['formfield']);
          $params["appId"] = @$r->appId; 
          WechatLog::info(@$r->appId);
          $params["timeStamp"] = @$r->timeStamp; 
          $params["signType"] = @$r->signType; 
          $params["package"] = @$r->package; 
          $params["nonceStr"] = @$r->nonceStr; 
          $params["paySign"] = @$r->paySign;   
          $params = json_encode($params);      
          return redirect('/m/product/pay/1')->with('params',$params);
          // $payinfo_url = base64_decode($d['payInfo']);
          // return redirect($payinfo_url);
       }else{
        $msg = $d['respDesc'];
        $type = 2;
        return view('mcy.msg',compact('msg','type'));
       }
      }else{
        return $response->reply(3,$topup->msg);
      }
  }
  /* ***************************************************** {{$site->site_name}}支付函数 ***********************************************************/



    /* ***************************************************** 全付通支付函数 ***********************************************************/
    public function swiftpass($money,$payinfo)
    {
     $response = new ApiResponse;
     $openid = \Session::get('openid');
     $mcy_user = McyUser::where('openid',$openid)->where('is_delete',0)->first();
     $this->url = $url = 'https://pay.swiftpass.cn/pay/jspay?';
     $secret_key = $this->secret_key = $payinfo->pay_secret;
     $mch_id = $this->mch_id = $payinfo->pay_account;
     $config = array(); 
     $topup = json_decode($this->topuporder($mcy_user,$money,$payinfo));
     if ($topup->ret == 0)
     {
       $config['code']  = $topup->order_no;
       $config['money']  = $money;
       $config['title']  = '充值';
       $config['ReturnUrl'] = "http://" . $_SERVER['HTTP_HOST'] . '/payinfo/return_url/swiftpass';
       $config['NotifyUrl'] = "http://" . $_SERVER['HTTP_HOST'] . '/payinfo/notify_url/swiftpass';

        $data["out_trade_no"] = $config['code'];
        //$data["sub_openid"] = 'o7RM2wOlsHXF14CJv2Bmq3TuA7bM';
        $data["sub_openid"] = $openid;
        $data["body"] = '潮惠乐购--'.$config['title'];
        // $data["total_fee"] = (double)$config['money'] / 5;   //单位：分
        $data["total_fee"] = (double)$config['money'] * 100;   //单位：分
        $data["mch_create_ip"] = getenv('HTTP_CLIENT_IP')?getenv('HTTP_CLIENT_IP'):'127.0.0.1';   //单位：分
        $data['notify_url'] = $config['NotifyUrl'];
        $data["callback_url"] = $config['ReturnUrl'].'?money='.$config['money'].'&out_trade_no='.$data["out_trade_no"].'&payway=1';
        $method = 'submitOrderInfo';
        $pay = new Swiftpass;
        $result = $pay->index($method,$data,$payinfo);
        $rdata = $this->toObject($result);

        if (isset($rdata->status))
        {
          return $response->reply(4,@$rdata->status." ".@$rdata->msg);
        }else{
          $token_id = $rdata->token_id;
          $url = $this->url.'token_id='.$token_id.'&showwxtitle=1';
          header("Location: $url");  
          return redirect($url);
        }
      }else{
        return $response->reply(3,$topup->msg);
      }
    }

    /* ***************************************************** 全付通支付函数 ***********************************************************/
    /* ***************************************************** 派付通支付函数 ***********************************************************/
    public function payfutong($money,$payinfo)
    {
      $openid = \Session::get('openid');
      $mcy_user = McyUser::where('openid',$openid)->where('is_delete',0)->first();
      $site = McySite::getInfo();
      $this->url = $url = 'http://pay.x314.cn';
      $secret_key = $this->secret_key = $payinfo->pay_secret;
      $mch_id = $this->mch_id = $payinfo->pay_account;
      $config = array(); 
      $topup = json_decode($this->topuporder($mcy_user,$money,$payinfo));
      if ($topup->ret == 0)
      {
       $config['code']  = $topup->order_no;
       $config['money']  = $money;
       $config['title']  = '充值';
       $config['ReturnUrl'] = "http://" . $_SERVER['HTTP_HOST'] . '/payinfo/return_url';
       $config['NotifyUrl'] = "http://" . $_SERVER['HTTP_HOST'] . '/payinfo/notify_url';
        $orderReq["out_order_sn"] = $config['code'];
        $orderReq["title"] = $site->site_name.'--'.$config['title'];
        $orderReq["amount_fee"] = (double)$config['money'];   //单位：元
        // $orderReq["currency"] = "RMB";
        $orderReq["sign_type"] = "MD5";
        $orderReq["attach"] = "info";
        $orderReq["mch_id"] = $mch_id;
        $orderReq["time_expire"] = strtotime("+5 hours");
        $orderReq["nonce_str"] = $this->getNonceStr();
        $orderReq["return_url"] = $config['ReturnUrl'].'?out_trade_no='.$orderReq["out_order_sn"].'&payway=1';
        $orderReq['notify_url'] = $config['NotifyUrl'].'/payfutong';

        $rdata = $this->unifiOrder($orderReq,$this->secret_key);
        $rdata = $this->toObject($rdata);
        $token_id = $rdata->token_id;
        
        $url = $this->url.'/pay?token_id='.$token_id;
        header("Location: $url");  
      }else{
        return $response->reply(3,$topup->msg);
      }
     
    }
    public function topuporder($mcy_user,$money,$payinfo)
    {
      /* 生成订单 */
      $response = new ApiResponse;
      $topup = new McyTopUp;
      $topup->payway = '充值';
      $topup->username = $mcy_user->username;
      $topup->mcy_user_id = $mcy_user->mcy_user_id;
      $topup->payinfo_id = $payinfo->payinfo_id;
      $topup->price = $money;
      $topup->order_no = date("YmdHis",time()).mt_rand(0,9).mt_rand(0,9);
      $topup->status = 0;
      if ($topup->save())
      {
        $response->order_no = $topup->order_no;
        return $response->reply(0,'ok');
      }else{
        return $response->reply(1,'失败');
      }
    }
    public function request_by_curl($remoteServer, $postData) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remoteServer);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }


    public function  curl_post($url,$data){


        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER,array("content-type: application/x-www-form-urlencoded;\n charset=UTF-8"));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    public function request_get($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    /**
     * 
     * 产生随机字符串，不长于32位
     * @param int $length
     * @return 产生的随机字符串
     */
    public static function getNonceStr($length = 32) 
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {  
            $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
        } 
        return $str;
    }
    public function getSig(array &$params, array $sig_keys)
    {
        $msg_array = array();
        foreach ($sig_keys as $key) {
            $msg_array[$key] = isset($params[$key]) ? $params[$key] : '';
        }
        $msg_array['sign'] = $this->secret_key;

        $msg = implode('|', $msg_array);
        $sig = md5($msg);
        return $sig;
    }

    public function ToUrlParams($urlObj)
    {
        $buff = "";
        foreach ($urlObj as $k => $v)
        {
            $buff .= $k . "=" . $v . "&";
        }
        
        $buff = trim($buff, "&");
        return $buff;
    }

    public function getSign($postData,$secret_key)
    {
        $stringSignTemp = '';
        ksort($postData);
        $stringSignTemp = $this->ToUrlParams($postData);
        $s =  $stringSignTemp.'&key='.$secret_key;
        $sign = strtoupper(MD5($s));
        $postData['sign'] = $sign;
        return $postData;
    }
    public function toJson($data)
    {
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function toObject($data,$assoc="")
    {
        return json_decode($data,$assoc);
        return json_decode($data);
    }

    public function unifiOrder($options,$secret_key)
    {
        $postData = $this->getSign($options,$secret_key);
        $rdata = $this->request_by_curl($this->url.'/unifiOrder',$postData);
        return $rdata;
    }
    public function pay($token_id)
    {

        $rdata = $this->request_get($this->url.'/pay?token_id='.$token_id);
        return $rdata;
    }
  /* ***************************************************** 派付通支付函数 ***********************************************************/
  /* 模板消息 */
      public function  send_template_msg($touser, $name, $price, $url){
            $postData['touser'] = $touser;
            $postData['template_id'] = 'dkUWL_Q8LaL3UVMaX2b000ddd3P4jqQxlZy0rc5QKiI';
            $postData['url'] = $url;
            $postData['data'] = array(
                "first" => array(
                    "value" => "恭喜你购买成功！",
                    "color" => "#173177"
                ),   
                "product" => array(
                    "value" => $name,
                    "color" => "#173177"
                ),   
                "price" => array(
                    "value" => $price. '元',
                    "color" => "#173177"
                ),   
                "time" => array(
                    "value" => date("Y年m月d日 H时i分"),
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
            #$result = json_decode($this->postCurl($url, $json), true);     
            $result = $this->postCurl($url, $json);     
      } 
      public function send_price_msg($touser, $name, $result){
            ignore_user_abort(true); 
            set_time_limit(0);
            $postData['touser'] = $touser;
            $postData['template_id'] = 'AbHyycX9vKiv7iMrKDTvqar8PPzlitQ8rubO6wj7KUc';
            $postData['url'] = WEB_PATH. "/mobile/home/orderlist";
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


    /**
     * 此方法是测试充值业务逻辑的,正式环境不能调用
     */
    public function testChongZhi($rdata)
    {


        $out_trade_no = @$rdata['outTradeNo'];

        $site = McySite::getInfo();


        $topup = McyTopUp::where('is_delete',0)->where('order_no',$out_trade_no)->first();


        if ($topup && $topup->status == 0) {
            $payinfo_id = $topup->payinfo_id;
            $payinfo = McyPay::where('payinfo_id', $payinfo_id)->first();

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


                echo '测试充值成功';

            }catch (\Exception $e) {
                DB::rollBack(); //回滚

                return redirect('/mcy/user');
            }

        }


    }

}

class encrypt{
/**
   * 使用空格替换换行符
   * @param string string_before
   * @return string string_after
   */
   function string_replace($string_before){
    $string_after = str_replace('%','PP',$string_before);
        $string_after = str_replace('&','AND',$string_after);
        $string_after = str_replace(',','',$string_after);
    return $string_after;
   }


  /**
   验签
   data：utf-8编码的订单原文
   */
function sign($data) {
    //读取私钥文件
  //注意所放文件路径
    // $priKey = file_get_contents('23qesg09y23btsghb3w05t3g3/310440300035489_prv.pem');
    $priKey = file_get_contents('23qesg09y23btsghb3w05t3g3/310440300111006_prv.pem');
 
    //转换为openssl密钥，必须是没有经过pkcs8转换的私钥
    $res = openssl_get_privatekey($priKey);
 
    //调用openssl内置签名方法，生成签名$sign
    openssl_sign($data, $sign, $res);
 
    //释放资源
    openssl_free_key($res);
 
    return base64_encode($sign);
}



  /**
     十六进制验签
  */
   function binsign($data){
    //证书路径
     // $privatekeyFile="23qesg09y23btsghb3w05t3g3/310440300035489.pfx";
     $privatekeyFile="23qesg09y23btsghb3w05t3g3/310440300111006.pfx";
     //证书私钥
     $passphrase="637727404843";
     $signature = '';  
     $privateKey;
     $signedMsg;
     $pkcs12 = file_get_contents($privatekeyFile);
   
    if (openssl_pkcs12_read($pkcs12, $certs, "637727404843")) {
       $privateKey = $certs['pkey'];
    }
    if (openssl_sign($data, $signedMsg, $privateKey,OPENSSL_ALGO_SHA1)) {
       $signedMsg= strtoupper(bin2hex($signedMsg));//这个看情况。有些不需要转换成16进制，有些需要base64编码。看各个接口
       return $signedMsg;
    } 
     
   }

   function pubkeyEncrypt($data,$panText,$pubkey){
      openssl_public_encrypt($data,$panText,$pubkey,OPENSSL_PKCS1_PADDING);
      return  strtoupper(bin2hex($panText));
   
   }
   
  function getBytes($string) {  
      $bytes = array();  
      for($i = 0; $i < strlen($string); $i++){  
        $bytes[] = ord($string[$i]);  
      }  
      return $bytes;  
   }  
   }
class Util{

 function hello(){
  echo "hhe";
 }


/**
 验签所需字符串特殊处理函数
*/
function SinParamsToString($params) {
  $sign_str = '';
  // 排序
  ksort($params);
  foreach ($params as $key =>$val){
    if ($key == 'signature'){
      continue;
    }
    $sign_str .= sprintf ( "%s=%s&", $key, $val );
  }
  return substr ( $sign_str, 0, strlen ( $sign_str ) - 1 );
}





/**
最终抛送数据所需字符串特殊处理函数
*/
function arrayToString($params){
  $sign_str = '';
  // 排序
  ksort ( $params );
  foreach ( $params as $key => $val ) {
    
    $sign_str .= sprintf ( "%s=%s&", $key, $val );
  }
  return substr ( $sign_str, 0, strlen ( $sign_str ) - 1 );
    
 }



/**

 抛送数据方法
*/

function postData($url, $data){
        $ch = curl_init();     
        $timeout = 300;
        curl_setopt($ch,CURLOPT_HTTPHEADER,array("content-type: application/x-www-form-urlencoded; charset=UTF-8"));
        curl_setopt($ch, CURLOPT_URL, $url);    
        // curl_setopt($ch, CURLOPT_REFERER, "http://yyg2.chkg99.com");   //站点  
        curl_setopt($ch, CURLOPT_POST, true);     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);     
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);     
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);     
        $handles = curl_exec($ch);     
        curl_close($ch);     
        return $handles;     
    } 

}



