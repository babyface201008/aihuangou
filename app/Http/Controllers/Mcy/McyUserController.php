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
use App\Model\McyUserUpdate;


class McyUserController extends Controller
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
    $searchmobile = $request->input('searchmobile','');
  	$master_id = $request->input('master_id','');
    $is_robot = $request->input('is_robot',0);
    $admin_id = $request->session()->get('admin_id');
    $site = McySite::where('is_delete',0)->where('user_id',$admin_id)->first();
    @$site_id = @$site->site_id;
    if ($searchmobile !== '' && $searchmobile !== null){
      $users = McyUser::where('is_delete',0)->where('site_id',$site_id)->where('is_robot',$is_robot)->where('mobile',$searchmobile)->whereBetween('created_at',[$starttime,$endtime])->orderBy('created_at','desc')->paginate(20);
        return view('welkin.mcy.users',compact('users','starttime','endtime','searchtext','is_robot','searchmobile','master_id'));
    }else{}
    if ($master_id !== '' && $master_id !== null){
      $users = McyUser::where('is_delete',0)->where('site_id',$site_id)->where('is_robot',$is_robot)->where('master_id',$master_id)->whereBetween('created_at',[$starttime,$endtime])->orderBy('created_at','desc')->paginate(20);
        return view('welkin.mcy.users',compact('users','starttime','endtime','searchtext','is_robot','searchmobile','master_id'));
    }else{}
  	if ($searchtext !== '' && $searchtext !== null)
  	{
      // $users = McyUser::where('is_delete',0)->where('site_id',$site_id)->where('is_robot',$is_robot)->where('username','like','%'.$searchtext.'%')->whereBetween('created_at',[$starttime,$endtime])->orderBy('created_at','desc')->paginate(20);
      $users = McyUser::where('is_delete',0)->where('site_id',$site_id)->where('is_robot',$is_robot)->where('mcy_user_id',$searchtext)->whereBetween('created_at',[$starttime,$endtime])->orderBy('created_at','desc')->paginate(20);
  	}else{

  		$users = McyUser::where('is_delete',0)->where('site_id',$site_id)->where('is_robot',$is_robot)->whereBetween('created_at',[$starttime,$endtime])->orderBy('created_at','desc')->paginate(20);
  	}

  	return view('welkin.mcy.users',compact('users','starttime','endtime','searchtext','is_robot','searchmobile','master_id'));
  }
  public function userUpdateSearch(Request $request)
  {
    $starttime = empty($request->input('starttime',''))?'1971-1-1':$request->input('starttime');
    $endtime = empty($request->input('endtime',''))?'2099-12-31':$request->input('endtime');
    $searchtext = $request->input('searchtext','');
    if ($searchtext !== '' && $searchtext !== null)
    {
      $user_update_searchs = McyUserUpdate::where('is_delete',0)->where('mcy_user_id',$searchtext)->whereBetween('created_at',[$starttime,$endtime])->orderBy('created_at','desc')->paginate(20);
    }else{
      $user_update_searchs = McyUserUpdate::where('is_delete',0)->whereBetween('created_at',[$starttime,$endtime])->orderBy('created_at','desc')->paginate(20);
    }
    return view('welkin.mcy.user_update_search',compact('user_update_searchs','starttime','endtime','searchtext'));
  }

  public function userCreate(Request $request)
  {
    return view('welkin.mcy.user_create');
  }

  public function userUpdate(Request $request)
  {
    $user_id = $request->input('user_id');
    $user = McyUser::where('mcy_user_id',$user_id)->where('is_delete',0)->first();
    return view('welkin.mcy.user_update',compact('user'));
  }

  public function userPassword(Request $request)
  {
    $admin_id = $request->session()->get('admin_id');
    $user = McyUser::where('user_id',$admin_id)->where('is_delete',0)->first();
    return view('welkin.mcy.password',compact('user'));
  }


  public function logout(Request $request)
  {
    if ($request->session()->has('admin_id'))
    {
      $request->session()->forget('admin_id');
    }else{}

    return view('welkin.mcy.login');
  }



}
