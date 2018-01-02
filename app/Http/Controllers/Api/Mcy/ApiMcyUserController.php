<?php

namespace App\Http\Controllers\Api\Mcy;
use App\Model\FubiDuihuan;
use App\Model\McyProduct;
use App\Model\McySupermasterApply;
use App\Model\McyYunGouOrder;
use App\Model\Yongjing;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Tools;
use App\Response;
use App\ApiResponse;
use App\Model\McyUser;
use App\Model\McySite;
use App\Model\McyOrder;
use App\Model\AiHuanGouUser;
use App\Model\McyAddress;
use App\Model\McyYunGou;
use App\Model\McyShare;
use App\Model\McyUserUpdate;
use App\Model\McyWithDraw;
use App\Model\McySendSms;
use Validator;


class ApiMcyUserController extends Controller
{

    /**
     * 提交登录接口
     * @param Request $request
     */
    public function apiPostLogin(Request $request){

        $response = new ApiResponse;

        //接收参数
        $username = $request->username;
        $password = $request->password;

        if($username=='' || $password==''){
            return $response->reply(3,'手机号或密码不能为空');
        }

        $mcyUser = McyUser::where("mobile",$username)->where('is_delete',0)->first();
        if($mcyUser==null){
            return $response->reply(3,'该用户不存在');

        }else{
            if($mcyUser->password!=Tools::encrypt(base64_decode($password))){

                return $response->reply(3,'密码错误');

            }

        }
        
        //保存session
        $request->session()->put('user_id',$mcyUser->mcy_user_id);

        return $response->reply(0,'登录成功');

    }

    /**
     * 提交注册接口
     * @param Request $request
     */
    public function apiPostRegister(Request $request){

        $response = new ApiResponse;
        //表单验证
        $validator = Validator::make($request->all(), [
            'mobile' => "required|size:11|unique:mcy_user,mobile",
            'pass' => 'required|between:6,255',
            'code'=>'required'
        ]);
        if($validator->fails()){
            return $response->reply(3,$validator->errors()->all());
        }

        //接受参数
        $mobile = $request->input("mobile","");
        $password = $request->input("pass","");
        $code = $request->input("code","");

        //查看输入短信验证码是否正确
        $phoneCode = McySendSms::where('mobile',$mobile)->where('is_delete',0)->first();
       if($phoneCode && $phoneCode->code==$code){
           //判断是否在有效期内输入
          /* if (date("Y-m-d H:i:s") > date("Y-m-d H:i:s",strtotime($phoneCode->created_at." + 10 mins"))) {
               return $response->reply(3,'手机验证码已过期,请重新获取!');
            }*/

            $mcyUser = new McyUser();
            $mcyUser->mobile = $mobile;
            $mcyUser->password = Tools::encrypt($password);
            $mcyUser->username = substr($mobile,0,3).'****'.substr($mobile,-4,4);


            //查看是否有上一级
            $invite_user_id = session('invite_user_id');
            if($invite_user_id){
                //上一级会员是否存在
                $invite_user = McyUser::getUserByUserId($invite_user_id);
                if($invite_user){
                    $mcyUser->is_slave = 1;
                    $mcyUser->master_id = $invite_user_id;
                }
            }

            //查看是否超级代理商推荐的
            $super_master_user = session('super_master_user');
            if($super_master_user){
                //代理商是否存在
                $super_user = McyUser::getUserByUserId($super_master_user);
                if($super_user){
                    $mcyUser->super_master_id = $super_master_user;
                }
            }
             $ret = $mcyUser->save();
             if($ret){
                 //注册成功删除扫码session
                 if($super_master_user){
                     $request->session()->forget('super_master_user');
                 }
                 if($invite_user_id){
                     $request->session()->forget('invite_user_id');
                 }

                 $request->session()->put('user_id',$mcyUser->mcy_user_id);
                 return $response->reply(0,'注册成功');
             }else{
                 return $response->reply(3,'注册失败');
             }


       }else{

           return $response->reply(3,'手机验证码不正确');
        }
    }

