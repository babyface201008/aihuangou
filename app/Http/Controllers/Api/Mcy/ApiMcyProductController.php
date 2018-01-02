<?php

namespace App\Http\Controllers\Api\Mcy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Mcy\McyAutoManController as AutoMan;
use App\Tools;
use App\Response;
use App\ApiResponse;
use App\Model\McyUser;
use App\Model\McyProduct;
use App\Model\McyYunGou;
use App\Model\Category;
use App\Model\McyOrder;
use App\Model\McyShaiDan;
use App\Model\McyYunGouOrder;
use App\Model\McyPay;
use App\Model\McySite;
use Validator;

class ApiMcyProductController extends Controller
{
    public $number = 20;
    public $user_id = 6;

    /* 修复倒计时 */
    public function apiChkgFixProduct(Request $request)
    {
      /* 找出倒计时不开的东西*/
      set_time_limit(0);
      $d = date('Y-m-d H:i:s');
      $yungou_shops = McyYunGou::where('is_delete',0)->where('show_time','>',0)->where('huode_id',0)->where('show_time','<',$d)->get();
      // dd($yungou_shops);
      foreach($yungou_shops as $yungou_shop)
      {
        // $url = "http://www.chkg99.com/api/go_product_daojishi/".$yungou_shop->yungou_id; 
        // echo $result = $this->triggerRequest($url);
        $auto  = new AutoMan;
        $auto_result = $auto->go_product_daojishi($yungou_shop->yungou_id);
        var_dump($auto_result);
      }

    }


    public function apiProductCreate(Request $request)
    {
        $response = new ApiResponse;
        parse_str($request->input('data') , $data);
        $admin_id = $request->session()->get('admin_id');


        //表单验证
        $validator = Validator::make($data, [
            'product_name' => "required",
            'product_price' => 'required',
            'category_id'=>'required',
            'go_number'=>'required',
            'go_qishu'=>'required'
        ]);
        $validator->setAttributeNames([
            'product_name' => "商品名称",
            'product_price' => '商品价格',
            'category_id'=>'产品归类',
            'go_number'=>'云购人次',
            'go_qishu'=>'云购期数'
        ]);

        if($validator->fails()){
            return $response->reply(3,Tools::getErrorMsg($validator->errors()->all()));
        }

        //云购人次必须大于0
        if($data['go_number']<=0){
            return $response->reply(3,'云购人次必须大于0');
        }

        if ($admin_id)
        {
          $model = 'App\Model\McyProduct';
          $d = array();
          $d['user_id'] = $admin_id;
          $d['product_img'] = $request->input('product_img')?$request->input('product_img'):'';
          $d['product_loop_imgs'] = $request->input('product_loop_imgs')?$request->input('product_loop_imgs'):'';
          $d['product_desc'] = $request->input('product_desc')?$request->input('product_desc'):'';
          $d['product_name'] = $data['product_name'];
          $d['product_price'] = $data['product_price'];
          $d['product_type'] = $data['product_type'];
          $d['go_price'] = $data['product_price'] / $data['go_number'];
          $d['category_id'] = @$data['category_id'];
          $category = Category::where('category_id',$data['category_id'])->first();
          $d['category_name'] = $category->name;
          $d['go_number'] = $data['go_number'];
          $d['go_qishu'] = $data['go_qishu'];
          $d['go_auto'] = $data['go_auto'];
          // $d['go_zhiding'] = $data['go_zhiding'];
          $d['is_xiangou'] = $data['is_xiangou'];
          $d['xiangou_count'] = $data['xiangou_count'];
          $result = $response->create($model,$d);
          if ($d['product_type'] == 1)
          {
            if ($response->ret == 0)
            {
              $r =  $this->yungou($response->obj);
              if ($r)
              {
                $category->count += 1;
                $category->save();
                return $response->toJson();
              }else{  
                return $response->reply(2,'创建云购商品失败');
              }
            }else{

            }
          }else{}
          return $response->toJson();
        }else{
          return $response->reply(3,'会话过期，请重新登录');
        }
    }
    public function apiProductUpdate(Request $request)
    {
      $response = new ApiResponse;
      parse_str($request->input('data') , $data);
      $admin_id = $request->session()->get('admin_id');
      $product_id = $data['product_id'];
      if ($admin_id)
      {
        $model = 'App\Model\McyProduct';
        $search = array(
          'user_id'=>@$admin_id,
          'product_id'=>@$product_id,
          );
        $d = array();
        $d['product_img'] = $request->input('product_img')?$request->input('product_img'):'';
        $d['product_loop_imgs'] = $request->input('product_loop_imgs')?$request->input('product_loop_imgs'):'';
        $d['product_desc'] = $request->input('product_desc')?$request->input('product_desc'):'';
        $d['product_name'] = $data['product_name'];
        $d['category_id'] = @$data['category_id'];
        $category = Category::where('category_id',$data['category_id'])->select('name')->first();
        $d['category_name'] = $category->name;
        // $d['go_auto'] = $data['go_auto'];
        // $d['go_zhiding'] = $data['go_zhiding'];
        $d['is_xiangou'] = $data['is_xiangou'];
        $d['xiangou_count'] = $data['xiangou_count'];
        $result = $response->update($model,$search,$d);
        return $response->toJson();
        return $response->reply(3,'会话过期，请重新登录');
      }
    }
    public function apiProductDelete(Request $request)
    {
      $response = new ApiResponse;
      $admin_id = $request->session()->get('admin_id');
      if ($admin_id) 
      {
        $product_id = $request->input('product_id');
        $model = 'App\Model\McyProduct';
        $data = array();
        $data['product_id'] = $product_id;
        $data['user_id'] = $admin_id;
        $response->product_id = $product_id;
        $request = $response->delete($model,$data);
        if ($response->ret == 0)
        {
            $category = Category::where('category_id',$response->obj->category_id)->first();
            if ($category->count > 0)
            {
              $category->count -= 1;
              $category->save();
            }else{}
        }else{}
        return $response->toJson();
      }else{
        return $response->reply(3,'会话过期，请重新登录');
      }
      }

