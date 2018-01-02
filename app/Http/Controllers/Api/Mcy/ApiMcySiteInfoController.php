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
* ApiMcySiteInfoController class
*/
class ApiMcySiteInfoController extends Controller
{

	public function apiMcySiteInfoUpdate(Request $request)
	{
		$response = new ApiResponse;
		parse_str($request->input('data') , $data);

		if($data['rage_duihuan']==0 && $data['rage_duihuan_pid']!=0){
            return $response->reply(1,'兑换回扣为0时，换上一级佣金也应该是0');
        }
        //上一级兑换获得的佣金不能大于兑换的回扣
        if($data['rage_duihuan']!=0 && $data['rage_duihuan']<=$data['rage_duihuan_pid']){
            return $response->reply(1,'兑换上一级佣金比例应该小于兑换回扣比例');
        }

		$model = 'App\Model\McySite';
		$admin_id = $request->session()->get('admin_id');
		$site_favicon = $request->input('site_favicon');
		$site_m_logo  = $request->input('site_m_logo');
		$site_pc_logo  = $request->input('site_pc_logo');
        $service_wexin = $request->input('service_wexin');
		$data['site_favicon'] = $site_favicon;
		$data['site_m_logo'] = $site_m_logo;
		$data['site_pc_logo'] = $site_pc_logo;
        $data['service_wexin'] = $service_wexin;
		if ($data['site_id'] !== '')
		{
			$search = array('user_id'=>$admin_id,'site_id'=>$data['site_id']);
			$result = $response->update($model,$search,$data);
			return $result;
		}else{
			unset($data['site_id']);
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