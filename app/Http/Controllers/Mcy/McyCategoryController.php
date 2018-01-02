<?php

namespace App\Http\Controllers\Mcy;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\AiHuanGouUser;
use App\Model\Article;
use App\Model\Tag;
use App\Model\Category;

class McyCategoryController extends Controller
{

	public function categorys(Request $request)
	{

		$admin_id = $request->session()->get('admin_id');
		$admin = AiHuanGouUser::find($admin_id);
		$starttime = empty($request->input('starttime',''))?'1971-1-1':$request->input('starttime').' 00:00:00';
		$endtime = empty($request->input('endtime',''))?'2099-12-31':$request->input('endtime').' 23:59:59';
		$searchtext = $request->input('searchtext','');
		if ($searchtext !== '')
		{
			$categorys  = Category::where('category.is_delete',0)
							->where('name','like','%'.$searchtext.'%')->whereBetween('category.created_at',[$starttime,$endtime])
							->join('welkin_user','welkin_user.user_id','=','category.user_id','left')
							->where('category.user_id',$admin_id)
							->select('category.user_id','category.category_id','category.name','category.count','welkin_user.nickname','welkin_user.username','category.created_at')
							->paginate(20);
		}else{
			$categorys  = Category::where('category.is_delete',0)
							->join('welkin_user','welkin_user.user_id','=','category.user_id','left')
							->whereBetween('category.created_at',[$starttime,$endtime])
							->where('category.user_id',$admin_id)
							->select('category.user_id','category.category_id','category.name','category.count','welkin_user.nickname','welkin_user.username','category.created_at')
							->paginate(20);
		}
		return view('welkin.mcy.category',compact('categorys','searchtext','starttime','endtime'));
	}

	public function categoryCreate(Request $request)
	{
		$admin_id = $request->session()->get('admin_id');
		$admin = AiHuanGouUser::where('user_id',$admin_id)->select('username','nickname','avator_img','created_at')->first();
		return view('welkin.mcy.category_create',compact('admin'));
	}

	public function categoryUpdate(Request $request)
	{
		$admin_id = $request->session()->get('admin_id');
		// $admin = AiHuanGouUser::where('user_id',$admin_id)->select('username','nickname','avator_img','created_at')->first();
		$category_id = intval($request->input('category_id'));
		$category = Category::where('user_id',$admin_id)->where('category_id',$category_id)->first();
		return view('welkin.mcy.category_update',compact('admin','category'));
	}

}