    /**
     * 用户管理接口
     * @AiHuanGou
     * @DateTime      2017-04-07T14:58:11+0800
     * @param         $request,$user_id                  
     * @return        data,msg,ret
     */
    public function apiUserCreate(Request $request)
    {
        $response = new ApiResponse;
        parse_str($request->input('data') , $data);
        $username = @$data['username'];
        $password = @$data['password'];
        if ($username == '' || $password == '')
        {
            return $response->reply(2,'用户名，密码不能为空');
        }else{
            if (McyUser::where('username',$username)->where('is_delete',0)->count() > 0)
            {
                return $response->reply(3,'登录名重复，请修改登录名1');
            }else{
              $model = 'App\Model\McyUser';
              $admin_id = $request->session()->get('admin_id');
              $site = McySite::where('is_delete',0)->where('user_id',$admin_id)->first();
              @$site_id = $site->site_id;
              $data['user_id'] = $admin_id;
              $data['site_id'] = $site_id; 
              $data['avator_img'] = @$request->input('avator_img')?$request->input('avator_img'):'';
              $result = $response->create($model,$data);
              return $response->toJson();
               if ($user->save())
               {
                    return $response->reply(0,'添加成功');
                }else{
                    return $response->reply(2,'网络异常');
                }
            }
           
        }
    }
    public function apiUserUpdate(Request $request)
      {
          $response = new ApiResponse;
          parse_str($request->input('data'),$data);
          $data['mcy_user_id'] = $request->input('user_id');
          $user_id = @$data['mcy_user_id'];
          $user = McyUser::find($user_id);
          $username = @$data['username'];
          if ($user)
          {  
              if ($username == '' )
              {
                  return $response->reply(2,'用户名不能为空');
              }else{
                  // if (McyUser::where('username',$username)->where('is_delete',0)->where('mcy_user_id','<>',$user_id)->count() > 0)
                  // {
                  //     return $response->reply(3,'登录名重复，请修改登录名');
                  // }else{
                    $model = 'App\Model\Mcyuser';
                    $data['avator_img'] = @$request->input('avator_img')?$request->input('avator_img'):'';
                    $search = array(
                      'mcy_user_id' => $data['mcy_user_id'],
                      );
                    if ($data['master_id'] > 0){$data['is_slave'] = 1;}else{$data['is_slave'] = 0;};
                    $u = new McyUserUpdate;
                    $mcy_user = McyUser::where('is_delete',0)->where('mcy_user_id',$user_id)->first();
                    $u->mcy_user_id = $mcy_user->mcy_user_id;
                    $u->username = $mcy_user->username;
                    $u->money_origin = $mcy_user->money;
                    $u->score_origin = $mcy_user->score;
                    $u->slave_money_origin = $mcy_user->slave_money;
                    $u->money_update = @$data['money'];
                    $u->score_update = @$data['score'];
                    $u->slave_money_update = @$data['slave_money'];
                    $u->money_change = @$data['money']  - $mcy_user->money;
                    $u->score_change = @$data['score']  - $mcy_user->score;
                    $u->slave_money_change = @$data['slave_money']  - $mcy_user->slave_money;
                    $u->save();
                    $result = $response->update($model,$search,$data);
                    return $response->toJson();
                  // }
              }

          }else{
              return $response->reply(2,'找不到该用户');
          }

      }

      public function apiUserUpdateUserName(Request $request)
      {
          $response = new ApiResponse;
          $mcy_user = McyUser::getUserInfo();

          $username = $request->input("username");
          $avator_img = $request->input('avator_img');
          if ($mcy_user)
          {  
              if ($username == '' )
              {
                  return $response->reply(2,'用户名不能为空');
              }else{
                    $model = 'App\Model\Mcyuser';
                    $data['username'] = $username;
                    $data['avator_img'] = $avator_img;
                    $search = array(
                      'mcy_user_id' => $mcy_user->mcy_user_id,
                      );
                    $result = $response->update($model,$search,$data);
                    return $response->toJson();
                  // }
              }
          }else{
              return $response->reply(2,'找不到该用户');
          }

      }
      public function apiUserDelete(Request $request)
      {
          $response = new Response;
          $admin_id = $request->session()->get('admin_id');
          $user_id = $request->input('user_id');
          $response->user_id = $user_id;
          if (McyUser::find($user_id)){
              $admin = AiHuanGouUser::where("user_id",$admin_id)->first();
              if (McyUser::find($user_id)->user_id == $user_id || $admin_id ==  1 || $admin->privileges == 1)
              {   
                  $user = McyUser::find($user_id);
                  $user->is_delete = 1;
                  if ($user->save()){
                      $response->user_id = $user_id;
                      return $response->reply(0,'删除成功');
                  }else{
                      return $response->reply(2,'网络异常');
                  }
              }else{
                  return $response->reply(4,'您的權限不足');
              }
          }else{
              return $response->reply(1,"没有该用户");
          }
      }

