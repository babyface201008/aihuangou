@extends('mcy.layout')
@section('title','地址管理')
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
.mBuyRecord ul li.limit::after { /*限购商品*/
    content: " ";
    display: block;
    position: absolute;
    width: 40px;
    height: 40px;
    background: transparent url("/images/cat_mark.png?20170605") no-repeat 0 -40px / 40px 120px;
    bottom: 0;
    right: 0;
}
.mBuyRecord ul li.double::after { /*二人云购*/
    content: " ";
    display: block;
    position: absolute;
    width: 40px;
    height: 40px;
    background: transparent url("/images/cat_mark.png?20170605") no-repeat 0 0 / 40px 120px;
    bottom: 0;
    right: 0;
}
.mBuyRecord ul li.three::after { /*幸运123*/
    content: " ";
    display: block;
    position: absolute;
    width: 40px;
    height: 40px;
    background: transparent url("/images/cat_mark.png?20170605") no-repeat 0 -80px / 40px 120px;
    bottom: 0;
    right: 0;
}
.address_create_btn {
    width: 100;
    height: 20px;
    line-height: 20px;
    background-color: #234234;
    color: white;
    position: absolute;
    bottom: 52px;
}
.address_create_btn  button {
    position: fixed;
    bottom: 54px;
    background-color: #dc332d;
    width: 100%;
    border: 1px solid #fff;
    text-align: center;
    line-height: 50px;
    color: white;
    font-size: 20px;
    min-height: 50px;
    border-radius: 5px;
}
.red {
    color: red;
}
/**/
     </style>
@endsection
@section('content')
@if(count($address) == 0)
<div id="divBuyList" class="m_buylist m_buylist_n">
	<ul id="ul_list">
		<div class="noRecords colorbbb clearfix">
			<s class="z-y8"></s>还没有地址？<br> 赶紧填写吧！~
          </div>
     </ul>
     <div id="divLoading" class="loading clearfix g-acc-bg" style="display: none;"><b></b>正在加载</div>
</div>
@else
     <div id="divBuyRecord" class="mBuyRecord">
          @foreach($address as $list)
        <ul @if ($list->is_set == 1) class="red" @endif onclick="location='{{Request::root()}}/mcy/user/address/update/{{@$list->address_id}}'">
             <li >联系人：{{@$list->address_people}}
             <p class="mValue">联系方式：{{@$list->address_mobile}}</p>
             <span>
             地址详情： <em class="orange" style="word-wrap: break-word;">{{@$list->address_name}}</em>
             <span>
        </ul>
        @endforeach
   </div>
@endif
<a class="address_create_btn">
     <button type="button">添加地址</button>
</a>  
@endsection
@section('my-js')
 <script type="text/javascript">
    $(".f_personal  > a").addClass("hover");
    $('.address_create_btn').on('click',function(){
        location.href = '/mcy/user/address/create';
    });
</script>
@endsection
