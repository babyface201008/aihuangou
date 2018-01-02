<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

/**
 * The McySite Model
 **/
class McySupermasterApply extends Model
{
// public $timestamps = false;
  protected $table = 'mcy_supermaster_apply';
  protected $primaryKey = 'super_id';


  /**
   * 判断token是否有效
   * @access public
   * @param string $method 方法名
   * @param array $args 参数
   * @return mixed
   */
  public static  function checkToken($token){

    if(empty($token)) return false;

    $data = McySupermasterApply::where('token',$token)->where('is_delete',0)->first();
    return $data;
  }


    /**
     * 查看会员是否是超级代理商
     */
    public static function checkSuperUser($mcy_user_id){

        if(empty($mcy_user_id)) return false;

        $data = McySupermasterApply::where('mcy_user_id',$mcy_user_id)->where('is_delete',0)->where('status',2)->first();

        return $data;
    }

    /**
     * 获取超级代理商推广URL
     */
    public static function getSuperQRcode($token){


        $url = url('invite/super/friend').'/'.$token;
        return $url;
    }
}
?>
