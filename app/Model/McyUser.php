<?php
namespace App\Model;
use App\Tools;
use Illuminate\Database\Eloquent\Model;
use App\Model\McySupermasterApply;
/**
 * The McyUser Model
 **/
class McyUser extends Model
{
// public $timestamps = false;
  protected $table = 'mcy_user';
  protected $primaryKey = 'mcy_user_id';

    /**
     * 获取用户信息
     */
  public static function getUserInfo(){

      $openid = session('open_id');

      $user_id = session('user_id');
      $mcy_user = array();
      if($user_id)
      {
          $mcy_user = McyUser::where('mcy_user_id',$user_id)->where('is_delete',0)->where('is_robot',0)->first();
      }elseif($openid){
          $mcy_user = McyUser::where('openid',$openid)->where('is_delete',0)->where('is_robot',0)->first();
      }
      $mcy_user->score = Tools::formatMoney($mcy_user->score);
      return $mcy_user;
  }

    /**
     * 由mcy_user_id获取用户信息
     */
    public static function getUserByUserId($mcy_user_id){

        if(empty($mcy_user_id)) return false;

        $mcy_user = McyUser::where('mcy_user_id',$mcy_user_id)->where('is_delete',0)->first();


        return $mcy_user;
    }

    /**
     * 获取用户的推广二维码
     */
    public static function getQRcode($mcy_user_id){
        if(empty($mcy_user_id)) return false;

        //判断是普通代理商还是超级代理商
        $check = McySupermasterApply::checkSuperUser($mcy_user_id);
        if(isset($check)){//是超级代理商
            $url = url('invite/super/friend').'/'.$check->token;
        }else{
            $url = url('invite/friend').'/'.$mcy_user_id;
        }

        return $url;
    }

    /**
     * 获取邀请的会员
     */
    public static function getInviteUser($mcy_user_id){

        //查看用户是否超级代理商
        $mcy_super_master = McySupermasterApply::checkSuperUser($mcy_user_id);
        $inviteUser = array();
        if($mcy_super_master){//超级
            //成功邀请的会员
            $inviteUser  = McyUser::where("super_master_id",$mcy_user_id)->where('is_delete','0')->get();
        }else{//普通
            //成功邀请的会员
            $inviteUser  = McyUser::where("master_id",$mcy_user_id)->where('is_delete','0')->get();
        }

        $data = array();
        if($inviteUser){
            foreach($inviteUser as $val){
                $data[$val['mcy_user_id']] = $val['username'];
            }
        }

        return $data;
    }


    /**
     * 获取超级代理商邀请的客户
     */
    public static function getSupperClient($mcy_user_id){

        //查看用户是否超级代理商
        $mcy_super_master = McySupermasterApply::checkSuperUser($mcy_user_id);
        $inviteUser = array();
        if($mcy_super_master){//超级
            //成功邀请的会员
            $inviteUser  = McyUser::where("super_master_id",$mcy_user_id)->where('is_delete','0')->get();
        }



        return $inviteUser;
    }

}
?>
