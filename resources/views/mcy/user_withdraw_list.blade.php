@extends('mcy.layout')
@section('title','提款信息表')
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
      height: 50px;
   text-align: center;
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
                <i class="gray9">申请时间</i>
            </li>
            <li style="width: 40%">
                <i class="gray9">银行账户</i>
            </li>
            <li style="width: 20%">
                <i class="gray9">提现金额</i>
            </li>
            <li style="width: 20%">
                <i class="gray9">审核状态</i>
            </li>
        </ul>
    </div>

   <div class="inv-count clearfix">
       <ul class="withdraw_list">
        @foreach($withdraw_list as $list)

              <li style="width: 20%;  ">
                  <em class="orange">{{@$list->created_at->format('Y/m/d H:i')}}</em>
              </li>
                  <li style="width: 40%;word-break: break-all; padding-left: 15px">
                      <em class="orange">{{$list->bank_id}}</em>
                  </li>
                  <li style="width: 20%; ">
                      <em class="orange">{{$list->withdraw_price}}</em>
                  </li>
                  <li style="width: 20%; ">

                          @if($list->status==0)
                              <em class="gray9">未审核</em>
                          @elseif($list->status==1)
                               <em class="orange">已审核</em>
                          @endif

                  </li>


        @endforeach
       </ul>
       {{ $withdraw_list->links() }}
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