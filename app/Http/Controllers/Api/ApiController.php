<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\News;
use App\Tools;
use App\Response;
use QL\QueryList;
use App\ApiResponse;

class ApiController extends Controller
{
	private $ali_code = '9e9a71290a1048d08cfc3db37c501098';
	private $ali_appkey = '23752144';
	private $ali_secret = '685758ad32c7f8b493678f496095fcea';
	public function apiGetNews(Request $request)
	{
        $response = new Response;
		$newstype = $request->input('newstype','top');
		#$newstype = $request->subtype;
		$news = News::where('is_delete',0)->where('newstype',$newstype)->orderby('date','desc')->paginate(10);
		if (count($news) > 0)
		{
			$date = date("Y-m-d H:i:s",strtotime("-5 min"));
			// $date = date("Y-m-d H:i:s");
			if ($news->first()->created_at > $date)
			{
				// 拉取数据库资料
				// echo "bad";
			}else{
				// 更新最新新闻
				$news = $this->dongfangwang($newstype);
				$news = News::where('is_delete',0)->where('newstype',$newstype)->orderby('date','desc')->paginate(10);
			}
		}else{
			$news = $this->dongfangwang($newstype);
		}
        #$response->news = json_encode($news,JSON_UNESCAPED_UNICODE);
        $response->news = $news;
        return $response->reply(0,'');
	}
	public function apiGetNewDetail(Request $request)
	{
		$response = new ApiResponse;
		$new_id = $request->new_id;
		if (is_numeric($new_id))
		{
			$new = News::where('new_id',$new_id)->where('is_delete',0)->first();
			if ($new)
			{
				if ($new->content == '')
				{
					$url = $new->source_url;
					$response->url = $url;
					//采集规则
					$rules = array(
					    //文章标题
					    'title' => ['.title','text'],
					    'content' => ['.J-article-content','html'],
					    //文章作者名
					    'author' => ['.article-src-time','text']
					);
					//列表选择器
					$rang = '.J-article';
					//采集
					$data = \QL\QueryList::Query($url,$rules,$rang)->data;
					if ($data)
					{
						$new->content = $data[0]['content'];
						$new->save();
						$d = new \StdClass;
						$d->title = $data[0]['title'];
						$d->content = $data[0]['content'];
						$d->author = $data[0]['author'];
						$response->new = $d;
						return $response->reply(0,'ok');
					}else{
						return $response->reply(3,'文章已经被删除');
					}
				}else{
					$data = new \StdClass;
					$data->title = $new->title;
					$data->content = $new->content;
					$data->author = $new->author_name.' '.$new->date;
					$response->new = $data;
					return $response->reply(0,'ok');
				}
				
			}else{
				return $response->reply(2,'找不到这篇新闻');
			}
		}else{
			return $response->reply(1,'参数错误');
		}
	}
	private function dongfangwang($newstype)
	{
		$url = 'http://toutiao-ali.juheapi.com/toutiao/index?type='.$newstype;
		$source = '东方网';
		$header = array();
		array_push($header, "Authorization:APPCODE " . $this->ali_code);
		$data = json_decode(Tools::get($url,$header));
		if ($data->status == 0)
		{
			// 写入数据库
			$result = json_decode($data->response)->result;
			$news = $result->data;
			// $news = $data->response['result'];
			foreach($news as $new)
			{
				if (News::where('uniquekey',$new->uniquekey)->where('is_delete',0)->count() > 0)
				{

				}else{
					$n = new News;
					$n->uniquekey = $new->uniquekey;
					$n->title = $new->title;
					$n->thumb_pic = $new->thumbnail_pic_s;
					$n->source_url = $new->url;
					$n->source = $source;
					$n->date = $new->date;
					$n->category = $new->category;
					$n->author_name = $new->author_name;
					$n->newstype = $newstype;
					$n->save();
				}
			}
		}else{
			$news = '';
		}
		return $news;
	}
    public function apiGetNewContent(Request $request)
    {
        $new_id = $request->input('new_id');
        $new = News::where('new_id',$new_id)->where('is_delete',0)->first();
    }

}
