<?php

namespace App\Http\Controllers\Mcy;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Response;
use App\Tools;
use App\Tools\MyLog\SiteLog;
use App\Model\McyUser;
use App\Model\McyShop;
use App\Model\AiHuanGouUser;
use App\Model\McyWxInfo;
use App\Model\McySms;


class McySmsInfoController  extends Controller
{    

  protected $starttime;
  protected $endtime;
  protected $searchtext;
  protected $page_number;

  public function __construct(Request $request)
  {
  	@$this->starttime = empty($request->input('starttime',''))?'1971-1-1':$request->input('starttime').' 00:00:00';
  	@$this->endtime = empty($request->input('endtime',''))?'2099-12-31':$request->input('endtime').' 23:59:59';
  	@$this->searchtext = $request->input('searchtext','');
  	@$this->page_number = 50;
  }

  public function smsInfo(Request $request)
  {
  	$admin_id = $request->session()->get('admin_id');
  	$sms = McySms::where('is_delete',0)->where('user_id',$admin_id)->first();
  	return view('welkin.mcy.smsinfo',compact('sms'));
  }
}
