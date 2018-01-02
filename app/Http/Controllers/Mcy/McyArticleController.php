<?php

namespace App\Http\Controllers\Mcy;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\AiHuanGouUser;
use App\Model\Article;
use App\Model\Tag;
use App\Model\Category;

class McyArticleController extends Controller
{

	public function articles(Request $request)
	{
		$admin_id = $request->session()->get('admin_id');
		$admin = AiHuanGouUser::find($admin_id);
		$articles  = Article::where('is_delete',0)
							->where('user_id',$admin_id)
							->select('article_id','user_id','tag_names','category_names','title','type','source','created_at')
							->paginate(20);
		return view('welkin.mcy.article',compact('articles'));
	}


	public function articleCreate(Request $request)
	{
		$categorys = Category::where('is_delete',0)->get();
		$tags = Tag::where('is_delete',0)->get();
		return view("welkin.mcy.article_create",compact('tags','categorys'));
	}

	public function articleUpdate(Request $request)
	{
		$article_id = $request->input('article_id');
		$admin_id = $request->session()->get('admin_id');
		$article  = Article::where('is_delete',0)->where('user_id',$admin_id)->where('article_id',$article_id)->first();
		if ($article)
		{
			$categorys = Category::where('is_delete',0)->get();
			$tags = Tag::where('is_delete',0)->get();
			$article->categorys = explode(',',$article->category_ids);
			$article->tags = explode(',',$article->tag_ids);
			return view('welkin.mcy.article_update',compact('tags','categorys','article'));
		}else{
			return redirect('/welkin/mcy/article');
		}

	}
	public function mdArticleCreate(Request $request)
	{
		$categorys = Category::where('is_delete',0)->get();
		$tags = Tag::where('is_delete',0)->get();
		return view("welkin.mcy.article_md_create",compact('tags','categorys'));
	}

	public function mdArticleUpdate(Request $request)
	{
		$article_id = $request->input('article_id');
		$admin_id = $request->session()->get('admin_id');
		$article  = Article::where('is_delete',0)->where('user_id',$admin_id)->where('article_id',$article_id)->first();
		if ($article)
		{
			$categorys = Category::where('is_delete',0)->get();
			$tags = Tag::where('is_delete',0)->get();
			$article->categorys = explode(',',$article->category_ids);
			$article->tags = explode(',',$article->tag_ids);
			dd($article);
			return view('welkin.mcy.article_md_update',compact('tags','categorys','article'));
		}else{
			return redirect('/welkin//mcy/article');
		}

	}


}
