<?php

namespace App\Http\Controllers\Mcy\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Response;
use App\Tools;
use App\Tools\MyLog\SiteLog;
use App\Model\McyProduct;
use App\Model\McyLoopImg;
use App\Model\McyYunGou;
use App\Model\McyUser;
use App\Model\Category;
use App\Model\McySite;
use Cache;


class McyFrontProductIndexController extends Controller
{    
  public $site_id = 2;
  public $user_id = 6;
  public function index(Request $request)
  {
    $site = McySite::where('site_id',$this->site_id)->where('user_id',$this->user_id)->first();
    $categorys = Category::where('user_id',$this->user_id)->where('is_delete',0)->orderBy('created_at','desc')->get();
    $loopimgs = McyLoopImg::where('is_delete',0)->where('user_id',$this->user_id)->where('status',0)->orderBy('sort','desc')->get();
    $products = McyProduct::where('user_id',$this->user_id)->where('is_delete',0)->where('product_type',1)->paginate(20);
    foreach($products as $product)
    {
    	$yungou_shop = McyYunGou::where('product_id',$product->product_id)->where('is_delete',0)->where('qishu',$product->go_now_qishu)->first();
    	$product->shenyurenshu = @$yungou_shop->shenyurenshu;
    	$product->has_go = @$product->go_number - $product->shenyurenshu;
    }
    return view('mcy.index',compact('site','loopimgs','categorys','products'));
  }

  public function productList(Request $request)
  {
	 $site = McySite::where('site_id',$this->site_id)->where('user_id',$this->user_id)->first();
	 $category_id = $request->input('category_id',0);
	 if($category_id !== 0)
	 {
	 	$products = McyProduct::where('user_id',$this->user_id)->where('product_type',1)->where('category_id',$category_id)->where('is_delete',0)->paginate(20);
	 }else{
	 	$products = McyProduct::where('user_id',$this->user_id)->where('is_delete',0)->where('product_type',1)->paginate(20);
	 }
	 return view('mcy.product_list',compact('products','site'));
  }

  public function product(Request $request)
  {
  	 $site = McySite::where('site_id',$this->site_id)->where('user_id',$this->user_id)->first();
  	 $product_id = $request->input('product_id');
  	 $product = McyProduct::where('user_id',$this->user_id)->where('is_delete',0)->where('product_id',$product_id)->first();
  	 return view('mcy.product',compact('site','product'));
  }



}
