@extends('mcy.layout')
@section('title','title')
@section('my-css')
    <link href="/chyyg1/static/star.css" rel="stylesheet" type="text/css">
    <style>
    .userinfo-text{
            background-position: -34px 0;
    }
    .mBanner li span {
        color: #fefefe;
        margin-left: 8px;
        margin-top: 16px;
    }
    .Progress-bar .Pro-bar-li li.P-bar03 {
        width: 30%;
        float: right;
        text-align: center !important; 
    }
    </style>
@endsection
@section('content')
 <div class="mainCon" id="loadingPicBlock"> 
            <div class="mBanner">
                <ul>
                    <li class="mUserHead"><img src="{{@$mcy_user->avator_img?$mcy_user->avator_img:'/chimg1.png'}}"></li>
                    <li class="mUserInfo">
                        <p>{{@$mcy_user->username}}</p><br><span class="z-class-icon03"><s></s> <span class="userinfo-text">
                        @if (@$mcy_user->is_robot == 1 )
                        快购中将
                        @elseif (@$mcy_user->jingyan > 100000 )
                        快购神将
                        @elseif (@$mcy_user->jingyan > 50000 )
                        快购大将
                        @elseif (@$mcy_user->jingyan > 10000 )
                        快购中将
                        @else 
                        快购小将
                        @endif
                        </span></span></li>
                </ul>
            </div>
            <input name="hdUserID" type="hidden" id="hdUserID" value="{{@$mcy_user->mcy_user_id}}" />
            <div class="g-snav" id="divMidNav">
                <span class="g-snav-lst mCurr"><a href="javascript:void(0);">快购记录</a></span>
                <span class="g-snav-lst"><a href="javascript:void(0);">获得的商品</a></span>
                <span class="g-snav-lst"><a href="javascript:void(0);">晒单</a></span>
            </div>
            <!--快购记录-->
            <div id="divBuyRecord" class="mBuyRecord">
                <!-- <ul onclick="location.href=&#39;/v40/product/12519167.do&#39;">
                    <li class="mBuyRecordL"><img src="./static/20160530170705441.jpg"></li>
                    <li class="mBuyRecordR"><span class="title">(第13809快)中国黄金 薄片财富金条 Au9999 20g</span>
                        <p class="mValue">价值：￥6600.00</p><span>本快参与：10人次<br>获得者：<a style="color: #22AAff" href="http://weixin.1yyg.com/v40/userpage/1016159281">相望于夺宝gy求给力</a><br>幸运快购码：<em class="orange">10006377</em></span></li>
                </ul> -->
                <!-- <div class="g-suggest clearfix">最近三个月无更多记录啦！</div> -->
            </div>
            <!--获得商品-->
            <div id="divGetGoods" class="mBuyRecord" style="display: none"></div>
            <!--晒单-->
            <div id="divSingle" class="mSingle" style="display: none"></div>
            <!--正在加载-->
            <div id="divLoading" class="loading clearfix g-acc-bg" ><b></b></div>

        </div>
@endsection
@section('my-js')
<script type="text/javascript">
</script>
<script language="javascript" type="text/javascript" src="/chyyg1/BottomFun.js"></script>
<script language="javascript" type="text/javascript" src="/chyyg1/static/userindexFun.js?v=20170802"></script>

@endsection
