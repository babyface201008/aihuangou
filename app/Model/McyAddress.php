<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

/**
 * The McyAddress Model
 **/
class McyAddress extends Model
{
// public $timestamps = false;
  protected $table = 'mcy_address';
  protected $primaryKey = 'address_id';
}
?>
