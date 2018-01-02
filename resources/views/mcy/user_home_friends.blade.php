@extends('mcy.layout')
@section('title','好友管理')
@section('my-css')
    <link href="/chyyg1/static/member.css" rel="stylesheet" type="text/css">
    <link href="/chyyg1/static/invite.css" rel="stylesheet" type="text/css">
    <script src="/chyyg1/static/jquery190.js" language="javascript" type="text/javascript"></script>

@endsection
@section('content')
@extends('mcy.common.user_menu')

    <div class="R-content">
        <div id="divInviteInfo" class="get-tips gray01" style="">成功邀请 <span class="orange">{{$inviteCount}}</span> 位会员注册，已有 <span class="orange">{{$hasBuyCount}}</span> 位会员参与购买</div>
        <div id="divList" class="list-tab SuccessCon">
            <ul class="listTitle">
                <li class="w20">邀请用户</li>
                <li class="w35">邀请时间</li>
                <li class="w25">邀请编号</li>
                <li class="w20">消费状态</li>
            </ul>
            @if($inviteUser)

                   @foreach($inviteUser as $list)
                        <ul>
                            <li class="w20"><a href="#" class="blue">{{$list->username}}</a></li>
                            <li class="w35" style="white-space:nowrap;">{{$list->created_at->format('Y.m.d H:i')}}</li>
                            <li class="w25">{{$list->mcy_user_id}}</li>
                            <li class="w20">{{$list->is_chongzhi}}</li>
                        </ul>
                    @endforeach

                @endif

        </div>
        <div id="divPageNav" class="page_nav">{{ $inviteUser->links() }}</div>
    </div>
@endsection
@section('my-js')

@endsection