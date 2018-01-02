@extends('mcy.layout')
@section('title','我的二维码')
@section('my-css')
 <style>
 body {
 	background-color: #ff6766;
 }
 </style>
@endsection
@section('content')
  <img id="myImg" src="/chyyg1/my_code1.jpg" style="width:100%;display:block;" />
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