      public function apiUserPassword(Request $request)
      {
          $response = new Response;
          $username = $request->input('username');
          $cpassword = $request->input('cpassword');
          $password = $request->input('password');
          $repassword = $request->input('repassword');
          $user_id = $request->session()->get('admin_id');
          $user = McyUser::find($user_id);
          if ($user || ($username == '')){
              if (Tools::encrypt($cpassword) == $user->password ){
                  if ($password !== $repassword){
                      return $response->reply(2,'两次密码不一致');
                  }else{
                      if (McyUser::where('username',$username)->where('user_id','<>',$user_id)->where('is_delete',0)->first()){
                          return $response->reply(3,'该用户名已经被占用了，请更换用户名'.$user->username.$username);
                      }else{
                          $user->username = $username;
                          $user->password = Tools::encrypt($request->input('password'));
                          if ($user->save()){
                              return $response->reply(0,'修改成功');
                          }else{
                              return $response->reply(2,'数据库写入错误');
                          }
                      }
                  }
              }else{
                  return $response->reply(2,'现密码错误');
              }
              
          }else{
              return $response->reply(1,'找不到该用户');
          }
      }
      public function apiUserFShaiDan(Request $request)
      {
        $response = new ApiResponse;
        $yungou_id = $request->input('yungou_id');
        $title = $request->input('title');
        $shaidan_img = $request->input('shaidan_img');
        $shaidan_content = $request->input('shaidan_content');
        $openid = $request->session()->get('openid');
        $mcy_user = McyUser::where('openid',@$openid)->where('is_delete',0)->first();
        $yungou_id = $request->input('yungou_id');
        $yungou_shop = McyYunGou::where('yungou_id',$yungou_id)->where('is_delete',0)->first();
        if (!$yungou_shop) { return $response->reply(3,'找不到这个云购单号');}
        if ($mcy_user)
        {

          if ($yungou_shop->is_shaidan == 1)
          {
            $model = 'App\Model\McyShaiDan';
            $search = array(
              'shaidan_id'=>@$yungou_shop->shaidan_id,
              'mcy_user_id'=>@$mcy_user->mcy_user_id,
              'is_delete'=>0,
              );
            $d = array();
            $d['shaidan_img'] = $request->input('shaidan_img')?$request->input('shaidan_img'):'';
            $d['shaidan_content'] = $request->input('shaidan_content');
            $d['title'] = @$request->input('title');
            $result = $response->update($model,$search,$d);
            return $response->toJson();
          }

          @$site = McySite::where('is_delete',0)->where('site_id',$mcy_user->site_id)->first();
          $user_id = $site->user_id;
          $model = 'App\Model\McyShaiDan';
          $d = array();
          $d['user_id'] = $user_id;
          $d['product_id']  = $yungou_shop->product_id;
          $d['qishu']  = $yungou_shop->qishu;
          $d['product_name']  = $yungou_shop->product_name;
          $d['shaidan_img'] = $request->input('shaidan_img')?$request->input('shaidan_img'):'';
          $d['shaidan_content'] = $request->input('shaidan_content');
          $d['mcy_user_id'] = @$mcy_user->mcy_user_id;
          $d['title'] = @$request->input('title');
          $d['username'] = @($mcy_user->username)?@$mcy_user->username:@$mcy_user->nickname;
          $result = $response->create($model,$d);
          if ($response->ret == 0)
          {
            $yungou_shop->is_shaidan = 1;
            $yungou_shop->shaidan_id = $response->obj->shaidan_id;
            $yungou_shop->save();
            $mcy_user->score += 300;
            $mcy_user->save();
          }
          return $response->toJson();
        }else{
          return $response->reply(2,'找不到用户');
        }
      }
      public function apiUserKuaiDi(Request $request)
      {
        $response = new  ApiResponse;

        $mcy_user = McyUser::getUserInfo();
        $yungou_id = $request->input('yungou_id');
        $yungou = McyYunGou::where('is_delete',0)->where('yungou_id',$yungou_id)->first();
        if ($yungou)
        {

          if (!($yungou->order_mobile == ''))
          {
            return $response->reply(4,'该订单已经填写过地址了');
          }else{}
          if ($mcy_user){
              $yungou->order_addr = $request->input('order_addr');
              $yungou->order_mobile = $request->input('order_mobile');
              $yungou->order_people = $request->input('order_people');
              $yungou->order_desc = $request->input('order_desc');
              $yungou->order_deal = 1;
            if ($yungou->save())
            {
              return $response->reply(0,'填写成功,我们会尽快发货');
            }else{
              return $response->reply(2,'数据库写入错误');
            }
          }else{
            return $response->reply(3,'没有该用户');
          }
        }else{
          return $response->reply(3,'没有该订单');
        }
      }
      public function apiShareGetMoney(Request $request)
      {
        $response = new ApiResponse;
        return $response->reply(0,'感谢分享');
        $openid = $request->session()->get('openid');
        $mcy_user = McyUser::where('openid',$openid)->where('is_delete',0)->first();

        $has = McyShare::where("is_delete",0)->where('mcy_user_id',$mcy_user->mcy_user_id)->first();
        if ($has)
        {
          return $response->reply(0,'感谢分享');
        }else{
          $model = 'App\Model\McyShare';
          $data['mcy_user_id'] = $mcy_user->mcy_user_id;
          $data['money'] = 8;
          $result = $response->create($model,$data);
          if (json_decode($result)->ret == 0)
          {
            $mcy_user->money += $data['money'];
            $mcy_user->save();
          }else{
            return $response->reply(0,'分享出错');
          }
          return $response->reply(0,'分享金额直接入账！');
        }

       
      }
      public function apiUserWithdrawApply(Request $request)
      {
        $response = new ApiResponse;
        $openid = $request->session()->get('openid');
        $mcy_user = McyUser::where('openid',$openid)->where('is_delete',0)->first();


        $has = McyWithDraw::where("is_delete",0)->where('mcy_user_id',$mcy_user->mcy_user_id)->where('status',0)->first();
        if ($has)
        {
          return $response->reply(3,'提款将在一周内到账，请耐心等候');
        }else{

          if ($mcy_user->slave_money <= 100)
          {
            return $response->reply(2,'提款金额必须大于100元');
          }
          $model = 'App\Model\McyWithDraw';
          $data['mcy_user_id'] = $mcy_user->mcy_user_id;
          $data['withdraw_price'] = $mcy_user->slave_money;
          $data['bank_username'] = $request->input('bank_username');
          $data['bank_id'] = $request->input('bank_id');
          $data['bank_name'] = $request->input('bank_name');
          $data['is_delete'] = 0;
          $result = $response->create($model,$data);
          if (json_decode($result)->ret == 0)
          {
            /* 提款成功 */
            $mcy_user->slave_money = 0 ;
            $mcy_user->save();
          }else{
            return $response->reply(0,'提款出错');
          }
          return $response->reply(0,'提款成功，资金将在一周内到账，请耐心等候');
        }
      }


