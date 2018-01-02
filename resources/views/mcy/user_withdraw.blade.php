@extends('mcy.layout')
@section('title','提款申请')
@section('my-css')
<link href="/chyyg1/invitehome.css" rel="stylesheet" type="text/css">
<link href="/chyyg1/static/invite.css" rel="stylesheet" type="text/css">
 <link href="/chyyg1/static/member.css" rel="stylesheet" type="text/css">
<style>
  .tikuan {
    margin-bottom: 50px;
    clear: both;
    width: 100%;
    background: #fff;
    padding: 6px 0;
    position: absolute;
    position: fixed;
    bottom: 0;
    z-index: 20;
  }
  .link-wrapper {
    padding-left: 10px;
    font-size: 13pt;
    padding: 5px;
}
  .btn_tikuan {
    width: 100%;
  }
  .link-wrapper {
        padding-left: 10px;
  }
  .fr input {
    text-align: right;
    width: 207px;
    height: 25px;
  }
    .profile_button {
        position: fixed;
        bottom: 54px;
        background-color: #dc332d;
        width: 100%;
        border: 1px solid #fff;
        text-align: center;
        line-height: 50px;
        color: white;
        font-size: 20px;
        min-height: 50px;
        border-radius: 5px;
    }
</style>
@endsection
@section('content')
<div id="wrapper">
    <div class="inv-ad">
        <img src="/chyyg1/inv-ad.png">
    </div>

    <div class="link-wrapper">
          <a href="#"><em>提款金额：</em><span class="fr"><input type="text" name="withdraw_price"  value="{{@$mcy_user->slave_money}}"></span></a>
    </div>
       <div class="link-wrapper">
          <a href="#"><em>提款银行</em><span class="fr"><input type="text" name="bank_name" value=""></span></a>
    </div>
       <div class="link-wrapper">
          <a href="#"><em>提款卡号</em><span class="fr"><input type="text" name="bank_id" value=""></span></a>
    </div>
       <div class="link-wrapper">
          <a href="#"><em>提款人</em><span class="fr"><input type="text" name="bank_username" value=""></span></a>
    </div>

    <div class="tikuan">
        <ul>
            <li><a class="orgBtn btn_tikuan" href="javascript:;">提款申请</a></li>
        </ul>
    </div>
</div>

<div id="mcover" class="m-popup">
    <img src="/chyyg1/0.png">
</div>
@endsection

@section('my-js')

@endsection