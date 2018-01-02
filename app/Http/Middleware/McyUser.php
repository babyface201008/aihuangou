<?php
namespace App\Http\Middleware;
use Closure;
//use Illuminate\Support\Facades\Auth;
use App\Model\McyUser as User;
use App\Tools\WeixinUtil;
use App\Tools\WXPAY\Lib\WxPayConfig;
//use App\Tools\MyLog\WechatLog;
use App\Model\McyWxInfo;
//use App\Tools;
class McyUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        //如果是微信端就走微信登录流程,如果是其它端就走注册流程
        /*if(WeixinUtil::isWeixin()){
            // $request->session()->forget('openid','');
            /*测试*/
            //$request->session()->put('openid','o7RM2wGGbYrwjG8JU_daSOs2acuU');
            //$request->session()->put('openid','o7RM2wAplHas54SbdbXpqyxwzbyA');
            //$request->session()->put('openid','ogxrevncskmLlW23PQleAthh1Kb0');
            // $request->session()->put('openid','o7RM2wOlsHXF14CJv2Bmq3TuA7bM');
            // $request->session()->put('openid','o7RM2wIWkFHwO9RYKKkuqtisngio');
            /*$openid = $request->session()->get('openid','');
            $code = $request -> input('code');
            // WechatLog::info($openid);
            if ($openid == '') {
                $wxinfo = McyWxInfo::where('wxinfo_id',8)->first();
                WxPayConfig::$APPID = $wxinfo->appid;
                WxPayConfig::$APPSECRET = $wxinfo->appsecret;
                if (strlen($code) == 0) {
                    $redirect_uri = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                    $state = "STATE";
                    $code_url = WeixinUtil::get_oauth2_code($redirect_uri, $state, "snsapi_userinfo");
                    // $code_url = WeixinUtil::get_oauth2_code($redirect_uri, $state, "snsapi_base");
                    return redirect($code_url);
                } else {
                    $array = @json_decode(WeixinUtil::get_oauth2_token($code) -> json);
                    $openid = @$array -> openid;
                    $access_token = @$array -> access_token;
                    $user = User::where("openid", $openid)->where('is_delete',0)->first();
                    if($user == null)
                    {
                        $result = json_decode(WeixinUtil::get_userinfo($access_token, $openid));
                        $user = new User;
                        // $user->email = '';
                        @$headimgurl = str_replace('http://', '//', @$result->headimgurl);
                        $user->avator_img = '/chimg1.png';
                        $user->site_id = 2;
                        $user->user_id = 6;
                        $user->sex = @$result->sex;
                        $user->username = @$result->nickname?$result->nickname:'潮惠新成员';
                        $user->nickname = @$result->nickname?$result->nickname:'潮惠新成员';
                        $user->openid = $openid;
                        // $user->ip = $request->ip();
                        // $user_IP = ($_SERVER["HTTP_VIA"])?$_SERVER["HTTP_X_FORWARDED_FOR"]:$_SERVER["REMOTE_ADDR"];
                        // $user_IP = ($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"];
                        // $info = Tools::getCity($user->ip);
                        // $user->ip_addr = @$info['region'].@$info['city'];
                        $user->wxuserinfo = json_encode(@$result);
                        $user->save();
                    }else{}
                    if ($openid)
                    {
                        $request->session()->put("openid",$openid,120);
                    }else{

                    }
                    // $request->session()->put('mcy_user_id',$user->mcy_user_id,100);
                }
            }
        }else{*/

            if ($request->session()->has('user_id') ) {
                return $next($request);
            }else{
                return redirect('/login');
            }
        //

         return $next($request);
    } 
}
?>
