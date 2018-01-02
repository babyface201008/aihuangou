<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

/**
 * The McyOrder Model
 **/
class McyOrder extends Model
{
// public $timestamps = false;
  protected $table = 'mcy_order';
  protected $primaryKey = 'order_id';
}
?>
