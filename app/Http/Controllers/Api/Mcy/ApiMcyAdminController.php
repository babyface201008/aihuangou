<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools;
use App\Response;
use App\ApiResponse;

class ApiMcyAdminController extends Controller
{
	public function apiCheckLogin(Request $request)
	{
		$response = new ApiResponse;
		$response->data = "welkin";
		$response->post = $request->input();
		return $response->reply(0,'ok');
	}
}
