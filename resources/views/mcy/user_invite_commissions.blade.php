@extends('mcy.layout')
@section('title','明细')
@section('my-css')
    <link href="/chyyg1/static/member.css" rel="stylesheet" type="text/css">
    <link href="/chyyg1/static/invite.css" rel="stylesheet" type="text/css">
    <script src="/chyyg1/static/jquery190.js" language="javascript" type="text/javascript"></script>

@endsection
@section('content')
@extends('mcy.common.user_menu')

<div class="R-content">
    <div class="member-t"><h2>福分明细</h2></div>
    <div class="total">
        <dl>
            <dd>累计收入：<b class="orange">{{$shouru_count}}</b> 元 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</dd>
            <dd> 累计提现：<b class="orange">{{$tixian_count}} </b> 元</dd><br>
            <dd> 福币余额：<b class="orange">{{$active_money}}</b> 元 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</dd>
            <dd> 活动福分：<b class="orange">{{$active_money}}</b> 元 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</dd>
            <dd> 冻结福分：<b class="orange">{{$dongjie_money}}</b> 元</dd>
            <dd class="gray02">福分满100元时才可申请提现。</dd>
        </dl>
    </div>
    <div class="btnNav">

        <a href="{{Request::root()}}/mcy/user/invite/cashout/" title="申请提现">申请提现</a>

    </div>
    <!--<div class="record-tit">
        <div class="record-tab">
            <a href="javascript:void();" class="record-cur">全部</a>
            <a href="javascript:void();">今天</a>
            <a href="javascript:void();">本周</a>
            <a href="javascript:void();">本月</a>
            <a href="javascript:void();">最近三个月</a>
        </div>
    </div>-->
    <div id="divCommissionList" class="list-tab commission gray02">
        <ul class="listTitle">
            <li class="w20">用户</li>
            <li class="w20">时间</li>
            <li class="w20">描述</li>
            <li class="w20">消费</li>
            <li class="w20">福分</li>
        </ul>
        @if($mcy_yongjin)

            @foreach($mcy_yongjin as $list)
        <ul>
            <li class="w20">
                <a href="#" class="blue">{{$list->username}}</a>
            </li>
            <li class="w20">{{$list->created_at->format('Y.m.d H:i')}}</li>
            <li class="w20">
                <a href="{{$list->url}}" class="blue">{{$list->desc}}</a>
            </li>
            <li class="w20">{{$list->jishu}}</li>
            <li class="w20 orange">
                {{$list->fuhao}}
                {{$list->qty}}                            </li>
        </ul>
            @endforeach

        @endif

        <div id="divPageNav" class="page_nav">{{ $mcy_yongjin->links() }}</div>
    </div>
</div>
@endsection
@section('my-js')

@endsection