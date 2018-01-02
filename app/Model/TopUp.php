<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

/**
 * The TopUp Model
 **/
class TopUp extends Model
{
// public $timestamps = false;
  protected $table = 'mcy_topup';
  protected $primaryKey = 'topup_id';
}
?>