      public function apiUserShareToMoney(Request $request)
      {
        $response = new ApiResponse;
        $openid = $request->session()->get('openid');
        $mcy_user = McyUser::where('openid',$openid)->where('is_delete',0)->first();
        if ($mcy_user)
        {
          if ($mcy_user->slave_money > 0)
          {
            $mcy_user->money += $mcy_user->slave_money;
            $mcy_user->slave_money = 0;
            // $mcy_user->save();
            if ($mcy_user->save())
            {
              return $response->reply(0,'充入账户成功');
            }else{
              return $response->reply(2,'充入账户出错');
            }
          }else{
            return $response->reply(3,'充值金额必须大于0');
          }
        }else{
         return $response->reply(3,'用户出错');
        }
      }


      public function apiAddressCreate(Request $request)
      {
            $response = new ApiResponse;
            $model = 'App\Model\McyAddress';
            $openid = $request->session()->get('openid');
            $mcy_user = McyUser::where('openid',$openid)->where('is_delete',0)->where('is_robot',0)->first();
            if ($mcy_user)
            {
              $data['mcy_user_id'] = $mcy_user->mcy_user_id;
              $data['address_name'] = @$request->input('address_name');
              $data['is_set'] = @$request->input('is_set');
              if ($data['is_set'] == 1){
                McyAddress::where('mcy_user_id',$mcy_user->mcy_user_id)->where('is_delete',0)->update(array('is_set'=>0));
              }else{}
              $data['address_mobile'] = @$request->input('address_mobile');
              $data['address_people'] = @$request->input('address_people');              
              $data['remark'] = @$request->input('remark');              
              $result = $response->create($model,$data);
             
              return $response->toJson();
            }else{
              return $response->reply(2,'请重新登录');
            }
      }
     public function apiAddressUpdate(Request $request)
      {
            $response = new ApiResponse;
            $model = 'App\Model\McyAddress';
            $openid = $request->session()->get('openid');
            $mcy_user = McyUser::where('openid',$openid)->where('is_delete',0)->where('is_robot',0)->first();
            if ($mcy_user)
            {
              $search = array();
              $search['mcy_user_id']  = $mcy_user->mcy_user_id;
              $search['address_id'] = @$request->input('address_id');
              $search['is_delete'] = 0;

              $data['mcy_user_id'] = $mcy_user->mcy_user_id;
              $data['address_name'] = @$request->input('address_name');
              $data['is_set'] = @$request->input('is_set');
              if ($data['is_set'] == 1){
                McyAddress::where('mcy_user_id',$mcy_user->mcy_user_id)->where('is_delete',0)->update(array('is_set'=>0));
              }else{}
              $data['address_mobile'] = @$request->input('address_mobile');
              $data['address_people'] = @$request->input('address_people');              
              $data['remark'] = @$request->input('remark');              
              $result = $response->update($model,$search,$data);
             
              return $response->toJson();
            }else{
              return $response->reply(2,'请重新登录');
            }
      }
      public function apiAddressDelete(Request $request)
      {
        $response = new ApiResponse;
        $model = 'App\Model\McyAddress';
        $openid = $request->session()->get('openid');
        $mcy_user = McyUser::where('openid',$openid)->where('is_delete',0)->where('is_robot',0)->first();
        if ($mcy_user)
        {
          $data = array();
          $data['mcy_user_id'] = $mcy_user->mcy_user_id;
          $data['address_id'] = @$request->input('address_id');
     
          $result = $response->delete($model,$data);
         
          return $response->toJson();
        }else{
          return $response->reply(2,'请重新登录');
        }
      }
      public function apiGetDefaultAddress(Request $request)
      {
        $response = new ApiResponse;
        $openid = $request->session()->get('openid');
        $mcy_user = McyUser::where('openid',$openid)->where('is_delete',0)->where('is_robot',0)->first();
        if ($mcy_user)
        {
          $address = McyAddress::where('is_set',1)->where('mcy_user_id',$mcy_user->mcy_user_id)->first();
          if ($address)
            {}else{
              $address = McyAddress::where('mcy_user_id',$mcy_user->mcy_user_id)->first();
            }
          if ($address){}else{
            return $response->reply(3,'没有默认地址');
          }
          $response->address_people = @$address->address_people;
          $response->address_id = @$address->address_id;
          $response->address_name = @$address->address_name;
          $response->address_mobile = @$address->address_mobile;
          $response->remark = @$address->remark;
          return $response->reply(0,'填写成功,请确认后提交');
        }else{
          return $response->reply(2,'请重新登录');
        }
      }

