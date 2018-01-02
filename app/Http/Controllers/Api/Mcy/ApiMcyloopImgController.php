<?php

namespace App\Http\Controllers\Api\Mcy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools;
use App\Response;
use App\ApiResponse;
use App\Model\McyUser;
use App\Model\McyProduct;
use App\Model\McyLoopImg;
use App\Model\McySite;

class ApiMcyLoopImgController extends Controller
{

    public function apiMcyLoopImgCreate(Request $request)
    {
        $response = new ApiResponse;
        parse_str($request->input('data') , $data);
        $admin_id = $request->session()->get('admin_id');
        if ($admin_id)
        {
          $model = 'App\Model\McyLoopImg';
          $d = array();
          $d['status'] = @$data['status'];
          $d['sort'] = @$data['sort'];
          $d['link_href'] = @$data['link_href'];
          $d['loopimg_url'] = @$request->input('loopimg_url')?$request->input('loopimg_url'):'';
          $d['loopimg_desc'] = @$request->input('loopimg_desc')?$request->input('loopimg_desc'):'';
          $d['user_id'] = $admin_id;
          $result = $response->create($model,$d);
          return $response->toJson();
        }else{
          return $response->reply(2,'会话过期，请重新登录');
        }
        
    }
    public function apiMcyLoopImgUpdate(Request $request)
    {
        $response = new ApiResponse;
        parse_str($request->input('data') , $data);
        $admin_id = $request->session()->get('admin_id');
        if ($admin_id)
        {
          $model = 'App\Model\McyLoopImg';
          $search = array(
            'loopimg_id'=>$data['loopimg_id'],
            'user_id'=>$admin_id
            );
          $d = array();
          $d['status'] = @$data['status'];
          $d['link_href'] = @$data['link_href'];
          $d['sort'] = @$data['sort'];
          $d['loopimg_url'] = @$request->input('loopimg_url')?$request->input('loopimg_url'):'';
          $d['loopimg_desc'] = @$request->input('loopimg_desc')?$request->input('loopimg_desc'):'';
          $result = $response->update($model,$search,$d);
          return $response->toJson();
        }else{
          return $response->reply(2,'会话过期，请重新登录');
        }
     
    }
    public function apiMcyLoopImgDelete(Request $request)
    {
      $response = new ApiResponse;
      $admin_id = $request->session()->get('admin_id');
      if ($admin_id) 
      {
        $loopimg_id = $request->input('loopimg_id');
        $model = 'App\Model\McyLoopImg';
        $data = array();
        $data['loopimg_id'] = $loopimg_id;
        $data['user_id'] = $admin_id;
        $response->loopimg_id = $loopimg_id;
        $request = $response->delete($model,$data);
        return $response->toJson();
      }else{
        return $response->reply(3,'会话过期，请重新登录');
      }


        
      }

}
