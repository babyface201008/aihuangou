<?php

namespace App\Http\Controllers\Admin;
use App\Model\McySite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools;
use App\Response;
use App\ApiResponse;
use App\Model\AiHuanGouUser;

class AdminController extends Controller
{
	/* welkinlogin => 登录界面 */
	/* welkin => 总后台管理界面 */
	/* welkinLogout => 总后台登出界面 */
	public function welkinLogin(Request $request)
	{
		$admin_id = $request->session()->get('admin_id');
		$site = McySite::getInfo();
		if ($admin_id)
		{
			return redirect('/welkin');
			// return view('welkin.admin');
		}else{
			return view('welkin.login',compact('site',$site));
		}
	}
	public function welkinLogout(Request $request)
	{
		$request->session()->forget('admin_id');
        return redirect("/welkin/login");
	} 

	public function welkin(Request $request)
	{
		$admin_id = $request->session()->get('admin_id');
		$user = AiHuanGouUser::find($admin_id);
		return view('welkin.admin',compact('user'));
	}
	public function dashboard(Request $request)
	{
		//return "welkin dashboard";
		return view('welkin.dashboard');
	}
	
	public function users(Request $request)
	{
		return view('welkin.users');
	}
	
	public function password(Request $request)
	{
		return view('welkin.password');
	}
}
