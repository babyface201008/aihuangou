<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

/**
 * The Tag Model
 **/
class Tag extends Model
{
// public $timestamps = false;
  protected $table = 'tag';
  protected $primaryKey = 'tag_id';
}
?>
