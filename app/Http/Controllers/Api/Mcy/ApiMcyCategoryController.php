<?php 
namespace App\Http\Controllers\Api\Mcy;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Tools;
use App\ApiResponse;
use App\Model\Article;
use App\Model\Tag;
use App\Model\Category;

/**
* ArticleController class
*/
class ApiMcyCategoryController extends Controller
{

	public function apiMcyCategoryCreate(Request $request)
	{
		$response = new ApiResponse;
		$name = $request->input('name');
		$admin_id = $request->session()->get('admin_id');
		$model = 'App\Model\Category';
		if ($admin_id)
		{
			$data = array(
				'name' => $name?$name:'',
				'user_id' => $admin_id?$admin_id:0,
				);
			$result = $response->create($model,$data);
			if ($response->ret == 0)
			{
				return $response->toJson();
			}else{
				return $response->reply(2,'添加失败');
			}
		}else{
			return $response->reply(2,'请重新登录');
		}
	}

	public function apiMcyCategoryUpdate(Request $request)
	{
		$response = new ApiResponse;
		$name = $request->input('name');
		$admin_id = $request->session()->get('admin_id');
		$category_id = intval($request->input('category_id'));
		$model = 'App\Model\Category';
		if ($admin_id)
		{
			$search = array(
				'user_id' => $admin_id,
				'category_id' => $category_id,
				);
			$data = array(
				'name' => $request->input('name'),
				'category_id' => $request->input('category_id'),
				);
			$response->search = $search;
			$result = $response->update($model,$search,$data);
			if ($response->ret == 0)
			{
				return $response->toJson();
			}else{
				return $response->reply(2,'修改失败');
			}
		}else{
			return $response->reply(2,'请重新登录');
		}
	}

	public function apiMcyCategoryDelete(Request $request)
	{
		$category_id = intval($request->input('category_id'));
		$response =  new ApiResponse;
		$admin_id = $request->session()->get('admin_id');
		$data = array(
			'category_id'=>$category_id,
			'user_id'=>$admin_id
			);
		$model = 'App\Model\Category';
		$response->delete($model,$data);
		if ($response->ret == 0)
		{
			$response->category_id = $category_id;
			return $response->toJson();
		}else{
			return $response->reply(1,'没有权限或者对象跑了');
		}
	}

}
 ?>