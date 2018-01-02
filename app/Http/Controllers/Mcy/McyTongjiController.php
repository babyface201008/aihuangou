<?php 
namespace App\Http\Controllers\Mcy;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Response;
use App\Tools;
use App\Tools\MyLog\SiteLog;
use App\Model\McyUser;
use App\Model\McyYunGou;
use App\Model\McyProduct;
use App\Model\Category;
use App\Model\McyYunGouOrder;
use App\Model\McyOrder;
use App\Model\McySite;
use App\Model\McyTopupTongji;
use App\Model\McyTopup;

class McyTongjiController extends Controller
{
	public function tongji(Request $request)
	{
		/* 找出基准时间点 */
		$time_point = McyTopupTongji::where('is_delete',0)->orderBy('tj_id','desc')->first();
		if ($time_point){
			$timestart = date("Y-m-d",strtotime($time_point->created_at)).' 00:00:00';
			$timeend = date("Y-m-d",strtotime($time_point->created_at)).' 23:59:59';
		}else{
			$time_point = McyTopup::where('is_delete',0)->orderBy('topup_id','asc')->first();
			$timestart = date("Y-m-d",strtotime($time_point->created_at)).' 00:00:00';
			$timeend = date("Y-m-d",strtotime($time_point->created_at)).' 23:59:59';
		}

		/* 找出没有统计的数据 */
		$topups_paid = McyTopup::where('is_delete',0)->where('status',1)->whereBetween('created_at',[$timestart,$timeend])->select('topup_id','price','status')->get();
		$topups_unpaid = McyTopup::where('is_delete',0)->where('status',0)->whereBetween('created_at',[$timestart,$timeend])->select('topup_id','price','status')->get();
		/* 写入保存 */

		$count = 0;
		while(1){
			if ($count == 0){
				// $topuptj = new McyTopupTongji;
				// $topuptj->tj_starttime = $timestart;
				// $topuptj->tj_endtime = $timeend;
				// $topuptj->paid = @$topups_paid->sum('price');
				// $topuptj->unpaid = @$topups_unpaid->sum('price');
				// echo $timestart."=>".$timeend." "."收入： ".$topuptj->paid." 未收入：".$topuptj->unpaid;
				// echo "<br>";
			}else{
				$timestart = date("Y-m-d",strtotime(" + ".intval($count)." days",strtotime($time_point->created_at))).' 00:00:00';
				$timeend = date("Y-m-d",strtotime(" + ".intval($count)." days",strtotime($time_point->created_at))).' 23:59:59';
				$topups_paid = McyTopup::where('is_delete',0)->where('status',1)->whereBetween('created_at',[$timestart,$timeend])->select('topup_id','price','status')->get();
				$topups_unpaid = McyTopup::where('is_delete',0)->where('status',0)->whereBetween('created_at',[$timestart,$timeend])->select('topup_id','price','status')->get();
				$topuptj = new McyTopupTongji;
				$topuptj->tj_starttime = $timestart;
				$topuptj->tj_endtime = $timeend;
				$topuptj->paid = @$topups_paid->sum('price');
				$topuptj->unpaid = @$topups_unpaid->sum('price');
				echo $timestart."=>".$timeend." "."收入： ".$topuptj->paid." 未收入：".$topuptj->unpaid;
				echo "<br>";
			}
			$count++;

			if ($timestart >= date("Y-m-d")){
				break;
			}else{}
		}

		/* 列出数据 */
	}
	public function tongjiList(Request $request)
	{
		
	}
}

 ?>