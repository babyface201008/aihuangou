<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tools;
use App\Model\AiHuanGouUser;


class AiHuanGouUserController extends Controller
{    
   /**
   * 用户管理
   * @AiHuanGou
   * @DateTime      2017-04-07T10:52:48+0800
   * @param         Request                  $request 
   * @return        view                            
   */
  public function users(Request $request)
  {
  	
  	$starttime = empty($request->input('starttime',''))?'1971-1-1':$request->input('starttime').' 00:00:00';
  	$endtime = empty($request->input('endtime',''))?'2099-12-31':$request->input('endtime').' 23:59:59';
  	$searchtext = $request->input('searchtext','');
  	if ($searchtext !== '')
  	{
  		$users = AiHuanGouUser::where('is_delete',0)->where('username','like','%'.$searchtext.'%')->whereBetween('created_at',[$starttime,$endtime])->paginate(20);
  	}else{
  		$users = AiHuanGouUser::where('is_delete',0)->whereBetween('created_at',[$starttime,$endtime])->paginate(20);
  	}

  	return view('welkin.users',compact('users','starttime','endtime','searchtext'));
  }

  public function userCreate(Request $request)
  {
    return view('welkin.usercreate');
  }

  public function userUpdate(Request $request)
  {
    $user_id = $request->input('user_id');
    $user = AiHuanGouUser::where('user_id',$user_id)->where('is_delete',0)->first();
    return view('welkin.userupdate',compact('user'));
  }

  public function userPassword(Request $request)
  {
    $admin_id = $request->session()->get('admin_id');
    $user = AiHuanGouUser::where('user_id',$admin_id)->where('is_delete',0)->first();
    return view('welkin.password',compact('user'));
  }


  public function logout(Request $request)
  {
    if ($request->session()->has('admin_id'))
    {
      $request->session()->forget('admin_id');
    }else{}
    return view('welkin.login');
  }

}