      public function yungou($product)
      {
        // return $product;
        $yungou = new McyYunGou;
        $yungou->product_id = $product->product_id;
        $yungou->qishu = 1;
        $yungou->product_name = $product->product_name;
        $yungou->price = $product->go_price;
        $yungou->shenyurenshu = $product->go_number;
        $yungou->zongshu = $product->go_number;
        $yungou->zhiding = 0;
        $product->go_now_qishu = 1;
        $product->save();
        if ($product->go_number > 4000)
        {
          /*暂时不写大于4000人次数的产品*/
          $yungou->sort = 0;
        }else{
          $yungou->sort = 0;
        }
        $a = array();
        for ($i=1; $i <= ($product->go_number); $i++) { 
            $a[] = $i;
        }
        $yungou->shengyuma = implode(",",$a);
        if ($yungou->save())
        {
          return true;
        }else{

          return false;
        }
      }
      public function apiAddCart(Request $request)
      {
        $response = new ApiResponse;
        //$openid = $request->session()->get('openid');

        // if ($mcy_user->username == '潮惠新成员'){
        //   $msg = '快给自己来个个性名称吧！然后可以快购啦！';
        //    return $response->reply(2,$msg);
        // }else{}
        $response->is_all = 0;
        if (session('user_id'))
        {
            $mcy_user = McyUser::getUserInfo();
          // $request->session()->forget('cart');
          $cart = $request->session()->get('cart');
          $product_id = $request->product_id;
          $number = $request->number;
          $qishu = $request->input('qishu');

          if ($product_id !== '')
          {
             $c = $cart;
             $product = McyProduct::where('product_id',$product_id)->where('is_delete',0)->first();
             if ($product->is_xiangou == 1)
             {
                $orders = McyYunGouOrder::where('product_id',$product_id)->where('qishu',$qishu)->where('is_delete',0)->where('mcy_user_id',$mcy_user->mcy_user_id)->select('yungouma')->get();
                $count = 0;
                foreach($orders as $order)
                {
                  $wa = explode(",",$order->yungouma);
                  $count += count($wa);
                }
                if (($count + @$c[$product_id]['number'] + $number) > $product->xiangou_count)
                {
                  $wcount = $product->xiangou_count - $count ;
                  return $response->reply(3,"该商品是限购商品,每人最多只能购买 $product->xiangou_count 人次，您已经购买了 $count 人次");
                }else{

                }
             }else{

             }
             $yungou_shop =  McyYunGou::where('qishu',$qishu)->where('is_delete',0)->where('product_id',$product_id)->first();
             if ($yungou_shop->shenyurenshu > $number)
             {
                 if (isset($c[$product_id]))
                 {
                  if (($c[$product_id]['number'] + $number) > $yungou_shop->shenyurenshu)
                  {
                    return $response->reply(3,'本期商品已达最大购买数');
                  }else{}
                  $c[$product_id]['number'] += $number;
                  $c[$product_id]['qishu'] = $qishu;
                  $c[$product_id]['product_id'] = $product_id;
                }else{
                  $c[$product_id]['qishu'] = $qishu;
                  $c[$product_id]['number'] = $number;
                  $c[$product_id]['product_id'] = $product_id;
                }
                $request->session()->forget('cart');

                $request->session()->put('cart',$c,1200);
                $response->cart = count($request->session()->get('cart'));
             }else{
                if ($yungou_shop->shenyurenshu == 0)
                {
                  if (isset($c[$product_id])){
                    unset($c[$product_id]);
                  }
                  $request->session()->forget('cart');
                  $request->session()->put('cart',$c,1200);
                  $response->cart = count($request->session()->get('cart'));
                  return $response->reply(4,'商品已经售完');
                }else{
                  /* 拉到最高数量 */
                  $c[$product_id]['number'] = $yungou_shop->shenyurenshu;
                  $c[$product_id]['qishu'] = $qishu;
                  $c[$product_id]['product_id'] = $product_id;
                  $response->all_number = $yungou_shop->shenyurenshu;
                  $response->is_all = 1;
                  $request->session()->forget('cart');
                  $request->session()->put('cart',$c,1200);
                  $response->cart = count($request->session()->get('cart'));
                  // return $response->reply(3,'您来晚了一步，商品被人抢走了！');
                }
             }

            return $response->reply(0,'添加成功');
          }else{
            return $response->reply(2,'没有产品ID');
          }
         
        }else{
          return $response->reply(1,'登录后再添加');
        }
      }
      public function apiDeleteCart(Request $request)
      {
        $response = new ApiResponse;
        $openid = $request->session()->get('openid');
        $mcy_user = McyUser::where('openid',$openid)->where('is_delete',0)->first();
        $type = $request->input('type',0);
        if ($mcy_user)
        {
          // $request->session()->forget('cart');
          $cart = $request->session()->get('cart');
          $product_id = $request->product_id;
          $number = $request->number;
          $qishu = $request->input('qishu');
          if ($product_id !== '')
          {
           $c = $cart;
           $yungou_shop =  McyYunGou::where('qishu',$qishu)->where('is_delete',0)->where('product_id',$product_id)->first();
          /* 删除该商品进入购物车 */
          if ($type == 4){
             if (isset($c[$product_id])){
              unset($c[$product_id]);
              $request->session()->forget('cart');
              $request->session()->put('cart',$c,1200);
              $response->cart = $request->session()->get('cart');
              return $response->reply(0,'删除成功');
             }else{
              return $response->reply(1,'删除失败');
             }
          }
           if ($yungou_shop->shenyurenshu > $number)
           {
             if (isset($c[$product_id]))
             {
              $c[$product_id]['number'] -= $number;
              $c[$product_id]['qishu'] = $qishu;
              $c[$product_id]['product_id'] = $product_id;

            }else{
              $c[$product_id]['qishu'] = $qishu;
              $c[$product_id]['number'] = $number;
              $c[$product_id]['product_id'] = $product_id;
            }
            if ($c[$product_id]['number'] <= 0)
            {
             return $response->reply(4,'数量必须大于零');
           }else{}
            $request->session()->forget('cart');
            $request->session()->put('cart',$c,1200);
            $response->cart = $request->session()->get('cart');
          }else{
            if ($yungou_shop->shenyurenshu == 0)
            {
              if (isset($c[$product_id]))unset($c[$product_id]);
              $request->session()->forget('cart');
              $request->session()->put('cart',$c,1200);
              $response->cart = $request->session()->get('cart');
              return $response->reply(4,'商品已经售完');
            }else{
              return $response->reply(3,'您来晚了一步，商品被人抢走了！');
            }
          }

          return $response->reply(0,'减少成功');
        }else{
          return $response->reply(2,'没有产品ID');
        }

      }else{
        return $response->reply(1,'登录后再添加');
      }
    }
      public function apiZhiDingCart(Request $request)
      {
        $response = new ApiResponse;

        $mcy_user = McyUser::getUserInfo();
        $type = $request->input('type',0);
        if ($mcy_user)
        {
          // $request->session()->forget('cart');
          $cart = $request->session()->get('cart');
          $product_id = $request->product_id;
          $number = intval($request->number);
          $qishu = $request->input('qishu');
          if ($product_id !== '')
          {
           $c = $cart;
           $product = McyProduct::where('product_id',$product_id)->where('is_delete',0)->first();
             if ($product->is_xiangou == 1)
             {
                $orders = McyYunGouOrder::where('product_id',$product_id)->where('qishu',$qishu)->where('is_delete',0)->where('mcy_user_id',$mcy_user->mcy_user_id)->select('yungouma')->get();
                $count = 0;
                foreach($orders as $order)
                {
                  $wa = explode(",",$order->yungouma);
                  $count += count($wa);
                }
                if (($count + $number) > $product->xiangou_count)
                {
                  $wcount = $product->xiangou_count - $count ;
                  return $response->reply(3,"该商品是限购商品,每人最多只能购买 $product->xiangou_count 人次，您已经购买了 $count 人次 ");
                }else{

                }
             }else{

             }
           $yungou_shop =  McyYunGou::where('qishu',$qishu)->where('is_delete',0)->where('product_id',$product_id)->first();
          /* 删除该商品进入购物车 */
          if ($type == 4){
             if (isset($c[$product_id])){
              unset($c[$product_id]);
              $request->session()->forget('cart');
              $request->session()->put('cart1',$c,1200);
              $response->cart = count($request->session()->get('cart'));
              return $response->reply(0,'删除成功');
             }else{
              return $response->reply(1,'删除失败');
             }
          }
           if ($yungou_shop->shenyurenshu >= $number)
           {
            //  if (isset($c[$product_id]))
            //  {
            //   $c[$product_id]['number'] -= $number;
            //   $c[$product_id]['qishu'] = $qishu;
            //   $c[$product_id]['product_id'] = $product_id;

            // }else{
              $c[$product_id]['qishu'] = $qishu;
              $c[$product_id]['number'] = $number;
              $c[$product_id]['product_id'] = $product_id;
            // }
            if ($c[$product_id]['number'] <= 0)
            {
             return $response->reply(4,'数量必须大于零');
           }else{}
            $request->session()->forget('cart');
            $request->session()->put('cart',$c,1200);
            $response->cart = count($request->session()->get('cart'));
          }else{
            if ($yungou_shop->shenyurenshu == 0)
            {
              if (isset($c[$product_id]))unset($c[$product_id]);
              $request->session()->forget('cart');
              $request->session()->put('cart',$c,1200);
              $response->cart = count($request->session()->get('cart'));
              return $response->reply(4,'商品已经售完');
            }else{
              return $response->reply(3,'商品数量不够了！');
            }
          }

          return $response->reply(0,'设置成功');
        }else{
          return $response->reply(2,'没有产品ID');
        }

      }else{
        return $response->reply(1,'登录后再添加');
      }
    }
      public function apiGetProduct(Request $request)
      {
        $response = new ApiResponse;
        $category_id = $request->category_id?$request->category_id:0;
        $order = $request->order;
        $page = $request->page;
        $number = $this->number;
        $select = array(
            'product_img',
            'go_now_qishu',
            'product_name',
            'product_price',
            'go_number',
            'product_id'
          );
        if ($category_id == 0)
        {

            //$products = McyProduct::where('is_delete',0)->where('product_type',1)->where('user_id',$this->user_id)->select($select)->skip(($page - 1)*$number)->take($number)->get();
         $response->order = $order;
         switch ($order) {
      
           case 20:
                $products = McyProduct::where('is_delete',0)->where('product_type',1)->where('user_id',$this->user_id)->where('hot',1)->orderBy('sort','desc')->select($select)->skip(($page - 1)*$number)->take($number)->get();
              break;
           case 30:
                $products = McyProduct::where('is_delete',0)->where('product_type',1)->where('user_id',$this->user_id)->orderBy('created_at','desc')->select($select)->skip(($page - 1)*$number)->take($number)->get();
              break;
           case 60:
           case 50:
                $products = McyProduct::where('is_delete',0)->where('product_type',1)->where('user_id',$this->user_id)->orderBy('product_price','desc')->select($select)->skip(($page - 1)*$number)->take($number)->get();
              break;
           case 10:
           case 11:
               $select = array(
                  'mcy_product.product_img',
                  'mcy_product.go_now_qishu',
                  'mcy_product.product_name',
                  'mcy_product.product_price',
                  'mcy_product.go_number',
                  'mcy_product.product_id'
                );
                $products = McyProduct::join('mcy_yungou',function($join){
                                            $join->on("mcy_yungou.qishu",'=','mcy_product.go_now_qishu');
                                            $join->on("mcy_yungou.product_id",'=','mcy_product.product_id');
                                          },'left')->where('mcy_product.is_delete',0)->where('mcy_product.product_type',1)->where('mcy_product.user_id',$this->user_id)->orderBy('mcy_yungou.shenyurenshu','asc')->select($select)->skip(($page - 1)*$number)->take($number)->get();
              break;
           default:

                $products = McyProduct::where('is_delete',0)->where('product_type',1)->where('user_id',$this->user_id)->where('hot',1)->orderBy('sort','desc')->select($select)->skip(($page - 1)*$number)->take($number)->get();

                break;
         }
        }else{
         $response->order = $order;
          $products = McyProduct::where('is_delete',0)->where('category_id',$category_id)->where('product_type',1)->where('category_id',$category_id)->where('user_id',$this->user_id)->select($select)->skip(($page - 1)*$number)->take($number)->get();
          $response->t = $products;
         switch ($order) {
          
           case 20:
                $products = McyProduct::where('is_delete',0)->where('category_id',$category_id)->where('product_type',1)->where('user_id',$this->user_id)->where('hot',1)->orderBy('sort','desc')->select($select)->skip(($page - 1)*$number)->take($number)->get();
              break;
           case 30:
                $products = McyProduct::where('is_delete',0)->where('category_id',$category_id)->where('product_type',1)->where('user_id',$this->user_id)->orderBy('created_at','desc')->select($select)->skip(($page - 1)*$number)->take($number)->get();
              break;
           case 60:
           case 50:
                $products = McyProduct::where('is_delete',0)->where('category_id',$category_id)->where('product_type',1)->where('user_id',$this->user_id)->orderBy('product_price','desc')->select($select)->skip(($page - 1)*$number)->take($number)->get();
              break;
           case 10:
           case 11:
               $select = array(
                  'mcy_product.product_img',
                  'mcy_product.go_now_qishu',
                  'mcy_product.product_name',
                  'mcy_product.product_price',
                  'mcy_product.go_number',
                  'mcy_product.product_id'
                );
                $products = McyProduct::join('mcy_yungou',function($join){
                                            $join->on("mcy_yungou.qishu",'=','mcy_product.go_now_qishu');
                                            $join->on("mcy_yungou.product_id",'=','mcy_product.product_id');
                                          },'left')->where('mcy_product.is_delete',0)->where('mcy_product.category_id',$category_id)->where('mcy_product.product_type',1)->where('mcy_product.user_id',$this->user_id)->orderBy('mcy_yungou.shenyurenshu','asc')->select($select)->skip(($page - 1)*$number)->take($number)->get();
              break;
           default:

                $products = McyProduct::where('is_delete',0)->where('category_id',$category_id)->where('product_type',1)->where('user_id',$this->user_id)->select($select)->skip(($page - 1)*$number)->take($number)->get();
             break;
         }
        }

        foreach($products as $key => $product)
        {

          $yungou_shop = McyYunGou::where('product_id',$product->product_id)->where('qishu',$product->go_now_qishu)->where('is_delete',0)->first();

          if ($yungou_shop && $yungou_shop->shenyurenshu == 0)
          {
            unset($products[$key]);
            // array_splice($products,$key,1);
          }else{
            @$product->thumb = $product->product_img;
            @$product->qishu = $product->go_now_qishu;
            @$product->title = $product->product_name;
            @$product->money = $product->product_price;
            @$product->shenyurenshu = $yungou_shop->shenyurenshu;
            @$product->zongrenshu = $product->go_number;
            @$product->sid = $product->product_id;
          }
        }
        $response->shoplist = $products;
        return $response->reply(0,'获取成功');
      }
      public function apiCartPay(Request $request)
      {
        $response = new ApiResponse;
        /* 找出购买者 */
        $openid = $request->session()->get('openid');
        $mcy_user = McyUser::where('is_delete',0)->where('openid',$openid)->first();
        if ($mcy_user)
        {
          /* 找出商品的详情 */
          $cartlists = $request->session()->get('cart');
          $all_price = 0;
          foreach($cartlists as $key => $cartlist)
          {
            $yungou_shop = McyYunGou::where('is_delete',0)->where('shenyurenshu','>',0)->where('product_id',$cartlist['product_id'])->orderBy('qishu','desc')->orderBy('sort','desc')->first();
            $all_price += $yungou_shop->price * $cartlist['number'];
          }
          /* 生成订单 */
          $order = new McyOrder;
          /* 支付类型 0为 充值 */
          $order->product_id = 1;
          $order->order_type = 1;
          $order->order_no = date("YmdHis",time()).mt_rand(0,9).mt_rand(0,9).mt_rand(0,9);
          $order->order_price = $all_price;
          $order->order_user_id = $mcy_user->mcy_user_id;
          $order->order_username = $mcy_user->username;
          $order->save();
          /* 生成订单 */
          $payinfo_id = $request->input('payinfo_id',1);
          $payinfo = McyPay::where('is_delete',0)->where('payinfo_id',$payinfo_id)->where('status',0)->first();
          /* 找出能启用状态的支付方式 */
          if ($payinfo)
          {
            $method = $payinfo->method;
            $response->payinfo = $this->$method($order,$payinfo);
          }else{
            $payinfo = McyPay::where('is_delete',0)->where('status',0)->first();
            if ($payinfo)
            {
              $method = $payinfo->method;
              return $response->payinfo = $this->$method($order,$payinfo);
            }else{
              $response->payinfo = "找不到支付方式";
              // return $response->reply(2,'找不到支付方式');
              $msg = $response->payinfo;
              return view('mcy.payinfo',compact('msg'));
            }
            $method = $payinfo->method;
            return $response->payinfo = $this->$method($order,$payinfo);
          }
          /* 跳转支付 */

        }else{
          // return $response->reply(2,'登录信息过期');
          $msg = '登录信息过期';
          return view('mcy.payinfo',compact('msg'));
        }
      }

