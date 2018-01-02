<?php 
namespace App\Http\Controllers\Mcy;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Response;
use App\Tools;
use App\Tools\MyLog\SiteLog;
use App\Model\News;
use App\Model\TwitterUser;
use App\Model\TwitterNews;
use App\Model\TwitterPicture;
use App\Model\McyUser;
use Twitter;
/**
* 梦苍源 推特新闻集中器
*/
class McyTwitterController extends Controller
{
	public function __construct(Request $request)
	{
		SiteLog::info("登录ip： ".$request->ip()." 登录路径： ".$request->url());
	}

	public function twitters(Request $request)
	{
		$url = 'https://www.google.com';
		$data = Tools::get($url);
		dd($data);
		try
		{
			$response = Twitter::getUserTimeline(['count' => 20, 'format' => 'array']);
		}
		catch (Exception $e)
		{
			dd(Twitter::logs());
		}

	}

}

 ?>