<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

/**
 * The Category Model
 **/
class Category extends Model
{
// public $timestamps = false;
  protected $table = 'category';
  protected $primaryKey = 'category_id';
}
?>
