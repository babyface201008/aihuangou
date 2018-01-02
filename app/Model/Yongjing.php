<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

/**
 * The Article Model
 **/
class Yongjing extends Model
{
// public $timestamps = false;
  protected $table = 'mcy_yongjing';
  protected $primaryKey = 'yongjing_id';


  /**
   * 获取佣金方式
   */
  public static  function  getType($type){
      if($type==1){
         return '兑换';
      }elseif($type==2){
        return '充值';
      }elseif($type==3){
        return '购买';
      }elseif($type==4){
        return '提现';
      }else{
        return '';
      }
  }
}
?>
