<?php

namespace App\Http\Controllers\Api\Mcy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools;
use App\Response;
use App\ApiResponse;
use App\Model\McyUser;
use App\Model\McyProduct;
use App\Model\McyShaiDan;
use App\Model\McySite;
use App\Model\McyYunGou;
use App\Model\McyYunGouOrder;

class ApiMcyShaiDanController extends Controller
{

    public function apiMcyShaiDanCreate(Request $request)
    {
        $response = new ApiResponse;
        parse_str($request->input('data') , $data);
        // $admin_id = $request->session()->get('admin_id');
        $mcy_user = McyUser::where('mcy_user_id',@$data['mcy_user_id'])->where('is_delete',0)->first();
        $yungou_id = $request->input('yungou_id');
        $yungou_shop = McyYunGou::where('yungou_id',$yungou_id)->where('is_delete',0)->first();
        if (!$yungou_shop) { return $response->reply(3,'找不到这个云购单号');}
        if ($mcy_user)
        {
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
          $d['mcy_user_id'] = @$data['mcy_user_id'];
          $d['username'] = @($mcy_user->username)?@$mcy_user->username:@$mcy_user->nickname;
          $result = $response->create($model,$d);
          if ($response->ret == 0)
          {
            $yungou_shop->is_shaidan = 1;
            $yungou_shop->shaidan_id = $response->obj->shaidan_id;
            $yungou_shop->save();
          }
          return $response->toJson();
        }else{
          return $response->reply(2,'找不到用户');
        }
        
    }
    public function apiMcyShaiDanUpdate(Request $request)
    {
      $response = new ApiResponse;
      parse_str($request->input('data') , $data);
      $admin_id = $request->session()->get('admin_id');
      if ($admin_id)
      {
        $mcy_user = McyUser::where('mcy_user_id',@$data['mcy_user_id'])->where('is_delete',0)->first();
        if ($mcy_user)
        {
          $model = 'App\Model\McyShaiDan';
          $search = array(
            'shaidan_id'=>@$data['shaidan_id'],
            'mcy_user_id'=>@$data['mcy_user_id'],
            'is_delete'=>0,
            );
          $d = array();
          $d['shaidan_img'] = $request->input('shaidan_img')?$request->input('shaidan_img'):'';
          $d['shaidan_content'] = $request->input('shaidan_content');
          $result = $response->update($model,$search,$d);
          return $response->toJson();
        }else{
          return $response->reply(2,'找不到用户');
        }
      }else{
        return $response->reply(3,'会话过期，请重新登录');
      }
    }
    public function apiMcyShaiDanUpdateStatus(Request $request)
    {
      $response = new ApiResponse;
      parse_str($request->input('data') , $data);
      $admin_id = $request->session()->get('admin_id');
      if ($admin_id)
      {
        $mcy_user = McyUser::where('mcy_user_id',$request->input('mcy_user_id'))->where('is_delete',0)->first();
        if ($mcy_user)
        {
          $model = 'App\Model\McyShaiDan';
          $search = array(
            'shaidan_id'=>@$request->input('shaidan_id'),
            'mcy_user_id'=>@$request->input('mcy_user_id'),
            'is_delete'=>0,
            );
          $d = array();
          if ($request->input('status') == 0){
            $d['status'] = 1; 
          }else{
            $d['status'] = 0; 
          }
          $result = $response->update($model,$search,$d);
          return $response->toJson();
        }else{
          return $response->reply(2,'找不到用户');
        }
      }else{
        return $response->reply(3,'会话过期，请重新登录');
      }
    }
    public function apiMcyShaiDanDelete(Request $request)
    {
      $response = new ApiResponse;
      $admin_id = $request->session()->get('admin_id');
      if ($admin_id) 
      {
        $shaidan_id = $request->input('shaidan_id');
        $model = 'App\Model\McyShaiDan';
        $data = array();
        $data['shaidan_id'] = $shaidan_id;
        $data['user_id'] = $admin_id;
        $response->shaidan_id = $shaidan_id;
        $request = $response->delete($model,$data);
        return $response->toJson();
      }else{
        return $response->reply(3,'会话过期，请重新登录');
      }


        
      }

}
