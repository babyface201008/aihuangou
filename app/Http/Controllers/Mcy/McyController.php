<?php 
namespace App\Http\Controllers\Mcy;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Response;
use App\Tools;
use App\Tools\MyLog\SiteLog;
use App\Model\McyUser;
/**
* 梦苍源 主页控制
*/
class McyController extends Controller
{

	public function __construct(Request $request)
	{
		SiteLog::info("登录ip： ".$request->ip()." 登录路径： ".$request->url());
	}


	public function index(Request $request)
	{
		return view('mcy.index');
	}

	public function mindex(Request $request)
	{
		return view('mcy.mindex');
	}


	public function htmldemo(Request $request)
	{
		$demo_id = $request->input('demo_id','');
		if ($demo_id == '') return view('mcy.demo.lists');
		return view("mcy.demo.$demo_id");
	}



}

 ?>