      public function apiCartPayReturn(Request $request)
      {
        /* 支付回调 */
        /* 根据订单order号判断是那个订单的 */
        /* 验证信息 */
        /* 更新订单状态 */
        /* 返回通知 */
      }

      public function swiftpass($order,$payinfo)
      {
        dd($order);
      }
      /* 检查是否进入倒计时 */
      public function apiCheckProduct(Request $request)
      {
        $response = new ApiResponse;
        $product_id = $request->input('product_id');
        $product = McyProduct::where('product_id',$product_id)->where('is_delete',0)->first();
        if ($product)
        {
          /* 找出未开奖的商品信息 */
          $yungou_shop = McyYunGou::where('product_id',$product_id)->where('is_delete',0)->where('qishu',$product->go_now_qishu)->where('status',0)->first();
          if ($yungou_shop->shenyurenshu == 0)
          {
            /* 触发倒计时 */
            $auto  = new AutoMan;
            $auto_result = $auto->go_product_daojishi($yungou_shop->yungou_id);
            return $response->reply(0,'准备进入倒计时');
          }else{
            return $response->reply(1,'人数尚未达到要求');
          }
        }else{
          return $response->reply(3,'找不到这件商品');
        }

      }
      /* 检查商品出错判断 */
      public function apiFixBugProduct(Request $request)
      {
        $response = new ApiResponse;
        $product_id = $request->input('product_id');
        $product = McyProduct::where('product_id',$product_id)->where('is_delete',0)->first();
        if ($product)
        {

        $yungou_shop = McyYunGou::where('product_id',$product_id)->where('is_delete',0)->where('qishu',$product->go_now_qishu)->orderBy('sort','desc')->first();
        /*检查人数是否满了*/
        if (($yungou_shop->huode_id == 0))
        {
            $automan = new AutoMan;
            $auto_result = $automan->checkProductIsSellOut($product_id,$yungou_shop->yungou_id);
            // dd($auto_result);
            return $auto_result;
        }else{
          echo "开奖了，获奖人ID:".$yungou_shop->huode_id;
        }
        }else{
        echo "没有这件商品"; 
        }
      }



