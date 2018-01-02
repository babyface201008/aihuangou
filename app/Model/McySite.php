<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

/**
 * The McySite Model
 **/
class McySite extends Model
{
// public $timestamps = false;
  protected $table = 'mcy_site';
  protected $primaryKey = 'site_id';

    /**
     * 根据ID获取网站配置信息
     * @param $site_id
     */
  public static  function  getInfo($site_id='3'){
      $site_info =  McySite::where('site_id',$site_id)->first();
      return $site_info;
  }
}
?>
