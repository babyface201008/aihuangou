<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

/**
 * The McySendSms Model
 **/
class McySendSms extends Model
{
// public $timestamps = false;
  protected $table = 'mcy_send_sms';
  protected $primaryKey = 'send_sms_id';
}
?>