      /* 触发获奖人 */
      public function aptGetHuodeShop(Request  $request)
      {
        $response = new ApiResponse;
        $yungou_id = $request->input('oid');
        $yungou_shop = McyYunGou::where('yungou_id',$yungou_id)->where('is_delete',0)->first();
        $response->error = 1;
          $site = McySite::getInfo();
        if ($yungou_shop)
        {
          if ($yungou_shop->shenyurenshu == 0)
          {
             $automan = new AutoMan;
             $auto_result = $automan->go_product_daojishi($yungou_id);
             $response->result = $auto_result;
             // dd($auto_result);
             if ($auto_result)
             {
              $yungou_shop = McyYunGou::where('yungou_id',$yungou_id)->where('is_delete',0)->first();
              if ($yungou_shop->huode_id == 0)
              { 
                $response->oid = $yungou_id;
                return $response->reply(0,'ok');
              }else{}
              $mcy_user = McyUser::where("is_delete",0)->where('mcy_user_id',$yungou_shop->huode_id)->first();
              $response->uid = $yungou_shop->mcy_user_id;
              $response->uphoto = empty($mcy_user->avator_img)?$site->site_m_logo:$mcy_user->avator_img;
              $response->user = $mcy_user->username;
              $response->user_code = $yungou_shop->huode_ma;
              $orders = McyYunGouOrder::where('product_id',$yungou_shop->product_id)->where('qishu',$yungou_shop->qishu)->where('is_delete',0)->where('mcy_user_id',$yungou_shop->huode_id)->select('yungouma')->get();
               $count = 0;
               foreach($orders as $order)
               {
                $c = explode(",",$order->yungouma);
                $count += count($c);
              }
              $response->error = 0;
              $response->gonumber = $count;
              $response->end_time = @$yungou_shop->huode_order_time;
              return $response->reply(0,'ok');
            }else{
              // return $response->reply(1,'揭晓失败');
            }
          }else{
            return $response->reply(3,'参与人数不足');
          }
         
        }else{
          // return $response->reply(1,'false');
        }
        $response->oid = $yungou_id;
        return $response->reply(1,'ok');
      }

