<?php

namespace App\Http\Controllers\Mcy;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Response;
use App\Tools;
use App\Tools\MyLog\SiteLog;
use App\Model\McyUser;
use App\Model\McyLoopImg;


class McyloopImgController  extends Controller
{    
   /**
   * 用户管理
   * @AiHuanGou
   * @DateTime      2017-04-07T10:52:48+0800
   * @param         Request                  $request 
   * @return        view                            
   */
  public function loopimg(Request $request)
  {
  	
  	$starttime = empty($request->input('starttime',''))?'1971-1-1':$request->input('starttime').' 00:00:00';
  	$endtime = empty($request->input('endtime',''))?'2099-12-31':$request->input('endtime').' 23:59:59';
  	$searchtext = $request->input('searchtext','');
    $admin_id = $request->session()->get('admin_id');
  	if ($searchtext !== '')
  	{
  		$loopimgs = McyLoopImg::where('is_delete',0)->where('user_id',$admin_id)->where('username','like','%'.$searchtext.'%')->whereBetween('created_at',[$starttime,$endtime])->paginate(20);
  	}else{
  		$loopimgs = McyLoopImg::where('is_delete',0)->where('user_id',$admin_id)->whereBetween('created_at',[$starttime,$endtime])->paginate(20);
  	}

  	return view('welkin.mcy.loopimg',compact('loopimgs','starttime','endtime','searchtext'));
  }

  public function loopImgCreate(Request $request)
  {
    return view('welkin.mcy.loopimg_create');
  }

  public function loopImgUpdate(Request $request)
  {
    $admin_id = $request->session()->get('admin_id');
    $loopimg_id = $request->input('loopimg_id');
    $loopimg = McyLoopImg::where('loopimg_id',$loopimg_id)->where('is_delete',0)->first();
    return view('welkin.mcy.loopimg_update',compact('loopimg'));
  }
}
