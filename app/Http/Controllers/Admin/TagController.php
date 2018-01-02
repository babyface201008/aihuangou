<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\AiHuanGouUser;
use App\Model\Article;
use App\Model\Tag;
use App\Model\Category;

class TagController extends Controller
{

	public function tag(Request $request)
	{
		$admin_id = $request->session()->get('admin_id');
		$admin = AiHuanGouUser::find($admin_id);
		$starttime = empty($request->input('starttime',''))?'1971-1-1':$request->input('starttime').' 00:00:00';
		$endtime = empty($request->input('endtime',''))?'2099-12-31':$request->input('endtime').' 23:59:59';
		$searchtext = $request->input('searchtext','');
		if ($searchtext !== '')
		{
			$tags  = Tag::where('tag.is_delete',0)
							->where('tag_name','like','%'.$searchtext.'%')->whereBetween('tag.created_at',[$starttime,$endtime])
							->join('welkin_user','welkin_user.user_id','=','tag.user_id','left')
							->where('tag.user_id',$admin_id)
							->select('tag.user_id','tag.tag_id','tag.tag_name','welkin_user.nickname','welkin_user.username','tag.created_at')
							->paginate(20);
		}else{
			$tags  = Tag::where('tag.is_delete',0)
							->join('welkin_user','welkin_user.user_id','=','tag.user_id','left')
							->whereBetween('tag.created_at',[$starttime,$endtime])
							->where('tag.user_id',$admin_id)
							->select('tag.user_id','tag.tag_id','tag.tag_name','welkin_user.nickname','welkin_user.username','tag.created_at')
							->paginate(20);
		}
		return view('welkin.tag',compact('tags','searchtext','starttime','endtime'));
	}


	public function tagCreate(Request $request)
	{
		$admin_id = $request->session()->get('admin_id');
		$admin = AiHuanGouUser::where('user_id',$admin_id)->select('username','nickname','avator_img','created_at')->first();
		return view('welkin.tag_create',compact('admin'));
	}

	public function tagUpdate(Request $request)
	{
		$admin_id = $request->session()->get('admin_id');
		$admin = AiHuanGouUser::where('user_id',$admin_id)->select('username','nickname','avator_img','created_at')->first();
		$tag_id = intval($request->input('tag_id'));
		$tag = Tag::where('user_id',$admin_id)->where('tag_id',$tag_id)->first();
		return view('welkin.tag_update',compact('admin','tag'));
	}

}
