@extends('mcy.layout')
@section('title','分享好友名单')
@section('my-css')
<link href="/chyyg1/invitehome.css" rel="stylesheet" type="text/css">
<link href="/chyyg1/static/invite.css" rel="stylesheet" type="text/css">
<style>
  .pro_foot {
        margin-bottom: 50px;
  }
    body{
    color: white;
  }
  .history_list li {
    border-top: 1px solid #dedede;
    margin:5px 0px;
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
  .inv-count li {
    border:none;
  }
  .inv-count li:first-child {
    border-right: 0px solid #dedede;
  }
</style>
@endsection
@section('content')
<div id="wrapper">
  <div class="inv-ad">
    <img src="/chyyg1/int-ad110.jpg">
  </div>
    <div class="inv-count clearfix">
        <ul>
            <li>
                <i class="gray9">受邀用户</i>
            </li>
            <li>
                <i class="gray9">邀请时间</i>
            </li>
        </ul>
    </div>

   <div class="inv-count clearfix">
          <ul class="history_list">
        @foreach($history_list as $list)
              <li>
                  <em class="orange">{{$list->username}}

                  </em>
              </li>
              <li>
                  <em class="orange">{{@$list->created_at->format('Y-m-d H:i')}}</em>
              </li>
        @endforeach
          </ul>
    </div>

    <!-- <div class="pro_foot">
        <ul>
            <li class="border-orange-Btn"><a href="{{Request::root()}}/mcy/user/invite/withdraw/">分享提现</a></li>
            <li><a class="orgBtn" href="{{Request::root()}}/mcy/user/invite/withdraw/">分享充值</a></li>
        </ul>
    </div> -->
</div>

<div id="mcover" class="m-popup">
    <img src="/chyyg1/0.png">
</div>
@endsection

@section('my-js')

@endsection