@extends('mcy.layout')
@section('title','title')
@section('my-css')
<style>
     .g-userMoney .Recharge-btn{ display:block; width:70px; height:25px; line-height:25px; font-size:12px; color:#dc332d; border:1px solid #dc332d; border-radius:6px; text-align:center; position:absolute; top:0; bottom:0; right:20px; margin:auto;  }
    .m-userMoneyNav ul{ display:table; width:100%; }
    .m-userMoneyNav #btnRecharge{ height:33px; border:1px solid #dc332d; border-top-right-radius:8px; border-bottom-right-radius:8px; border-left:none; }
    .m-userMoneyNav #btnInvitePeopleCharge{ height:33px; border:1px solid #dc332d; border-top-right-radius:8px; border-bottom-right-radius:8px; border-left:none; }
    .m-userMoneyNav #btnConsumption{     background: #dc332d; color: white; height:33px; border:1px solid #dc332d; border-top-left-radius:8px; border-bottom-left-radius:8px; border-right:none; }
    .m-userMoneyNav #btnInvitePeople{     background: white; color: red; height:33px; border:1px solid #dc332d; border-top-left-radius:8px; border-bottom-left-radius:8px; border-right:none; }
    .m-Consumption li span{ width:50%; }
    .em_r {color: red;}
</style>
    <link href="/chyyg1/comm.css" rel="stylesheet" type="text/css" />
    <link href="/chyyg1/member.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/chyyg1/top.css">
@endsection
@section('content')
<div class="h5-1yyg-v1" id="loadingPicBlock">
    <input name="loadDataType" type="hidden" id="loadDataType" value="0" />
    <section class="clearfix">
        <div class="g-userMoney">
            可用余额 <span class="orange">¥ {{number_format(@$mcy_user->money,2)}}</span>
            <a href="/mcy/user/topup" class="Recharge-btn">去充值</a>
        </div>
        <article class="clearfix">
            <div class="m-userMoneyNav">
                <ul>
                    <li><a id="btnConsumption" href="javascript:;">消费明细(近50条记录)</a></li>
                    <li><a id="btnRecharge" href="javascript:;">充值明细(近50条记录)</a></li>
                </ul>
            </div>
<!--             <div class="m-userMoneyNav">
                <ul>
                    <li><a id="btnInvitePeople" href="javascript:;">邀请人明细</a></li>
                    <li><a id="btnInvitePeopleCharge" href="javascript:;">邀请人消费明细</a></li>
                </ul>
            </div> -->

            <ul id="ulRechage" class="m-userMoneylst m-Consumption" style="display:none;">
                <li class="m-userMoneylst-tt"><span>充值金额</span><span>充值时间</span></li>
                @foreach($charge as $c)
                <li class="m-userMoneylst-tt"><span>{{$c->price}}</span><span>{{$c->created_at}}</span></li>
                @endforeach
            </ul>

            <ul id="ulConsumption" class="m-userMoneylst m-Consumption">
                <li class="m-userMoneylst-tt"><span>消费金额</span><span>消费时间</span></li>
                 @foreach($consumption as $p)
                <li class="m-userMoneylst-tt"><span>{{$p->order_price}}</span><span>{{$p->created_at}}</span></li>
                @endforeach
            </ul>

        </article>
    </section>
    ﻿</br></br>
</div>
@endsection
@section('my-js')
<script>
    $(function(){
        $('#btn-share').click(function(){
            $('.share-guide').show();
        });
        $('.share-guide').click(function(){
            $('.share-guide').hide();
        });
    });
</script>
<script type="text/javascript">
    $('#btnConsumption').click(function(){
        $(this).css('background','#dc332d')
               .css('color','white');
        $("#btnRecharge").css("background",'white')
                            .css('color','#dc332d');
        $("#btnInvitePeople").css("background",'white')
                            .css('color','#dc332d');
        $("#btnInvitePeopleCharge").css("background",'white')
                            .css('color','#dc332d');
        $("#ulRechage").hide();
        $("#ulInvitePeople").hide();
        $("#ulInvitePeopleCharge").hide();
        $("#ulConsumption").show();
    });
    $("#btnRecharge").on('click',function(){
        $(this).css('background','#dc332d')
               .css('color','white');
        $("#btnConsumption").css("background",'white')
                            .css('color','#dc332d');
        $("#btnInvitePeople").css("background",'white')
                            .css('color','#dc332d');
        $("#btnInvitePeopleCharge").css("background",'white')
                            .css('color','#dc332d');
        $("#ulRechage").show();
        $("#ulConsumption").hide();
        $("#ulInvitePeople").hide();
        $("#ulInvitePeopleCharge").hide();
    });
    $("#btnInvitePeople").on('click',function(){
        $(this).css('background','#dc332d')
               .css('color','white');
        $("#btnConsumption").css("background",'white')
                            .css('color','#dc332d');
        $("#btnRecharge").css("background",'white')
                            .css('color','#dc332d');
        $("#btnInvitePeopleCharge").css("background",'white')
                            .css('color','#dc332d');
        $("#ulRechage").hide();
        $("#ulConsumption").hide();
        $("#ulInvitePeople").show();
        $("#ulInvitePeopleCharge").hide();
    });
    $("#btnInvitePeopleCharge").on('click',function(){
        $(this).css('background','#dc332d')
               .css('color','white');
        $("#btnConsumption").css("background",'white')
                            .css('color','#dc332d');
        $("#btnInvitePeople").css("background",'white')
                            .css('color','#dc332d');
        $("#btnRecharge").css("background",'white')
                            .css('color','#dc332d');
        $("#ulRechage").hide();
        $("#ulConsumption").hide();
        $("#ulInvitePeople").hide();
        $("#ulInvitePeopleCharge").show();
    });
  
</script>
@endsection