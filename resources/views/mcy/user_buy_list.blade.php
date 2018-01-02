@extends('mcy.layout')
@section('title','我的快购记录')
@section('my-css')
     <style type="text/css">
     	.noRecords {
     		text-align: center;
     		font-size: 14px;
     		padding: 50px 0;
     	}

     	.noRecords s {
     		display: block;
     		margin: 0 auto 10px;
     		width: 105px;
     		height: 90px;
     	}

     	.noRecords .z-use {
     		font-size: 14px;
     		padding: 15px;
     	}
          @charset "utf-8";
.mainCon{width:100%;margin:0 auto;overflow:hidden;}
.mBanner{background:#049 url(../images/banner.jpg?v=130726) right no-repeat;background-size:320px auto;}
.mBanner ul{height:53px;margin:0 auto;padding:16px 10px;}
.mBanner li.mUserHead{width:48px;height:48px!important;margin-right:8px;border-radius:3px;border:3px solid #fff;box-shadow:1px 1px 2px #330511;background:#fff;overflow:hidden;}
.mBanner li.mUserHead img{width:48px;height:48px;border-radius:2px;}
.mBanner li.mUserInfo{margin-left:60px;position:relative;top:-55px;color:#fefefe;font-size:12px;line-height:18px;}
.mBanner li p{font-size:16px;word-wrap:break-word;margin-right:3px;display:inline-block;}
.mBanner li b{color:#fff;display:inline-block;}
.mBanner li span{color:#fefefe;margin-left:10px;}
.g-snav{width:100%;height:40px;line-height:40px;background:#f4f4f4;box-shadow:0 1px 2px #e6e6e6;font-size:14px;overflow:hidden;}
.g-snav .g-snav-lst{display:block;text-align:center;border-right:1px solid #bbb;border-bottom:1px solid #bbb;overflow:hidden;}
.g-snav .g-snav-lst a{display:block;color:#666;border-left:1px solid #fff;border-top:0 none;margin-bottom:10px;}
.g-snav span.mCurr{background:#fff;border-bottom:2px solid #dc332d;}
.g-snav span.mCurr a{color:#dc332d;}
.mBuyRecord{clear:both;width:100%;background:#fff;overflow:hidden;}
.mBuyRecord ul{padding:10px 8px;border-top:#eee 1px solid;position:relative;margin-top:-1px;}
.mBuyRecord ul:after{content:"\0020";display:block;height:0;clear:both;}
.mBuyRecord li.mBuyRecordL{float:left;width:80px;position: relative;}
.mBuyRecord li img{width:80px;height:80px;display:inline-block;overflow:hidden;}
.mBuyRecord li.mBuyRecordR{position:relative;margin-left:90px;color:#666;line-height:18px;text-align:left;}
.mBuyRecord li.mBuyRecordR a{color:#666;}
.mBuyRecord li.mBuyRecordR p.mValue{color:#bbb;}
.mBuyRecord li.mBuyRecordR span{color:#999;}
.mBuyRecord .mBuyRecordR .pRate{height:42px;margin-top:10px;position:relative;}
.mBuyRecord .Progress-bar ul{padding:0;width:100%;border:0 none;margin:0;}
.mBuyRecord .Progress-bar .Pro-bar-li li em{padding:0;}
.mSingle{color:#666;font-size:14px;overflow:hidden;}
.mSingle li{position:relative;border-top:1px solid #eee;margin-top:-1px;}
.share-score {
    position: absolute;
    width: 60px;
    height: 60px;
    right: 5px;
    top: 5px;
    line-height: 87px;
    font-size: .9rem;
    font-weight: 600;
    text-align: center;
    text-indent: 10px;
    background: transparent url('/statics/templates/ffxiang/images/sdScore.png') no-repeat center / 100% 100%;
    z-index: 1;
}
.mSingle li a .share-score p {color: #dc332d;overflow: visible}
.mSingle li a{display:block;padding:15px 10px;}
.mSingle li a p{color:#999;max-height:45px;overflow:hidden;}
.mSingle h3{margin-bottom:5px;}
.mSingle a h3 b{font-size:14px;margin-right:5px;color:#666;}
.mSingle a h3 em{font-style:normal;color:#bbb;font-size:10px;display:inline-block;word-break:keep-all;white-space:nowrap;}
.mSingle dl{margin-left:-5px;height:85px;overflow:hidden;}
.mSingle img{height:80px;margin:3px;border:1px solid #e7e7e7;}
/*特殊商品样式*/
.jiexiao { 
    content: " ";
    display: block;
    position: absolute;
    /*background: transparent url("/chyyg1/cart_mask.jpg?20170921") no-repeat 0 -40px / 40px 120px;*/
    text-align: center;
    bottom: 0;
    right: 0;
    color: red;
}
.jinxingzhong {
    content: " ";
    display: block;
    position: absolute;
    /*background: transparent url("/chyyg1/cart_mask1.jpg?20170921") no-repeat 0 0 / 40px 120px;*/
    text-align: center;
    bottom: 0;  
    right: 0;
    color: #101010;
}
.orange {
    color: #dc332d;
    max-height: 100px;
    overflow: hidden;
    display: block;
}
.show_all_orange span {
    text-align: center;
    border: #333 solid 1px;
    width: 100px;
    margin-bottom: 5px;
    display: inline-block;
}
.show_all_orange {
    text-align: center;
}
     </style>
@endsection
@section('content')
@if(count($buylist) == 0)
<div id="divBuyList" class="m_buylist m_buylist_n">
	<ul id="ul_list">
		<div class="noRecords colorbbb clearfix">
			<s class="z-y8"></s>最近还没有参与快购？<br> 梦想与您只有1元的距离！~
          </div>
     </ul>
     <div id="divLoading" class="loading clearfix g-acc-bg" style="display: none;"><b></b>正在加载</div>
</div>
@else
     <div id="divBuyRecord" class="mBuyRecord">
        @foreach($buylist as $k => $list)
        <ul onclick="location='{{Request::root()}}/going/product?product_id={{$list->product_id}}&qishu={{@$list->qishu}}'">
             <li class="mBuyRecordL "><img src="{{@$list->product_img}}">
             @if($list->huode_id > 0 )
             <i class="jiexiao">已揭晓</i>
             @else
             <i class="jinxingzhong">进行中</i>
             @endif
             </li>
             <li class="mBuyRecordR">(第{{@$list->qishu}}期){{@$list->product_name}}<p class="mValue">价值：￥{{@$list->product_price}}</p><span><br>快购码：<em class="orange orange{{$list->product_id}}{{@$list->qishu}}{{$k}}" style="word-wrap: break-word;">
             @foreach(explode(",",$list->yungouma) as $key => $ma) @if($key ==0) @else , @endif {{1000000 + $ma}} 
             @endforeach</em></span></li>
        </ul>
        <div class="show_all_orange" kid="{{$list->product_id}}{{@$list->qishu}}{{$k}}">
            <span>查看所有快购码</span>
        </div>
        @endforeach
   </div>
@endif
@endsection
@section('my-js')
 <script type="text/javascript">
    $(".f_personal  > a").addClass("hover");
    $(".show_all_orange").on('click',function(){
        if ($(this).hasClass('hide_all_orange')){
            $(this).removeClass('hide_all_orange');
            $(".orange"+ kid).css('max-height', '100px !important');
        }else{
            var kid = $(this).attr('kid');
            $(".orange"+ kid).css('max-height', '2000px');
            $(this).addClass('hide_all_orange');
        }  
    });
</script>
@endsection
