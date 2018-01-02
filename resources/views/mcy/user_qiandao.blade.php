@extends('mcy.layout')
@section('title','签到有礼')
@section('my-css')
<link href="/chyyg1/invitehome.css" rel="stylesheet" type="text/css">
<style type="text/css">
  body{
    color: white;
  }
  .qiandao_list li {
    border-top: 1px solid #dedede;
    /*border-bottom: 1px solid #dedede;*/
  }
  .inv-day {
    top: 20px;
    position: absolute;
    width: 100%;
    text-align: center;
  }
  .inv-day-img {
    width: 200px;
    height: 200px;
  }
  .inv-day-text {
    position: absolute;
    color: red;
    top: 76px;
    font-size: 40px;
    left: 157px;
  }
  .circle-red0 {
    width: 10px;
    height: 10px;
    border-radius: 5px;
    position: absolute;
    top: 265px;
    left: 22px;
    background-color: red;
  }
  .circle-red1 {
    width: 10px;
    height: 10px;
    border-radius: 5px;
    position: absolute;
    top: 265px;
    left: 74px;
    background-color: red;
  }
  .circle-red2 {
    width: 10px;
    height: 10px;
    border-radius: 5px;
    position: absolute;
    top: 265px;
    left: 124px;
    background-color: red;
  }
  .circle-red3 {
    width: 10px;
    height: 10px;
    border-radius: 5px;
    position: absolute;
    top: 265px;
    left: 179px;
    background-color: red;
  }
  .circle-red4 {
    width: 10px;
    height: 10px;
    border-radius: 5px;
    position: absolute;
    top: 265px;
    left: 230px;
    background-color: red;
  }
  .circle-red5 {
    width: 10px;
    height: 10px;
    border-radius: 5px;
    position: absolute;
    top: 265px;
    left: 283px;
    background-color: red;
  }
  .circle-red6 {
    width: 10px;
    height: 10px;
    border-radius: 5px;
    position: absolute;
    top: 265px;
    left: 331px;
    background-color: red;
  }
</style>
@endsection
@section('content')
<div id="wrapper">
    <div class="inv-ad" style="display: none;">
        @foreach($week as $key => $w)
          @if($w['check'] == 1)
          <div class="circle-red{{$key}}">
          </div>
          @else
          <!-- <div class="circle-red{{$key}}"> -->
          <!-- </div> -->
          @endif
        @endforeach
        <img src="/chyyg1/qiandao_bg.jpg">
    </div>
<!--     <dir class="inv-day">
      <span class="inv-day-text">
        {{@$d_count}}天
      </span>
      <img class="inv-day-img" src="/chyyg1/qiandao_bg_day.png">
    </dir> -->

    <div class="inv-con clearfix gray9">
<!--         <ul>
            <li><a class="orgBtn fancybox.image" href="{{Request::root()}}/chyyg1/weixin.png" title="只需好友扫描注册即算邀请成功哦^_^" id="btnQRCode">二维码分享</a></li>
            <li><a class="orgBtn" href="javascript:;" id="btnShare">立即赚钱</a></li>
        </ul> -->
        <p style="text-align: center;">
          签到记录
        </p>
    </div>

    <div class="inv-count clearfix">
        @foreach($all_qdays as $day)
          <ul class="qiandao_list">
              <li>
                  <em class="orange">{{$day->qiandao_day}}</em>
                  <i class="gray9">签到时间</i>
              </li>
              <li>
                  <em class="orange">福分：{{@$day->score}}分</em>
                  <i class="gray9">签到奖励</i>
              </li>
          </ul>
        @endforeach
    </div>

 
</div>
<div id="mcover" class="m-popup">
    <img src="/chyyg1/0.png">
</div>
@endsection

@section('my-js')
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script>
	 wx.config({
    debug: false,
    appId: 'wx8e85c04393068646',
    timestamp: 1499722076,
    nonceStr: 'qUfkVWKtSMmXk7Wv',
    signature: 'fe25005589a9a4456696507345fb60600bc8f33a',
    jsApiList: [
      'checkJsApi',
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
        'onMenuShareQQ',
        'onMenuShareWeibo',
        'onMenuShareQZone',
        'chooseImage',
        'previewImage',
        'uploadImage',
        'downloadImage'
    ]
  });
  wx.ready(function () {
    // 在这里调用 API
     var images = {
            localId: [],
            serverId: [],
            downloadId: []
        }; 
    //分享朋友监听
    wx.onMenuShareAppMessage({
      title: '潮惠快够-惊喜无限',
      desc: '潮惠快够是一种新型的互动购物方式，赶紧来挑战吧！',
      link: '{{Request::root()}}/invite/freind_r/{{@$mcy_user->mcy_user_id}}',
      imgUrl: '{{@$mcy_user->avator_img}}',
       
    });
    
    //分享朋友圈
     wx.onMenuShareTimeline({
      title: '潮惠快够-惊喜无限',
       link: '{{Request::root()}}/invite/freind_r/{{@$mcy_user->mcy_user_id}}',
      imgUrl: '{{@$mcy_user->avator_img}}',
       
    });
    // 2.3 监听“分享到QQ”按钮点击、自定义分享内容及分享结果接口
    wx.onMenuShareQQ({
      title: '潮惠快够-惊喜无限',
      desc: '潮惠快够是一种新型的互动购物方式，赶紧来挑战吧！',
      link: '{{Request::root()}}/invite/freind_r/{{@$mcy_user->mcy_user_id}}',
      imgUrl: '{{@$mcy_user->avator_img}}',
       
    });
    
    // 2.4 监听“分享到微博”按钮点击、自定义分享内容及分享结果接口
 
    wx.onMenuShareWeibo({
      title: '潮惠快够-惊喜无限',
      desc: '潮惠快够是一种新型的互动购物方式，赶紧来挑战吧！',
      link: '{{Request::root()}}/invite/freind_r/{{@$mcy_user->mcy_user_id}}',
      imgUrl: '{{@$mcy_user->avator_img}}',
       
    });
  });
   $("#btnShare").click(function(){ // 分享给好友按钮触动函数
        $("#mcover").show().click(function(){
            $(this).hide();
        })
    });
    $("#btnQRCode").fancybox({
        openEffect  : 'none',
        closeEffect	: 'none',
        closeClick : true,
    });
</script>
@endsection