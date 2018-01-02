<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

/**
 * The News Model
 **/
class News extends Model
{
// public $timestamps = false;
  protected $table = 'mcy_news';
  protected $primaryKey = 'new_id';
}
?>
