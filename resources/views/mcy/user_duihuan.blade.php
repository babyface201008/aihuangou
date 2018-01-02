@extends('mcy.layout')
@section('title','中奖商品兑换成福分')
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
    bottom: 1;
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

    <input type="hidden" value="{!! csrf_token() !!}" id="_token">

        <div class="fubi_tishimsg">

            <em style="color: red;">中奖商品:(第{{$yungou_shop->qishu}}期){{$product->product_name}}</em>
        </div>


        <div class="link-wrapper">
            <a href="#"><em>兑换成福分:</em><span class="fr" style="color: red">{{$add_score}}</span></a>
        </div>

    <div class="tikuan">
        <ul>
            <li><a class="orgBtn btn_tikuan" href="javascript:;" rel="{{$yungou_shop->yungou_id}}"  id="duihuan_btn">确认兑换</a></li>
        </ul>
    </div>
</div>

<div id="mcover" style="height: 100px">

</div>
@endsection

@section('my-js')
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script>
    //duihuan
    $('#duihuan_btn').click(function(){


        var obj={};
        obj.yungou_id = $.trim($(this).attr("rel"));
        obj._token=$.trim($('#_token').val());

        if (obj.yungou_id=='') {
            $.PageDialog.fail('缺少参数!');
            return ;
        };

        $.post(Gobal.Webpath+"/api/mcy/user/create/duihuan",obj,function(data){


            if(data.ret!='0'){
                layer.msg(data.msg, {icon:2, time:2000});
                return;
            }

            //成功
            if(data.ret=='0'){
                layer.msg(data.msg,{icon:1,time:2000});
                setTimeout(function(){
                    window.location.href=Gobal.Webpath+"/mcy/user";
                },2000);
                return ;
            }

        },'json');


    });

    $("#btnQRCode").fancybox({
        openEffect  : 'none',
        closeEffect	: 'none',
        closeClick : true,
    });

</script>
@endsection