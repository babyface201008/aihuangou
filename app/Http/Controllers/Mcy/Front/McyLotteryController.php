<?php

namespace App\Http\Controllers\Mcy\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Response;
use App\Tools;
use App\Tools\MyLog\SiteLog;
use App\Model\McyProduct;
use App\Model\McyLoopImg;
use App\Model\McyYunGou;
use App\Model\McyUser;
use App\Model\Category;
use App\Model\McySite;
use Cache;


class McyLotteryController extends Controller
{    
  public $site_id = 2;
  public $user_id = 6;
  public function lottery(Request $request)
  {
  	/* 找出已经揭晓了的产品 */
    $d = date('Y-m-d H:i:s');
   $lotterying = McyYunGou::where('is_delete',0)->where('status',1)->orderBy('show_time','>',0)->where('show_time','<',$d)->orderBy('show_time','desc')->limit(1)->get();
    // foreach($lotterying as $lottery)
    // {
    //   $p = McyProduct::where('product_id',$lottery->product_id)->select('product_img')->first();
    //   $u = McyUser::where('mcy_user_id',$lottery->huode_id)->select(array('mcy_user_id','username'))->first();
    //   $lottery->product_img = @$p->product_img;
    //   $lottery->username = @$u->username;
    //   $lottery->mcy_user_id = @$u->mcy_user_id;
    //   $lottery->cha = strtotime($lottery->show_time) - strtotime(date("Y-m-d H:i:s"));
    //   if ($lottery->cha < 0)  $lottery->cha = "0";
    // }
  	$date = date('Y-m-d H:i:s');
  	$lottery = McyYunGou::where('is_delete',0)->where('show_time','<',$date)->where('huode_id','<>',0)->paginate(10);
  	return view('mcy.lottery',compact('lottery','lotterying'));
  }



}
