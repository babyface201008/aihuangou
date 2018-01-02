<?php 
namespace App\Http\Controllers\Mcy;
use App\Model\McySupermasterApply;
use App\Model\McyUser;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Response;
use App\Tools;
use App\Tools\MyLog\SiteLog;
use App\Model\News;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Model\McyTopUp;

/**
* 超级代理商
*/
class McySupperMasterController extends Controller
{



	public function supperlist(Request $request)
	{
        $starttime = empty($request->input('starttime',''))?'1971-1-1':$request->input('starttime').' 00:00:00';
        $endtime = empty($request->input('endtime',''))?'2099-12-31':$request->input('endtime').' 23:59:59';
        $searchtext = $request->input('searchtext','');
        $admin_id = $request->session()->get('admin_id');
        $real_name = $request->input('real_name','');

        $condition['is_delete'] = 0;
        if (!($real_name == ''))
        {
            $condition[] = ['real_name','=',$real_name];
        }
        if (!($searchtext == ''))
        {
            $condition[] = ['phone','=',$searchtext];
        }
       if($starttime!=''){
                $condition[] = ['created_at','>=',$starttime] ;

        }
        if($endtime!=''){
                $condition[]  = ['created_at','<=',$endtime];
        }
        $suppermasters = McySupermasterApply::where($condition)->orderby('status','asc')->orderby('created_at','desc')->paginate(20);


        return view('welkin.mcy.suppermaster',compact('suppermasters','starttime','endtime','searchtext','real_name'));
	}


        /**
         * 超级代理商二维码
         */
        public function userMyCode(Request $request)
        {

                $mcy_user_id = $request->user_id;
                $mcy_supermaster_apply = McySupermasterApply::where('mcy_user_id',$mcy_user_id)->where('is_delete',0)->first();
                if($mcy_supermaster_apply){
                        $url = McySupermasterApply::getSuperQRcode($mcy_supermaster_apply->token);
                        $real_name = $mcy_supermaster_apply->real_name;
                        return view('welkin.mcy.super_master_code',compact('url','mcy_supermaster_apply'));

                }else{
                        echo '没有该代理商';
                }


        }


    /**
     * 超级代理商推广客户
     */
    public function  supperClientList(Request $request){

        //用户ID
        $mcy_user_id = $request->user_id;
        //用户信息
        $mcy_user = McyUser::getUserByUserId($mcy_user_id);
        //推广客户列表信息
        $inviteUser = McyUser::where("super_master_id",$mcy_user_id)->where('is_delete','0')->orderby('created_at','desc')->paginate(20);
        //成功邀请的会员
        $inviteCount = McyUser::where("super_master_id",$mcy_user->mcy_user_id)->where('is_delete','0')->count();

        //已参与购买会员数
        $hasBuyCount = 0;
        if($inviteUser){
            foreach($inviteUser as $key=>$val){

                //是否充值
                $mcy_top_up = McyTopUp::where('mcy_user_id',$val->mcy_user_id)->where('status',1)->first();
                $inviteUser[$key]['is_chongzhi'] = $mcy_top_up?'已充值':'未充值';
                if($mcy_top_up){
                    $hasBuyCount++;
                }
            }
        }

        return view('welkin.mcy.supper_master_client',compact('mcy_user','inviteUser','hasBuyCount','inviteCount'));
    }

}

 ?>