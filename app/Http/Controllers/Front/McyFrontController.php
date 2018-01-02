<?php

namespace App\Http\Controllers\Kuurin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tools;
use App\

class McyFrontController extends Controller
{    
  public function sites(Request $request)
  {
  	
  	$starttime = empty($request->input('starttime',''))?'1971-1-1':$request->input('starttime').' 00:00:00';
  	$endtime = empty($request->input('endtime',''))?'2099-12-31':$request->input('endtime').' 23:59:59';
  	$searchtext = $request->input('searchtext','');
  	if ($searchtext !== '')
  	{
  		$sites = Kuurinsite::where('is_delete',0)->where('site_name','like','%'.$searchtext.'%')->whereBetween('created_at',[$starttime,$endtime])->paginate(20);
  	}else{
  		$sites = Kuurinsite::where('is_delete',0)->whereBetween('created_at',[$starttime,$endtime])->paginate(20);
  	}

  	return view('welkin.kuurin.sites',compact('sites','starttime','endtime','searchtext'));
  }

  public function siteCreate(Request $request)
  {
    return view('welkin.kuurin.site_create');
  }

  public function siteUpdate(Request $request)
  {
    $site_id = $request->input('site_id');
    $site = Kuurinsite::where('site_id',$site_id)->where('is_delete',0)->first();
    return view('welkin.kuurin.site_update',compact('site'));
  }

}
