<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

/**
 * The McyPay Model
 **/
class McyPay extends Model
{
// public $timestamps = false;
  protected $table = 'mcy_payinfo';
  protected $primaryKey = 'payinfo_id';
}
?>
