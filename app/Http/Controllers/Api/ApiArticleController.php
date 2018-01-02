<?php 
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Tools;
use App\ApiResponse;
use App\Model\Article;
use App\Model\ArticleTag;
use App\Model\Tag;
use App\Model\Category;
use App\Model\ArticleCategory;

/**
* ArticleController class
*/
class ApiArticleController extends Controller
{

	public function apiArticleCreate(Request $request)
	{
		$response = new ApiResponse;
		$title = $request->input('title');
		$content = $request->input('content');
		$type = $request->input('type');
		$tag_ids = $request->input('tag_ids');
		$tag_names = $request->input('tag_names');
		$category_ids = $request->input('category_ids');
		$category_names = $request->input('category_names');
		$admin_id = $request->session()->get('admin_id');
		$model = 'App\Model\Article';
		if ($admin_id)
		{
			$data = array(
				'title' => $title?$title:'',
				'content' => $content?$content:'',
				'tag_ids' => $tag_ids?$tag_ids:'',
				'tag_names' => $tag_names?$tag_names:'',
				'type' => $type?$type:0,
				'category_ids' => $category_ids?$category_ids:'',
				'category_names' => $category_names?$category_names:'',
				'user_id' => $admin_id?$admin_id:'',
				);
			$result = $response->create($model,$data);
			if ($response->ret == 0)
			{
				$article_id =$response->obj->article_id;
				$sign_tag = $this->createTag($tag_ids,$article_id);
				$sign_category = $this->createCategory($category_ids,$article_id);
				if ($sign_tag && $sign_category)
				{
					return $response->toJson();
				}else{
					$response->obj->is_delete = 1;
					$response->obj->save();
					$this->deleteTag($article_id);
					$this->deleteCategory($article_id);
					return $response->reply(3,'标签，种类添加失败');
				}
			}else{
				return $response->reply(2,'添加失败');
			}
		}else{
			return $response->reply(2,'请重新登录');
		}
	}

	public function apiArticleUpdate(Request $request)
	{
		$response = new ApiResponse;
		$title = $request->input('title');
		$content = $request->input('content');
		$article_id = $request->input('article_id');
		$tag_ids = $request->input('tag_ids');
		$tag_names = $request->input('tag_names');
		$category_ids = $request->input('category_ids');
		$category_names = $request->input('category_names');
		$admin_id = $request->session()->get('admin_id');
		$model = 'App\Model\Article';
		$search = array(
			'user_id' => $admin_id,
			'article_id' => $article_id,
			);
		$data = array(
			'title' => $request->input('title'),
			'content' => $request->input('content'),
			'tag_ids' => $request->input('tag_ids'),
			'tag_names' => $request->input('tag_names'),
			'category_ids' => $request->input('category_ids'),
			'category_names' => $request->input('category_names'),
			);
		$response->search = $search;
		$result = $response->update($model,$search,$data);
		if ($response->ret == 0)
		{
			$article_id =$response->obj->article_id;

			$this->deleteTag($article_id);
			$this->deleteCategory($article_id);

			$sign_tag = $this->createTag($tag_ids,$article_id);
			$sign_category = $this->createCategory($category_ids,$article_id);
			if ($sign_tag && $sign_category)
			{
				return $response->toJson();
			}else{
				$response->obj->is_delete = 1;
				$response->obj->save();
				$this->deleteTag($article_id);
				$this->deleteCategory($article_id);
				return $response->reply(3,'标签，种类添加失败');
			}
		}else{
			return $response->reply(2,'修改失败');
		}
	}




	public function apiArticleDelete(Request $request)
	{
		$article_id = $request->input('article_id');
		$response =  new ApiResponse;
		$admin_id = $request->session()->get('admin_id');
		$data = array(
			'article_id'=>$article_id,
			'user_id'=>$admin_id
			);
		$model = 'App\Model\Article';
		$response->delete($model,$data);
		if ($response->ret == 0)
		{
			$this->deleteTag($article_id);
			$this->deleteCategory($article_id);
			return $response->toJson();
		}else{
			return $response->reply(1,'没有权限或者对象跑了');
		}
	}

	private function createTag($tag_ids,$article_id)
	{
		$tags = explode(",",$tag_ids);
		if ($tag_ids == '') { return 1;}else{};
		$sign = 0;
		foreach($tags as $tag)
		{
			$taglist = new ArticleTag;
			$taglist->article_id = $article_id;
			$taglist->tag_id = $tag;
			$sign = $taglist->save()?1:0;
		}
		return !$sign?0:1;
	}
	private function createCategory($category_ids,$article_id)
	{
		$categorys = explode(",",$category_ids);
		if ($category_ids == '') { return 1;}else{};
		$sign = 0;
		foreach($categorys as $category)
		{
			$categorylist = new ArticleCategory;
			$categorylist->article_id = $article_id;
			$categorylist->category_id = $category;
			$sign = $categorylist->save()?1:0;
		}
		return !$sign?0:1;
	}
	private function deleteTag($article_id)
	{
		ArticleTag::where('article_id',$article_id)->delete();
	}
	private function deleteCategory($article_id)
	{
		ArticleCategory::where('article_id',$article_id)->delete();
	}
}
 ?>