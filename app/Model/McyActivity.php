<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

/**
 * The McyActivity Model
 **/
class McyActivity extends Model
{
// public $timestamps = false;
  protected $table = 'mcy_activity';
  protected $primaryKey = 'activity_id';
}
?>