    public function apiCreateDuihuan(Request $request)
    {
        $response = new ApiResponse;
        $yungou_id = $request->input('yungou_id');

        $mcy_user = McyUser::getUserInfo();

        $yungou_shop = McyYunGou::where('yungou_id',$yungou_id)->where('is_delete',0)->first();
        if (!$yungou_shop) {
            return $response->reply(3,'找不到这个云购单号');
        }

        if($yungou_shop->huode_id!=$mcy_user->mcy_user_id){
            return $response->reply(3,'这个云购单的中奖用户并非当前用户');
        }

        //处理过不能再进行兑换
        if(!empty($yungou_shop->order_deal)){
            return $response->reply(3,'这个云购单已经兑换过或填了发货单!');
        }

        //网站配置信息
        @$site = McySite::getInfo();
        if(!$site) return $response->reply(3,'兑换出错,请联系管理员!');
        //兑换回扣
        $rate_duihuan = $site->rage_duihuan;
        //上一级佣金
        $rage_duihuan_pid = $site->rage_duihuan_pid;
        //福分和元比值
        $score_money =  $site->score_money;
        //兑换比例100-回扣
        $rate_user = 100-$rate_duihuan;

        //查找上一级
        $master_user = McyUser::where("mcy_user_id",$mcy_user->master_id)->where('is_delete',0)->first();

        //兑换福分换算
        $product = McyProduct::find($yungou_shop->product_id);
        $add_score =   floor(floor($product->product_price)*$rate_user/100/$score_money);

        //上一级获取佣金
        if($master_user){
            $add_pid_score = floor(floor($product->product_price)*$rage_duihuan_pid/100/$score_money);
        }

        //step1 开启事务
        DB::beginTransaction();

        try {

            //step2 福分增加
            $mcy_user->score = $mcy_user->score+$add_score;
            $mcy_user->save();


            //step3 写入中奖商品兑换福分记录表
            $fubiDuihuan = new FubiDuihuan;
            $fubiDuihuan->mcy_user_id = $mcy_user->mcy_user_id;
            $fubiDuihuan->qty = $add_score;
            $fubiDuihuan->yungou_id = $yungou_id;
            $fubiDuihuan->remark = '中奖商品金额'.$product->product_price.'兑换福分'.$add_score;
            $fubiDuihuan->save();


            //step4 写入兑换记录表
            $yongjing = new Yongjing();
            $yongjing->get_user_id = $mcy_user->mcy_user_id;
            $yongjing->pay_user_id = $mcy_user->mcy_user_id;
            $yongjing->qty = $add_score;
            $yongjing->type = 1;
            $yongjing->yungou_id = $yungou_id;
            $yongjing->remark = '兑换获取佣金'.$add_score;
            $yongjing->jishu = $product->product_price;
            $yongjing->rage = $rate_user;
            $yongjing->add_plus = 1;
            $yongjing->save();

            if($master_user){

                //step5 上一级获得佣金
                $master_user->score = $master_user->score+$add_pid_score;
                $master_user->save();


                //step5 写入上一级佣金记录表
                $yongjing = new Yongjing();
                $yongjing->get_user_id = $master_user->mcy_user_id;
                $yongjing->pay_user_id = $mcy_user->mcy_user_id;
                $yongjing->qty = $add_pid_score;
                $yongjing->type = 1;
                $yongjing->yungou_id = $yungou_id;
                $yongjing->remark = '兑换获取佣金'.$add_pid_score;
                $yongjing->jishu = $product->product_price;
                $yongjing->rage = $rage_duihuan_pid;
                $yongjing->add_plus = 1;
                $yongjing->save();
            }


            //step5 中奖商品已处理
            $yungou_shop->order_deal = 2;
            $yungou_shop->save();

            DB::commit();
            return $response->reply(0,'兑换成功');
        } catch(QueryException $ex) {

            DB::rollback();
            return $response->reply(3,'兑换失败');
        }

    }

