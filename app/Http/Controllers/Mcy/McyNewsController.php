<?php 
namespace App\Http\Controllers\Mcy;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Response;
use App\Tools;
use App\Tools\MyLog\SiteLog;
use App\Model\News;

/**
* 梦苍源 新闻中心
*/
class McyNewsController extends Controller
{
	private $ali_code = '9e9a71290a1048d08cfc3db37c501098';
	private $ali_appkey = '23752144';
	private $ali_secret = '685758ad32c7f8b493678f496095fcea';

	public function __construct(Request $request)
	{
		SiteLog::info("登录ip： ".$request->ip()." 登录路径： ".$request->url());
	}
	public function news($type='newslist',$subtype='top',Request $request)
	{
		// $type = $request->input('type','');
		$request->subtype = $subtype;
		switch ($type) {
			case 'newslist':
				return $this->newslist($request);
				break;
			case 'newsdetail':
				return $this->newsdetail($request);
				break;
			default:
				return $this->newslist($request);
				break;
		}
		return "";
	}

	public function newslist(Request $request)
	{
		// $newstype = $request->input('newstype','top');
		$newstype = $request->subtype;
		$news = News::where('is_delete',0)->where('newstype',$newstype)->orderby('date','desc')->paginate(100);
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
				$news = News::where('is_delete',0)->where('newstype',$newstype)->orderby('date','desc')->paginate(100);
			}
			
		}else{
			$news = $this->dongfangwang($newstype);
		}

		return view('mcy.newslist',compact('news'));
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

}

 ?>