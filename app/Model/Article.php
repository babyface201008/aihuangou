<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

/**
 * The Article Model
 **/
class Article extends Model
{
// public $timestamps = false;
  protected $table = 'article';
  protected $primaryKey = 'article_id';
}
?>
