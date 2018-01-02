<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

/**
 * The TodoList Model
 **/
class TodoList extends Model
{
// public $timestamps = false;
  protected $table = 'mcy_todolist';
  protected $primaryKey = 'todolist_id';
}
?>
