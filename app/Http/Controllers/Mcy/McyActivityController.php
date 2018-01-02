<?php

namespace App\Http\Controllers\Mcy;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\AiHuanGouUser;
use App\Model\Article;
use App\Model\Tag;
use App\Model\Category;
use App\Model\McyActivity;
class McyActivityController extends Controller
{
	public function activity(Request $request)
	{
		$admin_id = $request->session()->get('admin_id');
		$activity = McyActivity::where('is_delete',0)->where('user_id',$admin_id)->first();
		return view('welkin.mcy.activity',compact('activity'));
	}
}
