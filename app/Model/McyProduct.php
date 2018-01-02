<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

/**
 * The McyProduct Model
 **/
class McyProduct extends Model
{
// public $timestamps = false;
  protected $table = 'mcy_product';
  protected $primaryKey = 'product_id';
}
?>
