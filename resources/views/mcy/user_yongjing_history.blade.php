@extends('mcy.layout')
@section('title','佣金记录表')
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
  .withdraw_list li {
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

  .pagination li{
      float: left;
      width: 10%;

  }
  .pagination .disabled{
      color:#000;
  }
    .pagination .active{
        color: #dc332d;
    }
</style>
@endsection
@section('content')
<div id="wrapper">
  

    <div class="inv-count clearfix">
        <ul>
            <li style="width: 20%">
                <i class="gray9">用户</i>
            </li>
            <li style="width: 40%">
                <i class="gray9">时间</i>
            </li>
            <li style="width: 20%">
                <i class="gray9">方式</i>
            </li>
            <li style="width: 20%">
                <i class="gray9">赠福分</i>
            </li>
        </ul>
    </div>

   <div class="inv-count clearfix">
          <ul class="withdraw_list">
        @foreach($yongjing_list as $list)
              <li style="width: 20%;">
                  <em class="orange">{{$list->username}}</em>
              </li>

              <li style="width: 40%;">
                  <em class="orange">{{@$list->created_at->format('Y/m/d H:i')}}</em>
              </li>
                  <li style="width: 20%">
                      <em class="orange">{{$list->typename}}</em>
                  </li>
                  <li style="width: 20%">
                      <em class="orange">{{$list->qty}}</em>
                  </li>
        @endforeach
          </ul>
       {{ $yongjing_list->links() }}
    </div>

    <div class="pro_foot">
        <ul>
            <li class="border-orange-Btn"><a href="{{Request::root()}}/mcy/user/invite/withdraw/">分享提现</a></li>
            <li><a class="orgBtn" href="{{Request::root()}}/mcy/user/invite/withdraw/">分享充值</a></li>
        </ul>
    </div>
</div>

<div id="mcover" class="m-popup">
    <img src="/chyyg1/0.png">
</div>
@endsection

@section('my-js')


@endsection