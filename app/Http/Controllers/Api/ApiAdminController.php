<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools;
use App\Response;
use App\ApiResponse;
use App\Model\AiHuanGouUser;

class ApiAdminController extends Controller
{
	public function apiWelkinLogin(Request $request)
	{
		$response = new Response;
		$username = $request->input('username','');
		$password = $request->input('password','');
		$errmsg = "错误的登录账号或密码";
		if ($username !== null && $password !== null)
		{
			$user = AiHuanGouUser::where('username',$username)->where('is_delete',0)->first();

			if ($user)
			{

				if (Tools::encrypt($password) == $user->password)
				{
					$user->login_ip = $request->ip();
					$user->save();
					$request->session()->put('admin_id',$user->user_id,1200);
					return $response->reply(0,'登录成功');
				}else{
					return $response->reply(5,$errmsg);
				}
			}else{
				return $response->reply(5,$errmsg);
			}
		}else{
			return $response->reply(5,$errmsg);
		}
	}
    /**
     * 用户管理接口
     * @AiHuanGou
     * @DateTime      2017-04-07T14:58:11+0800
     * @param         $request,$user_id                  
     * @return        data,msg,ret
     */
    public function apiUserCreate(Request $request)
    {
        $response = new Response;
        $username = $request->input('username','');
        $password = $request->input('password','');
        $privileges = intval($request->input('privileges',''));
        if ($username == '' || $password == '')
        {
            return $response->reply(2,'用户名，密码不能为空');
        }else{
            if (AiHuanGouUser::where('username',$username)->where('is_delete',0)->count() > 0)
            {
                return $response->reply(3,'登录名重复，请修改登录名');
            }else{
               $user = new AiHuanGouUser;
               $user->username = $username;
               $user->password = Tools::encrypt($password);
               $user->privileges = $privileges?$privileges:$privileges;
               if ($user->save())
               {
                    return $response->reply(0,'添加成功');
                }else{
                    return $response->reply(2,'网络异常');
                }
            }
           
        }
    }
    public function apiUserUpdate(Request $request)
      {
          $response = new Response;
          $username = $request->input('username','');
          $password = $request->input('password','');
          $privileges = $request->input('privileges','');
          $user_id = $request->input('user_id','');
          $user = AiHuanGouUser::find($user_id);
          if ($user)
          {  
              if ($username == '' || $password == '')
              {
                  return $response->reply(2,'用户名，密码不能为空');
              }else{
                  if (AiHuanGouUser::where('username',$username)->where('is_delete',0)->where('user_id','<>',$user_id)->count() > 0)
                  {
                      return $response->reply(3,'登录名重复，请修改登录名');
                  }else{
                     $user->username = $username;
                     $user->password = Tools::encrypt($password);
                     $user->privileges = $privileges?$privileges:$privileges;
                     if ($user->save())
                     {
                          return $response->reply(0,'修改成功');
                      }
                      else
                      {
                          return $response->reply(2,'网络异常');
                      }
                  }
              }

          }else{
              return $response->reply(2,'找不到该用户');
          }

      }
      public function apiUserDelete(Request $request)
      {
          $response = new Response;
          $admin_id = $request->session()->get('admin_id');
          $user_id = $request->input('user_id');
          $response->user_id = $user_id;
          if (AiHuanGouUser::find($user_id)){
              if (AiHuanGouUser::find($user_id)->user_id == $user_id || $admin_id ==  1)
              {   
                  $user = AiHuanGouUser::find($user_id);
                  $user->is_delete = 1;
                  if ($user->save()){
                      $response->user_id = $user_id;
                      return $response->reply(0,'删除成功');
                  }else{
                      return $response->reply(2,'网络异常');
                  }
              }else{
                  return $response->reply(4,'您的權限不足');
              }
          }else{
              return $response->reply(1,"没有该用户");
          }
      }

      public function apiUserPassword(Request $request)
      {
          $response = new Response;
          $username = $request->input('username');
          $cpassword = $request->input('cpassword');
          $password = $request->input('password');
          $repassword = $request->input('repassword');
          $user_id = $request->session()->get('admin_id');
          $user = AiHuanGouUser::find($user_id);
          if ($user || ($username == '')){
              if (Tools::encrypt($cpassword) == $user->password ){
                  if ($password !== $repassword){
                      return $response->reply(2,'两次密码不一致');
                  }else{
                      if (AiHuanGouUser::where('username',$username)->where('user_id','<>',$user_id)->where('is_delete',0)->first()){
                          return $response->reply(3,'该用户名已经被占用了，请更换用户名'.$user->username.$username);
                      }else{
                          $user->username = $username;
                          $user->password = Tools::encrypt($request->input('password'));
                          if ($user->save()){
                              return $response->reply(0,'修改成功');
                          }else{
                              return $response->reply(2,'数据库写入错误');
                          }
                      }
                  }
              }else{
                  return $response->reply(2,'现密码错误');
              }
              
          }else{
              return $response->reply(1,'找不到该用户');
          }
      }
}
