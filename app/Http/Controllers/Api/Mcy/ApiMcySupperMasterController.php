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
class ApiMcySupperMasterController extends Controller
{


    public function apiSuperMasterOk(Request $request)
    {
        $response = new ApiResponse;
        $admin_id = $request->session()->get('admin_id');
        if ($admin_id)
        {

        }else{
            return $response->reply(3,'请重新登录');
        }
        $super_id = $request->input('super_id');
        $response->$super_id = $super_id;
        $model = 'App\Model\McySupermasterApply';
        $search = array(
            'super_id' => $super_id,
            'is_delete' => 0,
            'status' => 1,
        );
        $data = array(
            'status'=>2,
        );
        $result = $response->update($model,$search,$data);
        return $response->toJson();
    }

    public function apiSuperMasterNO(Request $request)
    {
        $response = new ApiResponse;
        $admin_id = $request->session()->get('admin_id');
        if ($admin_id)
        {

        }else{
            return $response->reply(3,'请重新登录');
        }
        $super_id = $request->input('super_id');
        $response->$super_id = $super_id;
        $model = 'App\Model\McySupermasterApply';
        $search = array(
            'super_id' => $super_id,
            'is_delete' => 0,
            'status' => 1,
        );
        $data = array(
            'status'=>3,
        );
        $result = $response->update($model,$search,$data);
        return $response->toJson();
    }
}
 ?>