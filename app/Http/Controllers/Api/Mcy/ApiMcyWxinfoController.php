<?php 
namespace App\Http\Controllers\Api\Mcy;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Tools;
use App\ApiResponse;
use App\Model\McyWxInfo;
use App\Model\ArticleTag;
use App\Model\Tag;
use App\Model\Category;
use App\Model\ArticleCategory;

/**
* ApiMcyWxInfoController class
*/
class ApiMcyWxInfoController extends Controller
{

	public function apiMcyWxInfoUpdate(Request $request)
	{
		$response = new ApiResponse;
		parse_str($request->input('data') , $data);


		$model = 'App\Model\McyWxInfo';
		$admin_id = $request->session()->get('admin_id');
		if ($data['wxinfo_id'] !== '')
		{
			$search = array('user_id'=>$admin_id,'wxinfo_id'=>$data['wxinfo_id']);
			$result = $response->update($model,$search,$data);
			return $result;
		}else{
			unset($data['wxinfo_id']);
			$data['user_id'] = $admin_id;
			$result = $response->create($model,$data);
			return $result;
		}

	}
	public function apiMcyActivityUpdate(Request $request)
	{
		$response = new ApiResponse;
		parse_str($request->input('data') , $data);
		$model = 'App\Model\McyActivity';
		$admin_id = $request->session()->get('admin_id');
		if ($data['activity_id'] !== '')
		{
			$search = array('user_id'=>$admin_id,'activity_id'=>$data['activity_id']);
			$result = $response->update($model,$search,$data);
			return $result;
		}else{
			unset($data['activity_id']);
			$data['user_id'] = $admin_id;
			$result = $response->create($model,$data);
			return $result;
		}
	}

	public function apiMcyWxInfoDelete(Request $request)
	{
		$article_id = $request->input('article_id');
		$response =  new ApiResponse;
		$admin_id = $request->session()->get('admin_id');
		$data = array(
			'article_id'=>$article_id,
			'user_id'=>$admin_id
			);
		$model = 'App\Model\McySite';
		$response->delete($model,$data);
		if ($response->ret == 0)
		{
			$this->deleteTag($article_id);
			$this->deleteCategory($article_id);
			return $response->toJson();
		}else{
			return $response->reply(1,'没有权限或者对象跑了');
		}
	}


}
 ?>