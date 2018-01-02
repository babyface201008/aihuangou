<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

/**
 * The McySendHistory Model
 **/
class McySendHistory extends Model
{
// public $timestamps = false;
  protected $table = 'mcy_send_history';
  protected $primaryKey = 'send_history_id';
}
?>