      /* 前台最新揭晓页面数据加载已经揭晓完成作品 */
      public function LotteryHuodeShopList(Request $request)
      {
        $t1 = microtime(true);

        //网站配置信息
        $site = McySite::getInfo();

        $response = new ApiResponse;
        $number = $request->number?$request->number:10;
        $page = $request->page?$request->page:1;
        $error = 0;
        $date = date("Y-m-d H:i:s");
        // $select = array(
        //   'mcy_yungou.product_id',
        //   'mcy_yungou.huode_id',
        //   'mcy_yungou.qishu',
        //   'mcy_yungou.huode_ma',
        //   'mcy_yungou.zongshu',
        //   'mcy_yungou.yungou_id',
        //   'mcy_yungou.huode_buy_count',
        //   'mcy_yungou.huode_order_time',
        //   'mcy_user.mcy_user_id',
        //   'mcy_user.username',
        //   'mcy_user.nickname',
        //   'mcy_user.avator_img',
        //   'mcy_product.product_img',
        //   );       
        $select = array(
          'mcy_yungou.product_id',
          'mcy_yungou.huode_id',
          'mcy_yungou.qishu',
          'mcy_yungou.huode_ma',
          'mcy_yungou.zongshu',
          'mcy_yungou.yungou_id',
          'mcy_yungou.huode_buy_count',
          'mcy_yungou.huode_order_time',
          );
          // $listItems = McyYunGou::join('mcy_user','mcy_user.mcy_user_id','=','mcy_yungou.huode_id')
          //                         ->join('mcy_product','mcy_product.product_id','=','mcy_yungou.product_id')
          //                         ->where('mcy_yungou.is_delete',0)
          //                         ->where('mcy_yungou.show_time','<',$date)
          //                         ->where('mcy_yungou.status',1)
          //                         ->where('mcy_yungou.huode_id','<>',0)
          //                         ->skip((($page - 1) * $number))
          //                         ->take($number)
          //                         ->orderBy('mcy_yungou.show_time','desc')
          //                         ->select($select)
          //                         ->get();
          $listItems = McyYunGou::where('is_delete',0)->where('status',1)->where('huode_id','<>',0)->where('show_time','<',$date)->skip((($page - 1) * $number))->take($number)->orderBy('show_time','desc')->select($select)->get();
        foreach($listItems as $item)
        {
         $huode  = McyUser::where('mcy_user_id',$item->huode_id)->select('mcy_user_id','username','nickname','avator_img')->first();
         $product = McyProduct::where('product_id',$item->product_id)->first();
         if ($item->huode_buy_count < 1)
         {
          $orders = McyYunGouOrder::where('product_id',$item->product_id)->where('qishu',$item->qishu)->where('is_delete',0)->where('mcy_user_id',$item->huode_id)->select('yungouma')->get();
          $count = 0;
          foreach($orders as $order)
          {
            $c = explode(",",$order->yungouma);
            $count += count($c);
          }
          $yungou_shop = McyYunGou::where('yungou_id',$item->yungou_id)->first();
          $yungou_shop->huode_buy_count = $count;
          $yungou_shop->save();
         }else{
          $count = $item->huode_buy_count;
         }
           $item->id = $item->product_id;
           $item->thumb_style = '';
           $item->LoadPic = '/favicon.ico';
           $item->thumb = $product->product_img;
           $item->qishu = $item->qishu;
           $item->uid = $huode->huode_id;
           $item->uphoto = !empty($huode->avator_img)?$huode->avator_img:$site->site_m_logo;
           $item->user = $huode->username;
           $item->gonumber = $count;
           $item->user_code = $item->huode_ma;
           $item->end_time = $item->huode_order_time;
        }
        $response->error = $error;
        $response->listItems = $listItems;
        return $response->toJson();
      }
      public function apiGetGoingLotteryShopList(Request $request)
      {
        // 按时间找出倒计时的产品
        $response = new ApiResponse;
        $gid = $request->input('gid');
        $number = $request->number?$request->number:20;
        $page = $request->page?$request->page:1;
        $error = 0;
        $d = date("Y-m-d H:i:s");
        if ($gid == '')
        {
          $yungou_shop = McyYunGou::where('is_delete',0)->where('show_time','>',$d)->orderBy('show_time','desc')->select('show_time')->first();
          $flag = 1;
        }else{
          $yungou_shop = McyYunGou::where('yungou_id',$gid)->where('is_delete',0)->select('show_time')->first();
          $flag = 0;
        }

        if ($yungou_shop)
        {
        }else{
          $response->listItems = '';
          $response->error =1 ;
          return $response->toJson();
        }
        $date = $yungou_shop->show_time;
        $response->date = $date;
        if ($flag == 1)
        {
          // $listItems = McyYunGou::where('is_delete',0)->where('show_time','>',$date)->orderBy('show_time','desc')->limit(4)->get();
          $listItems = McyYunGou::where('is_delete',0)->where('show_time','>',$date)->orderBy('show_time','asc')->limit(4)->get();
        }else{
          // $listItems = McyYunGou::where('is_delete',0)->where('show_time','>',$date)->orderBy('show_time','desc')->limit(4)->get();
          $listItems = McyYunGou::where('is_delete',0)->where('show_time','>',$date)->orderBy('show_time','asc')->limit(4)->get();
        }
         $newgid = $gid;
         $d1 = strtotime($d);
          if($listItems){
              foreach($listItems as $item)
              {
                  $product = McyProduct::where('product_id',$item->product_id)->select(array('product_img','product_name','product_price'))->first();
                  $item->id = $item->product_id;
                  $item->yid = $item->yungou_id;
                  $item->thumb_style = '';
                  $item->LoadPic = '/favicon.ico';
                  $item->thumb = $product->product_img;
                  $item->qishu = $item->qishu;
                  $item->title = $product->product_name;
                  $item->shop_money = $product->product_price;
                  $item->times = strtotime($item->show_time) - $d1;
                  $newgid = $item->yungou_id;
              }
          }


         $response->error = $error;
         $response->newgid = $newgid;
        if (count($listItems) == 0) {$response->error = 1;}
        $response->listItems = $listItems;
        return $response->toJson();
      }
      public function apiGetBuyRecords(Request $request)
      {
        $product_id = $request->product_id;
        $qishu = $request->qishu;
        $table = $request->table;
        $pos = $request->pos;
        $rid = $request->rid;
        $response  = new ApiResponse;

          $site = McySite::getInfo();
        if ($rid == 0)
        {
          $records = McyYunGouOrder::where('is_delete',0)->where('product_id',$product_id)->where('qishu',$qishu)->where('go_id','>',$rid)->orderBy('go_id','desc')->limit(10)->get();
        }else{
          $records = McyYunGouOrder::where('is_delete',0)->where('product_id',$product_id)->where('qishu',$qishu)->where('go_id','<',$rid)->orderBy('go_id','desc')->limit(10)->get();
        }
        $response->pos = $pos;
        $response->table = $table;
        foreach($records as $record)
        {
          // $mcy_user = McyUser::where("is_delete",0)->where('mcy_user_id',$record->mcy_user_id)->first();
          $mcy_user = McyUser::where('mcy_user_id',$record->mcy_user_id)->first();
          $record->uid = $record->mcy_user_id;
          $record->uphoto = empty($mcy_user->avator_img)?$site->site_m_logo:$mcy_user->avator_img;
          $record->user = @$mcy_user->username;
          $record->ip = @$mcy_user->ip_addr;
          $record->gonumber = count(explode(",",$record->yungouma));
          $record->time = @$record->created_at;
        }
        $response->records = $records;
        return $response->toJson();
      }
      public function apiGetUserBuyList(Request $request)
      {
        $type = $request->type;
        $mcy_user_id = $request->mcy_user_id;
        $yungou_id = $request->yungou_id;
        $number = $request->number;
        $count = $request->count;
        $response = new ApiResponse;
        // $response->number = $number;
        // $response->count = $count;
        $response->listItems = '';
        $mcy_user = McyUser::where('mcy_user_id',$mcy_user_id)->where('is_delete',0)->first();
         $select = array(
              'mcy_product.product_name',
              'mcy_product.product_price',
              'mcy_product.go_now_qishu',
              'mcy_product.product_img',
              'mcy_yungou_order.product_id',
              'mcy_yungou_order.qishu',
              'mcy_product.product_price',
              'mcy_yungou_order.mcy_user_id',
              'mcy_yungou.shenyurenshu',
              'mcy_yungou.zongshu',
              'mcy_yungou.huode_id',
              'mcy_yungou.huode_order_time',
              'mcy_yungou.huode_ma',
              ); 
        switch ($type) {
          case 0:
            if ($number > 30 ) {$number = 10201030;  $response->code = 4;$response->count = 0;}else{}
            $listItems = McyYunGouOrder::join('mcy_product','mcy_product.product_id','=','mcy_yungou_order.product_id')
                                         ->join('mcy_yungou',function($join){
                                            $join->on("mcy_yungou.qishu",'=','mcy_yungou_order.qishu');
                                            $join->on("mcy_yungou.product_id",'=','mcy_yungou_order.product_id');
                                          })
                                         ->where('mcy_yungou_order.mcy_user_id',$mcy_user->mcy_user_id)
                                         ->select($select)
                                         ->orderBy('mcy_yungou_order.created_at','desc')
                                         ->skip(($number - 10))->take(10)
                                         ->get();
            foreach($listItems as  $key => $value)
            {
              if (!($value->huode_id == ''))
              {
                $value->codeState = 3;
                $huode = McyUser::where('mcy_user_id',$value->huode_id)->where('is_delete',0)->first();
              }
              $value->shopid = $value->product_id;
              $value->thumb = $value->product_img;
              $value->LoadPic = $value->product_img;
              $value->qishu = $value->qishu;
              $value->title = $value->product_name;
              $value->money = $value->product_price;
              $value->q_uid = @$huode->mcy_user_id;
              $value->q_user = @$huode->username;
              $value->q_user_code = $value->huode_ma;
              $value->zongrenshu = $value->zongshu;
              $value->canyurenshu = $value->shenyurenshu;
            }
            $response->listItems = $listItems;
            if (count($listItems) > 0)
            {
              $response->code = 0;
            }else{
              $response->code = 4;
              $response->count = 0;
            }
            break;
          case 1:
           // $listItems = McyYunGouOrder::join('mcy_product','mcy_product.product_id','=','mcy_yungou_order.product_id')
           //                               ->join('mcy_yungou',function($join){
           //                                  $join->on("mcy_yungou.qishu",'=','mcy_yungou_order.qishu');
           //                                  $join->on("mcy_yungou.product_id",'=','mcy_yungou_order.product_id');
           //                                })
           //                               ->where('mcy_yungou.huode_id',$mcy_user_id)
           //                               ->where('mcy_yungou_order.mcy_user_id',$mcy_user_id)
           //                               ->select($select)
           //                               ->orderBy('mcy_yungou_order.created_at','desc')
           //                               ->skip(($number - 10))->take(10)
           //                               ->get();
           if ($number > 20 ) {$number = 10201030;  $response->code = 4;$response->count = 0;}else{}
            $listItems = McyYunGou::join('mcy_product','mcy_product.product_id','=','mcy_yungou.product_id')
                                                          ->join('mcy_yungou_order','mcy_yungou_order.go_id','=','mcy_yungou.huode_order_id')
                                                          ->where('mcy_yungou.huode_id',$mcy_user_id)
                                                          ->select($select)
                                                          ->orderBy('mcy_yungou_order.created_at','desc')
                                                          ->skip(($number - 10))->take(10)
                                                          ->get();
            foreach($listItems as  $key => $value)
            {
              if (!($value->huode_id == ''))
              {
                $value->codeState = 3;
                $huode = McyUser::where('mcy_user_id',$value->huode_id)->where('is_delete',0)->first();
              }
              $value->shopid = $value->product_id;
              $value->thumb = $value->product_img;
              $value->LoadPic = $value->product_img;
              $value->qishu = $value->qishu;
              $value->title = $value->product_name;
              $value->money = $value->product_price;
              $value->q_uid = @$huode->mcy_user_id;
              $value->q_user = @$huode->username;
              $value->q_user_code = $value->huode_ma;
              $value->zongrenshu = $value->zongshu;
              $value->canyurenshu = $value->shenyurenshu;
              $value->q_end_time = $value->huode_order_time;
            }
           $response->listItems = $listItems;
           if (count($listItems) > 0)
           {
            $response->code = 0;
           }else{
            $response->code = 4;
           }
            break;
          case 2:
            $listItems = McyShaiDan::where('mcy_user_id',$mcy_user->mcy_user_id)->where('is_delete',0)->get();
            foreach($listItems as $item)
            {
              $item->sd_id = $item->shaidan_id;
              $item->sd_title = $item->title;
              $item->sd_time = $item->created_at;
              $item->imgpath = $item->shaidan_img;
            }
            $response->listItems = $listItems;
            $response->code = 0;
            break;          
          default:

            break;
        }
        return $response->toJson();

      }


