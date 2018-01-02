<?php

namespace App\Http\Controllers\Api\Mcy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools;
use App\Response;
use App\ApiResponse;
use App\Model\McyUser;
use App\Model\McyProduct;
use App\Model\McyPay;
use App\Model\McySite;
use App\Model\McyAutoMan;

class ApiMcyAutoManController extends Controller
{
    public function apiMcyAutoManUpdate(Request $request)
    {
        $response = new ApiResponse;
        parse_str($request->input('data') , $data);
        $admin_id = $request->session()->get('admin_id');
        if ($admin_id)
        {
          /* 判断测试是否存在　*/
          $automan = McyAutoMan::where('user_id',$admin_id)->where('is_delete',0)->first();
          $model = 'App\Model\McyAutoMan';
          $d = array();
          if ($automan)
          {
            $search = array(
              'user_id'=>$admin_id
              );
            $d['test_time'] = $data['test_time'];
            $d['category_id'] = @$data['category_id'];
            $d['product_ids'] = @$data['product_ids'];
            $result = $response->update($model,$search,$d);
            return $response->toJson();
          }else{
            $d['user_id'] = $admin_id;
            $d['test_time'] = $data['test_time'];
            $d['category_id'] = @$data['category_id'];
            $d['product_ids'] = @$data['product_ids'];
            $result = $response->create($model,$d);
            return $response->toJson();
          }
        }else{
          return $response->reply(2,'会话过期，请重新登录');
        }
     
    }
    public function apiMcyAutoManDelete(Request $request)
    {
      $response = new ApiResponse;
      $admin_id = $request->session()->get('admin_id');
      if ($admin_id) 
      {
        $AutoMan_id = $request->input('AutoMan_id');
        $model = 'App\Model\McyPay';
        $data = array();
        $data['AutoMan_id'] = $AutoMan_id;
        $data['user_id'] = $admin_id;
        $response->AutoMan_id = $AutoMan_id;
        $request = $response->delete($model,$data);
        return $response->toJson();
      }else{
        return $response->reply(3,'会话过期，请重新登录');
      }


        
      }
      public function  send_template_msg($touser, $name, $price, $url){
            $postData['touser'] = $touser;
            $postData['template_id'] = 'dkUWL_Q8LaL3UVMaX2b000ddd3P4jqQxlZy0rc5QKiI';
            $postData['url'] = $url;
            $postData['data'] = array(
                "first" => array(
                    "value" => "恭喜你购买成功！",
                    "color" => "#173177"
                ),   
                "product" => array(
                    "value" => $name,
                    "color" => "#173177"
                ),   
                "price" => array(
                    "value" => $price. '元',
                    "color" => "#173177"
                ),   
                "time" => array(
                    "value" => date("Y年m月d日 H时i分"),
                    "color" => "#173177"
                ),   
                "remark" => array(
                    "value" => "感谢您的购买",
                    "color" => "#173177"
                )    
            );   

            //提交数据
            $accessToken = get_token();
            $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$accessToken}";
            $json = json_encode($postData);

            $result = json_decode(postCurl($url, $json), true);                                                                               
        } 
      public function send_price_msg($touser, $name, $result){
            ignore_user_abort(true); 
            set_time_limit(0);
            $postData['touser'] = $touser;
            $postData['template_id'] = 'AbHyycX9vKiv7iMrKDTvqar8PPzlitQ8rubO6wj7KUc';
            $postData['url'] = WEB_PATH. "/mobile/home/orderlist";
            $postData['data'] = array(
                "first" => array(
                    "value" => "尊敬的客户，您购买的商品已中奖",
                    "color" => "#173177"
                ),
                "keyword1" => array(
                    "value" => $name,
                    "color" => "#173177"
                ),
                "keyword2" => array(
                    "value" => $result,
                    "color" => "#173177"
                ),
                "remark" => array(
                    "value" => "感谢您的购买",
                    "color" => "#173177"
                )
            );

            //提交数据
            $accessToken = get_token();
            $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$accessToken}";
            $json = json_encode($postData);
            $result = json_decode(postCurl($url, $json), true);
        } 

}
