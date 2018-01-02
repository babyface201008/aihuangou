<?php 
namespace App\Http\Controllers\Api;

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
class ApiTagController extends Controller
{

	public function apiTagCreate(Request $request)
	{
		$response = new ApiResponse;
		$tag_name = $request->input('tag_name');
		$admin_id = $request->session()->get('admin_id');
		$model = 'App\Model\Tag';
		if ($admin_id)
		{
			$data = array(
				'tag_name' => $tag_name?$tag_name:'',
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

	public function apiTagUpdate(Request $request)
	{
		$response = new ApiResponse;
		$tag_name = $request->input('tag_name');
		$admin_id = $request->session()->get('admin_id');
		$tag_id = intval($request->input('tag_id'));
		$model = 'App\Model\Tag';
		if ($admin_id)
		{
			$search = array(
				'user_id' => $admin_id,
				'tag_id' => $tag_id,
				);
			$data = array(
				'tag_name' => $request->input('tag_name'),
				'tag_id' => $request->input('tag_id'),
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

	public function apiTagDelete(Request $request)
	{
		$tag_id = intval($request->input('tag_id'));
		$response =  new ApiResponse;
		$admin_id = $request->session()->get('admin_id');
		$data = array(
			'tag_id'=>$tag_id,
			'user_id'=>$admin_id
			);
		$model = 'App\Model\Tag';
		$response->delete($model,$data);
		if ($response->ret == 0)
		{
			return $response->toJson();
		}else{
			return $response->reply(1,'没有权限或者对象跑了');
		}
	}

}
 ?>