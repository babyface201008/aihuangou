@extends('mcy.layout')
@section('title','收银台')
@section('my-css')
<link href="/chyyg1/cartList.css" rel="stylesheet" type="text/css">
<style>
        .loading-cartlist-title {
        font-size: 150%;
        text-align: center;
    }
    .g-Total-bt {
        margin-left: -10px;
    }
</style>
@endsection
@section('content')
    <section class="flow">
        <div class="img"><img src="/chyyg1/flow.jpg"></div>
        <div class="info">
            <h3 class="title">流量礼包-{{@$site->site_name}}专享</h3>
            <div class="txt">购买流量礼包, 赢取商品(1元0.1M流量)</div>
            <div class="txt">购买 <span class="orange">{{@$all_price}}</span> 人次<i class="tips" id="buyTips"></i></div>
        </div>
    </section>
<section class="clearfix g-pay-lst">
    @if($all_price > 0)

    <ul>
        <li style="padding: 5px 10px;">将获取以下活动商品{{@$all_price}}个参与号码</li>
        @foreach($cartlists as $cartlist)
        <li>
            <a href="{{Request::root()}}/product?product_id={{$cartlist['product_id']}}" class="gray6">(第{{$cartlist['qishu']}}期){{$cartlist['product']->product_name}}</a>
            <span>
                <em class="orange arial">￥{{$cartlist['yungou_shop']->price * $cartlist['number']}}</em>
            </span>
        </li>
        @endforeach
    </ul>
    <p class="g-pay-Total gray9"> 合计：<span class="orange arial Fb F16" id="hongbao_jg">￥{{@$all_price}}</span> 元</p>
    <p class="g-pay-bline" style="background:url('/chyyg1/setIcon.png')"></p>
        <input name="hidShopMoney" type="hidden" id="hidShopMoney" value="{{@$all_price}}">
        <input name="hidShopScore" type="hidden" id="hidShopScore" value="{{$all_price}}">

        <input name="hidBalance" type="hidden" id="hidBalance" value="{{@$mcy_user->money}}">
        <input name="hidPoints" type="hidden" id="hidPoints" value="{{@$mcy_user->score}}">
        <input name="pointsbl" type="hidden" id="pointsbl" value="0">
        <input name="useBalance" type="hidden" id="useBalance" value="">
        <input name="useFufen" type="hidden" id="useFufen" value="0">
</section>
<section class="clearfix g-Cart">
    <article class="clearfix m-round g-pay-ment">
        <ul id="ulPayway">
            <li class="gray6 z-pay-ff z-pay-grayC">
                <i id="spPoints" class="z-pay-ment" sel="0"></i>
                <span>使用福分（您的福分：{{@$mcy_user->score}}）
                <span style="text-overflow:clip; overflow:scroll; white-space:normal">抵扣<span style="color:red" id="fm">0.00</span>元</span>
                </span>
            </li>
            <li class="gray6 z-pay-ye z-pay-grayC">
                <i id="spBalance" class="z-pay-ment" sel="0"></i>
                <span>您可以使用余额付款（账户余额：{{@$mcy_user->money}}元）</span>
            </li>
            <li class="gray6 z-pay-ye z-pay-grayC">
                <a href="{{Request::root()}}/mcy/user/topup" class="z-pay-Recharge">去充值</a>
                <span style="color: #dc332d">低于10元请前往充值后使用余额支付</span>
            </li>
        {{--@if (@$mcy_user->score >= $all_price * $site->score_money)
            <li class="gray6 z-pay-ff z-pay-grayC">

                <a href="{{Request::root()}}/user/chaofen/pay" class="z-pay-Recharge">去支付</a>
                <span>使用福分为(您的福分: {{@$mcy_user->score}})</span>
            </li>
            @else
            <li class="gray6 z-pay-ff z-pay-grayC">
                <span>您的福分不足（您的福分：{{@$mcy_user->score}}）</span>
            </li>
            @endif
            @if(@$mcy_user->money < $all_price)
            <li class="gray6 z-pay-ye z-pay-grayC">
                <a href="{{Request::root()}}/mcy/user/topup" class="z-pay-Recharge">去充值</a>
                <span>您的余额不足（账户余额：{{@$mcy_user->money}}元）</span>
            </li> 
            @else
            <li class="gray6 z-pay-ye z-pay-grayC">
                <a href="{{Request::root()}}/user/chaobi/pay" class="z-pay-Recharge">去支付</a>
                <span>您可以使用余额付款（账户余额：{{@$mcy_user->money}}元）</span>
            </li> 
            @endif--}}
        </ul>
    </article>
    <div class="g-Total-bt g-Pay-new">
{{--    @if ($mcy_user->money < $all_price)
    <dd><a href="{{Request::root()}}/mcy/user/topup" class="orgBtn fr w_account noMoney">余额不足，请前往充值</a></dd>
    @else
    @endif--}}

        <dd><a href="{{Request::root()}}/user/chaobi/pay" id="btnPay" class="orgBtn fr w_account noMoney">确认支付</a></dd>

        {{--<dd><a href="{{Request::root()}}/mcy/user/topup" class="greenBtn fr w_account noMoney">微信支付</a></dd>--}}
</div>
@else
<div class="loading-cartlist">

    <div class="loading-cartlist-img">
        <img src="/chyyg1/loading.gif" alt="加载中">
    </div>
    <div class="loading-cartlist-title">
        您的购物车没有货物哟！！！！赶紧去抢购吧！
    </div>
</div>
@endif
</section>

@endsection

@section('my-js')
    <script src="/chyyg1/paymentFun.js" language="javascript" type="text/javascript"></script>
@endsection