    /**
     * 邀请好友注册链接被访问时
     */
    public function inviteFriend(Request $request){

        $mcy_user_id = $request->mcy_user_id;

        if(empty($mcy_user_id))  return redirect('/');
        $mcy_user = McyUser::getUserByUserId($mcy_user_id);
        if(!$mcy_user){
            return redirect('/');
        }
        //存邀请人的会员ID
        session(['invite_user_id' => $mcy_user_id]);

        return redirect('/register');
    }


    /**
     * 提交用户提现的福分信息
     */
    public function apiUserWithdrawFubiApply(Request $request)
    {
        $response = new ApiResponse;


        //表单验证
        $validator = Validator::make($request->all(), [
            'bank_phone' => "required|size:11,phone",
            'withdraw_price' => 'required|numeric',
            'bank_id'=>'required',
            'bank_name'=>'required',
            'bank_zhi_name'=>'required',
            'bank_username'=>'required',
        ]);
        $validator->setAttributeNames([
            'bank_phone' => '手机号',
            'withdraw_price'=>'申请提现的福分数',
            'bank_id'=>'银行账号',
            'bank_name'=>'银行名称',
            'bank_zhi_name'=>'开户支行',
            'bank_username'=>'开户人'
        ]);

        if($validator->fails()){

            return $response->reply(3,Tools::getErrorMsg($validator->errors()->all()));
        }

        //网站配置
        $site =  McySite::getInfo();
        $mcy_user = McyUser::getUserInfo();
        //福分转钱
        $money = Tools::formatMoney($mcy_user->score*$site->score_money);

        if($money-$request->input('withdraw_price')<0){
            return $response->reply(3,'输入额超出可提现金额!');
        }

        /*$has = McyWithDraw::where("is_delete",0)->where('mcy_user_id',$mcy_user->mcy_user_id)->where('status',0)->first();
        if ($has)
        {
            return $response->reply(3,'提款将在一周内到账，请耐心等候');
        }else{*/

        if ($money < 100)
        {
            return $response->reply(2,'福分余额未满100元,不能提现');
        }


        //1.开启事务
        DB::beginTransaction();
        try{

            //2.福分提现记录
            $model = 'App\Model\McyWithDraw';
            $data['mcy_user_id'] = $mcy_user->mcy_user_id;
            $data['withdraw_price'] = $request->input('withdraw_price');
            $data['score'] = $request->input('withdraw_price')/$site->score_money;
            $data['bank_username'] = $request->input('bank_username');
            $data['bank_id'] = $request->input('bank_id');
            $data['bank_name'] = $request->input('bank_name');
            $data['bank_zhi_name'] = $request->input('bank_zhi_name');
            $data['bank_phone'] = $request->input('bank_phone');
            $data['is_delete'] = 0;
            $data['status'] = 0;
            $result = $response->create($model,$data);

            //3.福分数减少
            $mcy_user->score =  $mcy_user->score-$data['score'];
            $mcy_user->save();

            //4.佣金记录提现减少福分
            //钱转福分
            $withdraw_score = Tools::formatMoney($request->input('withdraw_price')/$site->score_money);
            $mcy_yongjin =  new Yongjing();
            $mcy_yongjin->get_user_id = $mcy_user->mcy_user_id;
            $mcy_yongjin->pay_user_id = $mcy_user->mcy_user_id;
            $mcy_yongjin->qty = $withdraw_score;
            $mcy_yongjin->type = 4;
            $mcy_yongjin->yungou_id = $result;
            $mcy_yongjin->remark = '提现';
            $mcy_yongjin->add_plus = 2;
            $mcy_yongjin->jishu = 0;
            $mcy_yongjin->save();

            DB::commit(); //提交

            return $response->reply(0,'提款成功，资金将隔天到账，请耐心等候');
        }catch (\Exception $e) {
            DB::rollBack(); //回滚
            return $response->reply(0,'提款出错');

        }

    }

