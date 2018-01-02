<?php 
namespace App\Http\Controllers\Mcy;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Response;
use App\Tools;
use App\Tools\MyLog\SiteLog;
use App\Model\McyUser;
use App\Model\McyYunGou;
use App\Model\McyProduct;
use App\Model\Category;
use App\Model\McyYunGouOrder;
use App\Model\McyOrder;
use App\Model\McySite;
/**
* 测试类，用于处理日常Bug和其他的一些问题
*/
class McyTestController extends Controller
{
	public $user_id = 6;
	public $site_id = 2;
	public function category_count(Request $request)
	{
		$categorys  = Category::where('user_id',$this->user_id)->where('is_delete',0)->get();
		foreach($categorys as $category)
		{
			@$product_count = McyProduct::where('is_delete',0)->where('category_id',$category->category_id)->count();
			$category->count =  $product_count;
			$category->save();
		}
	}
}

 ?>