      public function indexLotteryGet(Request $request)
      {
        $response = new ApiResponse;

        $gid = $request->input('gid');
        $number = $request->number?$request->number:20;
        $page = $request->page?$request->page:1;
        $error = 0;
        if ($gid == '')
        {
          $yungou_shop = McyYunGou::where('is_delete',0)->where('show_time','>',0)->orderBy('show_time','desc')->first();
          $flag = 1;
        }else{
          $yungou_shop = McyYunGou::where('yungou_id',$gid)->where('is_delete',0)->first();
          $flag = 0;
        }
        if ($yungou_shop)
        {          
        }else{
          $response->listItems = '';
          $response->error =1 ;
          return $response->toJson();
        }
        $date = @$yungou_shop->show_time;
        $response->date = $date;
        // $date = date("Y-m-d H:i:s");
        if ($flag == 1)
        {
          $listItems = McyYunGou::where('is_delete',0)->where('show_time','>',$date)->orderBy('show_time','desc')->limit(4)->get();
        }else{
          $listItems = McyYunGou::where('is_delete',0)->where('show_time','>',$date)->orderBy('show_time','desc')->limit(4)->get();
        }
        $newgid = $gid;
        foreach($listItems as $item)
        {
          @$mcy_user = McyUser::where('is_delete',0)->where('mcy_user_id',$item->huode_id)->first();
         $product = McyProduct::where('product_id',$item->product_id)->first();
         $item->id = $item->product_id;
         $item->yid = $item->yungou_id;
         $item->thumb_style = '';
         $item->LoadPic = '/favicon.ico';
         $item->thumb = $product->product_img;
         $item->qishu = $item->qishu;
         @$item->username = $mcy_user->username;
         $item->title = $product->product_name;
         $item->shop_money = $product->product_price;
         $item->times = strtotime($item->show_time) - strtotime(date('Y-m-d H:i:s'));
         $newgid = $item->yungou_id;
        }
        $response->error = $error;
        $response->newgid = $newgid;

        if (count($listItems) == 0) {$response->error = 1;}
        $response->listItems = $listItems;
        return $response->toJson();
      }