    /**
     * 提交申请超级代理商信息
     */
    public function apiUserSupperMasterApply(Request $request)
    {
        $response = new ApiResponse;


        //表单验证
        $validator = Validator::make($request->all(), [
            'phone' => "required|size:11,phone",
            'real_name'=>'required',
        ]);
        $validator->setAttributeNames([
            'phone' => '联系电话',
            'real_name'=>'申请人姓名'
        ]);

        if($validator->fails()){

            return $response->reply(3,Tools::getErrorMsg($validator->errors()->all()));
        }

        //用户ID
        $mcy_user_id =  $request->session()->get('user_id');

        //检查用户是否提交过申请
        $has = McySupermasterApply::where("mcy_user_id",$mcy_user_id)->first();
        if ($has)
        {
            return $response->reply(3,'您已提交过申请，请耐心等候审核!');
        }

        $model = 'App\Model\McySupermasterApply';
        $data['mcy_user_id'] = $mcy_user_id;
        $data['real_name'] = $request->input('real_name');
        $data['phone'] = $request->input('phone');
        $data['token'] = Tools::genToken();
        $data['status'] = 1;
        $result = $response->create($model,$data);
        if (json_decode($result)->ret == 0)
        {
            return $response->reply(0,'已提交申请，请耐心等候审核');
        }else{
            return $response->reply(0,'提交出错');
        }


    }


    /**
     * 超级代理商邀请好友注册链接被访问时
     */
    public function inviteSuperFriend(Request $request){

        $token = $request->token;

        if(empty($token))  return redirect('/');
        //判断token是否有效
        $mcy_supper_master = McySupermasterApply::checkToken($token);
        if(!$mcy_supper_master){
            Tools::showMessage("还没有申请成为超级代理商!",url('/'));

        }
        //判断会员是否存在
        $mcy_user = McyUser::getUserByUserId($mcy_supper_master->mcy_user_id);
        if(!$mcy_user){
            Tools::showMessage("还不是我们平台的会员,请先注册!",url('/'));

        }
        //判断对应的代理商是否授权通过的
        if($mcy_supper_master->status!=2){

            Tools::showMessage("代理商还没有授权!",url('/'));

        }

        //存超级代理商邀请人的会员ID
        session(['super_master_user' => $mcy_supper_master->mcy_user_id]);

        return redirect('/register');
    }

}
