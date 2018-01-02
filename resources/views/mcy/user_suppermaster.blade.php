@extends('mcy.layout')
@section('title','申请超级代理商')
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
    .superQRcode{
        margin-top: 20px;

    }
    .superQRcode p{
        font-size: 20px;
        text-align: center;
    }
    .superQRcode div{
        text-align: center;
        padding: 10px;
    }
  .superQRcode span{
      display: block;
      margin: 10px;
      word-break: break-all;
  }
</style>
@endsection
@section('content')
<div id="wrapper" style="background: white">

    @if($supper_master_apply)


        <div class="fubi_tishimsg">

            <em style="color: red;">已填写申请信息!</em>
        </div>


        <div class="link-wrapper">
            <a href="#"><em>申请人姓名:</em><span class="fr">{{$supper_master_apply->real_name}}</span></a>
        </div>

        <div class="link-wrapper">
            <a href="#"><em>联系电话:</em><span class="fr">{{$supper_master_apply->phone}}</span></a>
        </div>
        <div class="link-wrapper">
            <a href="#"><em>状态:</em><span class="fr">


                     @if($supper_master_apply->status == 1)
                        未审核
                    @elseif($supper_master_apply->status == 2)

                        已通过
                    @elseif($suppermaster->status == 3)
                        不通过
                    @elseif($suppermaster->status == 4)
                        取消资格
                    @endif
                </span></a>
        </div>

            @if($supper_master_apply->status == 2)

                <div class="superQRcode">
                    <p>代理商的专属二维码</p>
                    <div>
                        {!! QrCode::size(200)->encoding('UTF-8')->generate($url); !!}
                        <br>
                        长按复制邀请链接:
                        <span>{{$url}}</span>

                    </div>

                </div>
            @endif

        @else
                <div class="fubi_tishimsg">

                    <em style="color: red;">请填写真实有效的信息,以下信息均为必填项!</em>
                </div>


                <div class="link-wrapper">
                    <a href="#"><em>申请人姓名:</em><span class="fr"><input type="text" name="reak_name" value=""></span></a>
                </div>

                <div class="link-wrapper">
                    <a href="#"><em>联系电话:</em><span class="fr"><input type="text" name="phone" value=""></span></a>
                </div>

                <div class="tikuan">
                    <ul>
                        <li><a class="orgBtn btn_tikuan" href="javascript:;">提交申请</a></li>
                    </ul>
                </div>
        @endif
</div>

<div id="mcover" style="height: 100px">

</div>
@endsection

@section('my-js')

@endsection