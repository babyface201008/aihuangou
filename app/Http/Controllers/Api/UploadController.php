<?php 
namespace App\Http\Controllers\Api ;
/**
* The UploadController  class Controller
*/
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Response;
use App\ApiResponse;
use App\Tools;
use Images;
use Excel;
use Validator;
use Storage;
use File;

class UploadController extends Controller
{
	public function imagesUpload(Request $request)
	{
		$response = new Response;
		$validator = Validator::make($request->all(), [
			'welkin' => 'required|mimes:jpeg,jpg,png,ico|max:20480',
			]);
		if ($validator->fails())
		{
			return $response->reply(2,'请上传正确的图片格式，且照片不能超过20M');
		}
		$extension = $request->file('welkin')->getClientOriginalExtension();
		$date = date('Y_m_d');
		$name = Tools::UUID().'.'.$extension;
		$path = $request->file('welkin')->storePubliclyAs($date,$name,'public');
		$url = '/storage/'.$path;
		$response->uri = $url;
		$response->request = $request->all();
		return $response->reply(0,'ok');
	}
	public function mkUploadImages(Request $request)
	{
		$response = new ApiResponse;
		$validator = Validator::make($request->all(), [
			'editormd-image-file' => 'required|mimes:jpeg,jpg,png,ico|max:20480',
		]);
		if ($validator->fails())
		{
			$response->success = 0;
			$response->message = '请上传正确的图片格式，且照片不能超过20M';
			return $response->toJson();
		}
		$extension = $request->file('editormd-image-file')->getClientOriginalExtension();
		$date = date('Y_m_d');
		$name = Tools::UUID().'.'.$extension;
		$local_path = $date;
		// $path = $request->file('editormd-image-file')->storePubliclyAs($date,$name,'public');
		$path = Storage::disk('oss')->putFile($local_path,$request->file('editormd-image-file'), ['mimetype' => 'image/'.$extension.'']);
		// $url = '/storage/'.$path;
		$response->file_name = $request->file('editormd-image-file');
		$url = Storage::disk('oss')->signedDownloadUrl($path, 3600, 'oss-cn-hangzhou.aliyuncs.com', false);
		$response->success = 1;
		$response->path = $path;
		$response->message = '上传成功';
		$response->url = $url;
		return $response->toJson();
	}
	public function mkUploadImagesbak(Request $request)
	{
		$response = new ApiResponse;
		$validator = Validator::make($request->all(), [
			'editormd-image-file' => 'required|mimes:jpeg,jpg,png,ico|max:20480',
		]);
		if ($validator->fails())
		{
			$response->success = 0;
			$response->message = '请上传正确的图片格式，且照片不能超过20M';
			return $response->toJson();
		}
		$extension = $request->file('editormd-image-file')->getClientOriginalExtension();
		$date = date('Y_m_d');
		$name = Tools::UUID().'.'.$extension;
		$path = $request->file('editormd-image-file')->storePubliclyAs($date,$name,'public');
		$url = '/storage/'.$path;
		$response->success = 1;
		$response->message = '上传成功';
		$response->url = $request->root().$url;
		return $response->toJson();
	}
	public function aliImageUpload(Request $request)
	{
		
	}

	public function file(Request $request)
	{
		$response = new Response;
		return $response->reply(2,'bad');
	}


	public function excel(Request $request)
	{
		$response = new Response;
		return $response->reply(3,'bad');
	}
}
 ?>