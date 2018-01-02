<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

/**
 * The McyWithdraw Model
 **/
class McyWithDraw extends Model
{
// public $timestamps = false;
  protected $table = 'mcy_withdraw_record';
  protected $primaryKey = 'withdraw_id';
}
?>
