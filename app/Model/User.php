<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

/**
 * The User Model
 **/
class User extends Model
{
// public $timestamps = false;
  protected $table = 'mcy_user';
  protected $primaryKey = 'user_id';
}
?>