      public function apiProductSetHot(Request $request)
      {
        $response = new ApiResponse;
        $product_id = $request->input('product_id');
        $hot = $request->input('hot');
        if ($hot == 0){ $hot = 1;}else{$hot = 0;}
        $data = array(
            'hot'=> $hot
          );
        $model = 'App\Model\McyProduct';
        $search = array(
            'product_id' => $product_id,
            'is_delete' => 0
          );
        $result = $response->update($model,$search,$data);
        @$response->hot = $hot;
        @$response->obj = '';
        return $response->toJson();
      }
      public function apiProductSetSort(Request $request)
      {
        $response = new ApiResponse;
        $product_id = $request->input('product_id');
        $sort = $request->input('sort',0);
        $response->s  =  $sort;
        if (! ($sort  == 'welkin' )){
         // $sort = 1;
          $top = McyProduct::where('is_delete',0)->orderBy('sort','desc')->first();
          $response->top = $top;
          $sort = $top->sort + 1;  
        }else{
          $sort = 0;
        }
        $data = array(
            'sort'=> $sort
          );
        $model = 'App\Model\McyProduct';
        $search = array(
            'product_id' => $product_id,
            'is_delete' => 0
          );
        $result = $response->update($model,$search,$data);
        @$response->sort = @$response->obj->sort;
        @$response->obj = '';
        return $response->toJson();
      }
      public function apiIndexProductGet(Request $request)
      {
        $response = new ApiResponse;
        $order = $request->order;
        $page = $request->page;
        $number = $request->input('num');
        $response->shoplist = array();
        switch ($order) {
          case 20:
            /* 人气 */
                $products = McyProduct::where('user_id',$this->user_id)->where('is_delete',0)->where('product_type',1)->where('hot',1)->skip( ($page -1) * $number )->take($number)->get();
                foreach($products as $key => $product)
                {
                  $yungou_shop = McyYunGou::where('product_id',$product->product_id)->where('is_delete',0)->where('qishu',$product->go_now_qishu)->first();
                  if ($yungou_shop->shenyurenshu == 0)
                  {
                    unset($products[$key]);
                  }else{
                    $product->has_go = @$yungou_shop->shenyurenshu;
                    $product->level_go = @$product->go_number - $product->has_go;
                  }
                }
                $response->shoplist = $products;
            break;
            
          default:
            break;
        }
        return $response->reply(0,'获取成功');
      }
}
