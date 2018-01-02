@extends('mcy.layout')
@section('title','分享享优惠')
@section('my-css')
<link href="/chyyg1/invitehome.css" rel="stylesheet" type="text/css">
<link href="/chyyg1/static/invite.css" rel="stylesheet" type="text/css">
<style>
  .pro_foot {
        margin-bottom: 50px;
  }
</style>
@endsection
@section('content')
<div id="wrapper">
    <div class="inv-ad">
        <img src="/chyyg1/int-ad110.jpg">
    </div>

    <div class="inv-con clearfix gray9">
        <ul>
            <li><a class="orgBtn fancybox.image"
                   href="{{Request::root()}}/mcy/user/my_code" title="长按复制我的邀请链接:<br>{{Request::root()}}/invite/friend/{{$mcy_user->mcy_user_id}}" id="btnQRCode">二维码分享</a></li>
            <li><a class="orgBtn" href="javascript:;" id="btnShare">立即赚钱</a></li>
        </ul>
    </div>

    <div class="inv-count clearfix">
        <ul>
            <li>
                <em class="orange">{{@$slave_count}}</em>
                <i class="gray9">邀请好友</i>
            </li>
            <li>
                <em class="orange">￥{{$mcy_user->slave_money}}</em>
                <i class="gray9">佣金余额</i>
            </li>
        </ul>
    </div>

    <div class="ann_btn">
        <a href="{{Request::root()}}/mcy/user/invite/history">邀请记录</a>
        <a href="{{Request::root()}}/mcy/user/withdraw/list">提现记录</a>
        <a href="{{Request::root()}}/mcy/user/duihuan/list">兑换福分记录</a>
        <a href="{{Request::root()}}/mcy/user/yongjing/list">佣金记录</a>

    </div>

    <div class="pro_foot">
        <ul>
            <li><a class="orgBtn" href="{{Request::root()}}/mcy/user/invite/fubiwithdraw/" >福分提现</a></li>
            <li class="border-orange-Btn sharetomoney"><a href="javascript:;">分享充值</a></li>

        </ul>
    </div>
</div>

<div id="mcover" class="m-popup">
    <img src="/chyyg1/0.png">
</div>
@endsection

@section('my-js')

@endsection