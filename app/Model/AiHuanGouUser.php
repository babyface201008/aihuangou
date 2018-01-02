<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

/**
 * The AiHuanGouuser Model
 **/
class AiHuanGouUser extends Model
{
// public $timestamps = false;
  protected $table = 'aihuangou_user';
  protected $primaryKey = 'user_id';
}
?>