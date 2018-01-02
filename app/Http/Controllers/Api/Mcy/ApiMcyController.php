<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\News;
use App\Tools;
use App\Response;
use App\ApiResponse;
use App\Model\Mcy\LoopImg;
use App\Model\Mcy\HomePage;

class ApiMcyController extends Controller
{
	public function apiGetRiChangNav()
	{
		$response = new ApiResponse;
		$rdata = new \StdClass;
		$data = array();
		$data[] = array(
			'title' => '趣闻',
			'imgurl'=> '/images/test.jpg',
			'href' => '/news'
			);
		$data[] = array(
			'title' => '11区',
			'imgurl'=> '/images/test.jpg',
			'href' => '/news'
			);
		$data[] = array(
			'title' => '漫图',
			'imgurl'=> '/images/test.jpg',
			'href' => '/news'
			);
		$data[] = array(
			'title' => '漫展',
			'imgurl'=> '/images/test.jpg',
			'href' => '/news'
			);
		$data[] = array(
			'title' => '日语',
			'imgurl'=> '/images/test.jpg',
			'href' => '/news'
			);
		$data[] = array(
			'title' => '德语',
			'imgurl'=> '/images/test.jpg',
			'href' => '/news'
			);
		$data[] = array(
			'title' => '英语',
			'imgurl'=> '/images/test.jpg',
			'href' => '/news'
			);
		$data[] = array(
			'title' => '学习资料',
			'imgurl'=> '/images/test.jpg',
			'href' => '/news'
			);
		$data[] = array(
			'title' => '周边日常',
			'imgurl'=> '/images/test.jpg',
			'href' => '/news'
			);
		$data[] = array(
			'title' => '小说',
			'imgurl'=> '/images/test.jpg',
			'href' => '/news'
			);
		$data[] = array(
			'title' => '本子',
			'imgurl'=> '/images/test.jpg',
			'href' => '/news'
			);
		$data[] = array(
			'title' => '同人',
			'imgurl'=> '/images/test.jpg',
			'href' => '/news'
			);
		$data[] = array(
			'title' => '梦友1',
			'imgurl'=> '/images/test.jpg',
			'href' => '/news'
			);

		foreach($data as $key => $value)
		{
			$obj = "t".($key+1);
			$rdata->$obj = $value;
		}
		$response->data = $rdata;
		return $response->reply(0,'');
	}

	public function ApiGetLoopImg(Request $request)
	{
		$type = $request->input('type');
		$site_id = $request->input('site_id');

	}

	public function apiCheckLogin(Request $request)
	{
		$response = new ApiResponse;
		$response->data = "welkin";
		$response->post = $request->input();
		return $response->reply(0,'ok');
	}
}
