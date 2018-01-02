@extends('mcy.layout')
@section('title','充值')
@section('my-css')
    <link rel="stylesheet" href="/chyyg1/top.css">
    <link rel="stylesheet" href="/chyyg1/member.css">
    <style>
    #fbox{ position:fixed; right:0; bottom:55px; z-index:100; }
    #fbox ul,#fixedNav{ background-color:rgba(0,0,0,0.5); border-top-left-radius:5px; border-bottom-left-radius:5px; }
    #fbox ul{ width:40px; }
    #top{ display:none; }
    #fixedNav{ width:94px; padding:0 10px; position:absolute; top:-295px; right:0; z-index:101; display:none; }
    #fbox a{ display:block; width:100%; height:40px; line-height:40px; font-size:14px; color:#fff; overflow:hidden; border-bottom:1px solid rgba(255,255,255,.21); }
    #fixedNav a:nth-last-child(1){ border:none; }
    #fbox a i{ display:inline-block; background:url(http://weixin.sz1yyg.com/statics/templates/quyu-1yygkuan/images/mobile/f_nav_icon.png) no-repeat center center; }
    #fbox ul a i{ width:30px; height:30px; background-size:30px; position:relative; top:5px; left:6px; }
    #fixedNav a i{ width:19px; height:19px; background-size:19px; margin-right:5px; position:relative; top:9px; }
    #fbox #spreadNav{ background-position:1px 1px !important; }
    #fbox #totop{ background-position:0px -30px !important; }
    #fbox #fixed_index{ background-position:0px -35px !important; }

    #fbox #fixed_user{ background-position:0px -56px !important; }
    /*#fbox #fixed_qiaodao{ background-position:1px -170px !important; }*/
    #fbox #fixed_lottery{ background-position:0px -75px !important; }
    #fbox #fixed_shaidan{ background-position:0px -93px !important; }
    #fbox #fixed_szyg{ background-position:0px -113px !important; }
    #fbox #empty { background-position: 0px -153px !important; }
    #fbox #fixed_reload{ background-position:0px -131px !important; }
    #fixedNav:after{ content:''; display:block; width:0; height:0; border:6px solid transparent; border-top-color:rgba(0,0,0,.5); position:absolute; bottom:-12px; right:13px; }
    /*引导分享*/
    .share-guide{ width:100%; height:100%; position:fixed; top:0; z-index:1000; display:none; }
    .s-guide{ display:block; width:100%; height:100%; background:#000; opacity:0.8; filter:progid:DXImageTransform.Microsoft.Alpha(opacity=80); position:absolute; top:0; left:0; z-index:98; }
    .share-guide cite{ display:block; background:url(/images/share_03.png?v=1105) top right no-repeat; background-size:273px auto; height:230px; margin:10px 10px 0 0; position:relative; z-index:99; }
    a.redBtn {
    	width: 40%;
    	height: 45px;
    	line-height: 45px;
    	border-radius: 8px;
    }
    a.orgBtn, a.redBtn {
    	background: #dc332d;
    	border: 1px solid #dc332d;
    	margin: auto;
    }
    .grayBtn, .orgBtn, .redBtn {
    	display: block;
    	width: 100%;
    	-webkit-box-sizing: border-box;
    	height: 40px;
    	line-height: 40px;
    	text-align: center;
    	color: #fff!important;
    	border-radius: 5px;
    	font-size: 15px;
    }
    .z-sel {
        border: 1px solid #dc332d;
        color: #5c5c5c;
    }
    .qorange {
       color: white !important;
       background-color: #dc332d !important
    }
  </style>

@endsection
@section('content')
  <div class="g-Total gray9">您的当前余额：<span class="orange arial">{{number_format(@$mcy_user->money,2) }}</span>元</div>
<section class="clearfix">
	<div class="g-Recharge">
		<ul id="ulOption">
			<li><a money="50"   class="top_money" href="javascript:;" >50元<s></s></a></li>
			<li><a money="100"  class="top_money" href="javascript:;">100元<s></s></a></li>
			<li><a money="500"  class="top_money" href="javascript:;">500元<s></s></a></li>
			<li><a money="1000" class="top_money" href="javascript:;">1000元<s></s></a></li>
                                            <li><b><input type="text" class="z-init" placeholder="最低10元" maxlength="8"><s></s></b></li>
			<li><a class="qorange">确认</a></li>
		</ul>
	</div>
	<article class="clearfix m-round g-pay-ment g-bank-ct">
		<ul id="ulBankList">
			<li class="gray6">选择平台充值<em class="corange orange"></em>元</li>
            @foreach($payinfos as $key => $payinfo)
            @if ($key == 0)
            <li class="gray9"><i pid="{{$payinfo->payinfo_id}}" class="z-bank z-bank-Round z-bank-Roundsel"><s></s></i>{{$payinfo->pay_name}}</li>
            @else
			<li class="gray9"><i pid="{{$payinfo->payinfo_id}}" class="z-bank z-bank-Round"><s></s></i>{{$payinfo->pay_name}}</li>
            @endif
            @endforeach
		</ul>
	</article>
	<div class="mt10 f-Recharge-btn">
		<a id="btnSubmit" href="javascript:;" class="redBtn checkok">确认充值</a>
	</div>
</section>
<!-- 引导分享朋友圈 -->
<div class="share-guide"><div class="s-guide"></div><cite></cite></div>
<script>
    $(function(){
        $('#btn-share').click(function(){
            $('.share-guide').show();
        });
        $('.share-guide').click(function(){
            $('.share-guide').hide();
        });
    });
</script>
@endsection

@section('my-js')
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script type="text/javascript">
    $(".top_money").on('click',function(){
         $(".top_money").removeClass('z-sel');
         $(this).addClass('z-sel');
         var money = $(this).attr('money');
         $(".corange").text(money);
    });
    $(".z-init").change(function(){
        var money = $(this).val();
         $(".corange").text(money);
    });
    $('.qorange').on('click',function() {  
        var money = $('.z-init').val();
        $(".corange").text(money);
    });  
    $(".checkok").on('click',function(){
        /* 判断金额 */
        var money = $(".corange").text();
        // console.log(money);
        if (money < 10)
        {
            alert("金额不能少于10元");
            return false;
        }else{
            var pid = $(".z-bank-Roundsel").attr('pid');
            if (pid == 14){
                location.href = 'http://yyg2.chkg66.com' + '/mcy/topup/pay/'+pid+ '/'+ money +'?openid={{$mcy_user->openid}}';
            }else{
                location.href = '/mcy/topup/pay/'+pid+ '/'+ money;
            }
        }
    });
    $(".z-bank").on('click',function(){
        $(".z-bank").removeClass('z-bank-Roundsel');
        $(this).addClass('z-bank-Roundsel');
    });
</script>
@endsection