<?php

namespace App\Http\Controllers\Mcy;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Response;
use App\Tools;
use App\Tools\MyLog\SiteLog;
use App\Model\McyProduct;
use App\Model\Category;
use Cache;


class McyProductController extends Controller
{    
   /**
   * 用户管理
   * @AiHuanGou
   * @DateTime      2017-04-07T10:52:48+0800
   * @param         Request                  $request 
   * @return        view                            
   */
  public function products(Request $request)
  {
  	
  	$starttime = empty($request->input('starttime',''))?'1971-1-1':$request->input('starttime').' 00:00:00';
  	$endtime = empty($request->input('endtime',''))?'2099-12-31':$request->input('endtime').' 23:59:59';
  	$searchtext = $request->input('searchtext','');
      $product_type = $request->input('product_type',1);
      $category_id = $request->input('category_id',0);
      $admin_id = $request->session()->get('admin_id');
      if ($searchtext !== '')
      {
          if ($category_id == 0)
          {
           $products = McyProduct::where(array('is_delete'=>0,'product_type'=>@$product_type,'user_id'=>$admin_id))->where('product_name','like','%'.$searchtext.'%')->whereBetween('created_at',[$starttime,$endtime])->orderBy('sort','desc')->orderBy('created_at','desc')->paginate(20);
          }else{
           $products = McyProduct::where(array('is_delete'=>0,'product_type'=>@$product_type,'category_id'=>@$category_id,'user_id'=>$admin_id))->where('product_name','like','%'.$searchtext.'%')->whereBetween('created_at',[$starttime,$endtime])->orderBy('sort','desc')->orderBy('created_at','desc')->paginate(20);
          }
      }else{
        if ($category_id == 0)
        {
           $products = McyProduct::where(array('is_delete'=>0,'product_type'=>@$product_type,'user_id'=>$admin_id))->whereBetween('created_at',[$starttime,$endtime])->orderBy('sort','desc')->orderBy('created_at','desc')->paginate(20);
       }else{
           $products = McyProduct::where(array('is_delete'=>0,'product_type'=>@$product_type,'category_id'=>@$category_id,'user_id'=>$admin_id))->whereBetween('created_at',[$starttime,$endtime])->orderBy('sort','desc')->orderBy('created_at','desc')->paginate(20);
       }
      }
      $categorys = Category::where('user_id',$admin_id)->where('is_delete',0)->get();
  	return view('welkin.mcy.products',compact('products','starttime','endtime','searchtext','categorys','product_type','category_id'));
  }

  public function productCreate(Request $request)
  {
    $admin_id = $request->session()->get('admin_id');
    $categorys = Category::where('user_id',$admin_id)->where('is_delete',0)->get();
    return view('welkin.mcy.product_create',compact('categorys'));
  }

  public function productUpdate(Request $request)
  {
    $admin_id = $request->session()->get('admin_id');
    $product_id = intval($request->input('product_id'));
    $product = McyProduct::where('user_id',$admin_id)->where('is_delete',0)->where('product_id',$product_id)->first();
    $product->product_loop_img = explode(",",$product->product_loop_imgs);
    $categorys = Category::where('user_id',$admin_id)->where('is_delete',0)->get();
    return view('welkin.mcy.product_update',compact('product','categorys'));
  }

}
