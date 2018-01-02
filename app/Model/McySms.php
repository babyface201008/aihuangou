<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

/**
 * The McySms Model
 **/
class McySms extends Model
{
// public $timestamps = false;
  protected $table = 'mcy_sms';
  protected $primaryKey = 'sms_id';


  /**
   * 获取短信配置信息
   * @param $site_id
   */
  public static  function  getInfo(){
    $mcy_sms =  McySms::where("is_delete",0)->where('status',0)->first();
    return $mcy_sms;
  }
}
?>
