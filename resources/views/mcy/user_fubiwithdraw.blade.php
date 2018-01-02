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
      color: #333;


  }
  .link-wrapper {
    padding-left: 10px;
    font-size: 13pt;

      color: #666;
      line-height: 42px;
      height: 42px;
      border-bottom: 1px solid #dedede;
      border-top: 1px solid #dedede;

}
  .btn_tikuan {
    width: 100%;
  }
  .link-wrapper {
        padding-left: 10px;
      margin-top: 6px;
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
    .fubi_tishimsg{
        font-size: 16px;
        padding: 5px 5px 5px 10px;
        line-height:25px;
        margin-bottom: 6px;
        border-bottom: 1px solid #dedede;
    }
</style>
@endsection
@section('content')
<div id="wrapper" style="background: white">
    <div class="inv-ad">
        <img src="/chyyg1/inv-ad.png">
    </div>
    <div class="fubi_tishimsg">
        活动福分:{{$mcy_user->score}}}<br>
        正在福分提现审核(冻结):{{$dongjie}}}<br>
        为确保您申请的金额参够正确无误的转入您的账户,请填写真实有效的账户信息,以下信息均为必填项!<br>
        <em style="color: red;">活动福分满100时才可以申请提现哦!</em>
    </div>

        <div class="link-wrapper">
              <a href="#"><em>申请提现福分数:</em><span class="fr"><input type="text" name="withdraw_price"  value="{{@$mcy_user->score}}"></span></a>
        </div>
        <div class="link-wrapper">
            <a href="#"><em>开户人:</em><span class="fr"><input type="text" name="bank_username" value=""></span></a>
        </div>
           <div class="link-wrapper">
              <a href="#"><em>银行名称:</em><span class="fr"><input type="text" name="bank_name" value=""></span></a>
        </div>
        <div class="link-wrapper">
            <a href="#"><em>开户支行:</em><span class="fr"><input type="text" name="bank_zhi_name" value=""></span></a>
        </div>
           <div class="link-wrapper">
              <a href="#"><em>银行账号:</em><span class="fr"><input type="text" name="bank_id" value=""></span></a>
        </div>
        <div class="link-wrapper">
            <a href="#"><em>联系电话:</em><span class="fr"><input type="text" name="bank_phone" value=""></span></a>
        </div>

    <div class="tikuan">
        <ul>
            <li><a class="orgBtn btn_tikuan" href="javascript:;">提款申请</a></li>
        </ul>
    </div>
</div>

<div id="mcover" style="height: 100px">

</div>
@endsection

@section('my-js')

@endsection