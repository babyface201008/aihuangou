<?php 
namespace App\Http\Controllers\Api\Mcy;
/**
* The QY class Controller
*/
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tools;
use App\Tools\UtilUUID;
use App\Response;
use App\ApiResponse;
use App\Model\McySite;
use App\Model\McyUser;
use Image;
use Excel;
use Validator;
use Storage;
class ApiMcyUploadController extends Controller
{
	public $exceloutput;
	/* 阿里云存放 */
	public function imagesUpload(Request $request)
	{
		$response = new ApiResponse;
		$validator = Validator::make($request->all(), [
			'welkin' => 'required|mimes:jpeg,jpg,png,ico|max:20480',
		]);
		if ($validator->fails())
		{
			return $response->reply(3,'请上传正确的图片格式，且照片不能超过20M');
		}
		$extension = $request->file('welkin')->getClientOriginalExtension();
		$date = date('Y_m_d');
		$name = Tools::UUID().'.'.$extension;
		$local_path = $date;
		$path = Storage::disk('oss')->putFile($local_path,$request->file('welkin'), ['mimetype' => 'image/'.$extension.'']);
		$response->file_name = $request->file('welkin');
		$url = Storage::disk('oss')->signedDownloadUrl($path, 3600, 'oss-cn-hangzhou.aliyuncs.com', false);
		$response->uri = $url;
		$response->url = $url;
		return $response->reply(0,'上传成功');
	}

	/* 本地存放 */
	public function imagesUpload_local(Request $request)
	{
		$response = new Response;
		$response->input = $request->file();
		$images = $request->file('welkin')->getRealPath();
		$response->images = $images;
		$path = public_path().'/upload';
		$name = Tools::UUID();
		if (Tools::mkdir($path))
		{
			// Image::make($images)->resize(120,120)->save($path.'/'.$name.'.jpg');
			Image::make($images)->save($path.'/'.$name.'.jpg');
			$response->uri = '/upload/'.$name.'.jpg';
			return $response->reply(0,'ok');
		}else{
			return $response->reply(4,'没有权限写入');
		}
	}		
	public function excelUpload(Request $request)
	{
		$response = new Response;
		$response->input = $request->file();
		$response->excel = $request->file('welkin')->getRealPath();
		$response->sheetnames = Excel::load($response->excel)->getSheetNames();
		Excel::load($response->excel,function($reader){
			$this->exceloutput = $reader->get();
		});

		$response->output = $this->exceloutput;
		$array = $response->output;
		foreach($response->output as $key => $value)
		{
			// $response->o[$key] = collect($response->output)->implode('名称',',');
			if ($value == ''){ }else{
				$addr = array('广东省揭阳市','广东省潮州市','广东省汕头市');
				// for ($i=0; $i < count($array); $i++) { 
					$admin_id = \Session::get('admin_id');
					$site = McySite::where('is_delete',0)->where('user_id',$admin_id)->first();
					$mcy_user = new McyUser;
					$mcy_user->is_robot = 1;
					$mcy_user->user_id = $admin_id;
					$mcy_user->nickname =   $value[0];
					$mcy_user->username =  $value[0];
					$mcy_user->mobile =  Tools::getRandomMobile();
					$mcy_user->email =  Tools::getRandomEmail();
					$mcy_user->ip =  Tools::getRandomIP();
					$mcy_user->ip_addr = $addr[mt_rand(0,2)];
					$mcy_user->avator_img = '/chimg1.png';
					$mcy_user->sex = mt_rand(0,2);
					$mcy_user->money = mt_rand(0,200);
					$mcy_user->score  = 0;
					$mcy_user->jingyan = 0;
					$mcy_user->is_slave = 0;
					$mcy_user->master_id = 0;
					$mcy_user->site_id = $site->site_id;
					$mcy_user->slave_money = 0;
					$mcy_user->save();
					// @$response->user[$key] = $mcy_user;
				// }
			}
		}

		return $response->reply(0,'ok');
	}


    /* 会员头像上传本地 */
    public function avatorimgUpload_local(Request $request)
    {
        $response = new Response;
        $response->input = $request->file();
        $images = $request->file('welkin')->getRealPath();
        $response->images = $images;
        $path = public_path().'/upload/avatorimg/';
        $name = Tools::UUID();
        if (Tools::mkdir($path))
        {
            // Image::make($images)->resize(120,120)->save($path.'/'.$name.'.jpg');
            Image::make($images)->save($path.'/'.$name.'.jpg');
            $response->uri = '/upload/avatorimg/'.$name.'.jpg';
            return $response->reply(0,'ok');
        }else{
            return $response->reply(4,'没有权限写入');
        }
    }
}
?>