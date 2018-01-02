@extends('mcy.layout')
@section('title','提现')
@section('my-css')
    <link href="/chyyg1/static/member.css" rel="stylesheet" type="text/css">
    <link href="/chyyg1/static/invite.css" rel="stylesheet" type="text/css">
    <script src="/chyyg1/static/jquery190.js" language="javascript" type="text/javascript"></script>
    <style>
        form span,.z-Himg{ display:block; line-height:25px; color:#dc332d; }
        .m-name-info{ width:calc(100% - 77px); display:-webkit-box; -webkit-box-align: center; margin-left: 0; }
        .m-name{ display: -webkit-box; -webkit-box-align: center; }
        .fl { float:none; display: -webkit-box; -webkit-box-align: center; }
    </style>
@endsection
@section('content')
@extends('mcy.common.user_menu')

<div class="R-content">
    <div class="subMenu">
        <a id="linkApply" class="current">福币提现申请</a>

        <a id="linkRecord">提现记录</a>
        <!--<a href="http://m2.lhcz99.com/a/mobile/invite/record">提现记录</a>-->
    </div>
    <div class="total">
        <dt></dt>
        <dd>福分总余额：<b class="orange">{{$active_money}} </b>元</dd>
        <dd>活动福分：<b class="orange"> {{$active_money}}</b>元</dd>
        <dd>正在福分提现审核（冻结）：<b class="orange">{{$dongjie_money}} </b>元</dd>
        <dd id="divTip">为确保您申请的金额能够正确无误的转入您的账户，请填写真实有效的账户信息，以下信息均为必填项！<br>
            <span class="orange">活动福分满100元时才可以申请提现哦！</span>
         {{--   <span id="snum" data-snum="1">每天只能提现<font class="orange">1</font>次,今天你还剩<font class="orange">1</font>次</span>--}}
        </dd>
    </div>
    <div id="divSQTX" class="Apply-con">
        <form name="form1" action="" method="post">
            <dl>
                <dt>活动福分：</dt>
                <dd>
                    <strong id="spanBrokerage" class="orange">¥ {{$active_money}}</strong>
                </dd>
            </dl>
            <!--<dl>
                <dt>提现手续费：</dt>
                <dd><span id="procefees" class="orange">0.00 </span> 元&nbsp;<span class="gray02" style="color:#999999">( 实际获得金额 = 提现金额 - 手续费 )</span></dd>
            </dl>-->
            <dl>
                <dt>提现金额：</dt>
                <dd><input id="txtAppMoney" type="text" name="withdraw_price"  class="inp-money txtAri" value="" maxlength="10" tip="1"><b>元</b></dd>
                <dd><span id="tip1"></span></dd>
            </dl>
            <dl>
                <dt>开&nbsp;&nbsp;户&nbsp;&nbsp;人：</dt>
                <dd><input name="bank_username" type="text" id="txtUserName" class="input-txt" maxlength="10" tip="2"></dd>
                <dd><span id="tip2"></span></dd>
            </dl>
            <dl>
                <dt>银行名称：</dt>
                <dd><input name="bank_name" type="text" id="txtBankName" class="input-txt" tip="3"></dd>
                <dd><span id="tip3"></span></dd>
            </dl>
            <dl>
                <dt>开户支行：</dt>
                <dd><input name="bank_zhi_name" type="text" id="txtSubBank" class="input-txt" tip="4"></dd>
                <dd><span id="tip4"></span></dd>
            </dl>
            <dl>
                <dt>银行帐号：</dt>
                <dd><input name="bank_id" type="text" id="txtBankNo" class="input-txt txtAri" maxlength="23" tip="5"></dd>
                <dd><span id="tip5"></span></dd>
            </dl>
            <dl>
                <dt>联系电话：</dt>
                <dd><input name="bank_phone" type="text" id="txtPhone" class="input-txt txtAri" maxlength="13" tip="6"></dd>
                <dd><span id="tip6">格式：186****2310</span></dd>
            </dl>
            <div class="Apply-button">
                <input type="button" name="submit1" id="btnSQTX" class="redbut" title="提交申请" value="提交申请">
            </div>
        </form>
    </div>

    <div id="divMentionList" class="list-tab cash gray02" style="display:none;">
        <ul class="listTitle">
            <li class="w20">申请时间</li>
            <li class="w35">银行账户</li>
            <li class="w20">提现金额</li>
           {{-- <li class="w15">手续费</li>--}}
            <li class="w20">审核状态</li>
        </ul>
        @if($withdraw_list)

            @foreach($withdraw_list as $list)
                <ul>
                    <li class="w20">
                        <a href="#" class="blue">{{@$list->created_at->format('Y.m.d H:i')}}</a>
                    </li>
                    <li class="w35">{{$list->bank_id}}</li>
                    <li class="w20">
                        {{$list->withdraw_price}}
                    </li>
                   {{-- <li class="w20"></li>--}}
                    <li class="w20 orange">
                        @if($list->status==0)
                            <em class="gray9">未审核</em>
                        @elseif($list->status==1)
                            <em class="orange">已审核</em>
                        @endif
                    </li>
                </ul>
            @endforeach
        @else
            <div class="tips-con"><i></i>未有相应福分提现记录</div>
        @endif
    </div>
    <div id="divPageNav" class="page_nav"></div>
</div>
@endsection
@section('my-js')
    <script language="javascript" type="text/javascript">

        $(function(){
            $('#txtUserName').click(function(){
                $('.selectInfo').slideToggle();
            });
            $('.selectInfo > div').click(function(){
                $('#txtUserName').val($(this).find('em.nameIn')[0].innerText);
                $('#txtSubBank').val($(this).find('em.branch')[0].innerText);
                $('#txtBankName').val($(this).find('em.bankIn')[0].innerText);
                $('#txtBankNo').val($(this).find('em.bankNoIn')[0].innerText);
                $('.selectInfo').slideUp();
                var UserName=trim($("#txtUserName").val());
                if(UserName==''){
                    $("#tip2").html("*&nbsp;&nbsp;请输入开户人");
                }else if(!isCardName(UserName)){
                    $("#tip2").html("*&nbsp;&nbsp;开户人输入有误");
                    $("#txtUserName").val("");
                    $('#txtSubBank').val("");
                    $("#txtBankName").val("");
                    $("#txtBankNo").val("");
                }else{
                    $("#tip2").html("");
                }
            });
            $('#txtUserName').keyup(function(){

                $('.selectInfo').slideUp();
            });

            $(".subMenu a").click(function(){
                var id=$(".subMenu a").index(this);
                $(".subMenu a").removeClass().eq(id).addClass("current");
                $(".R-content .topic").hide().eq(id).show();
            });
            $("#linkApply").click(function(){
                $("#divSQTX").show();
                $(".total").show();
                $("#divTip").show();
                $('#divMentionList').hide();
            });
            $("#linkRecharge").click(function(){
                $("#divSQTX").hide();
                $(".total").show();
                $("#divTip").hide();
                $('#divMentionList').hide();
            });
            $("#linkRecord").click(function(){
                $("#divSQTX").hide();
                $(".total").hide();
                $('#divMentionList').show();
            });
            function trim(s){
                if(s==null){
                    return false;
                }
                if(s.length>0){
                    if(s.charAt(0)==" ")
                        s=s.substring(1,s.length);
                    if(s.charAt(s.length-1)==" ")
                        s=s.substring(0,s.length-1);
                    if(s.charAt(0)==" "||s.charAt(s.length-1)==" ")
                        return trim(s);
                }
                return s;
            }
            //  提交申请 判断
            var TXflag=true;
            $("#btnSQTX").click(function(){
                var snum=trim($('#snum').data('snum'));
                var Money=trim($("#txtAppMoney").val());
                var UserName=trim($("#txtUserName").val());
                var BankName=trim($("#txtBankName").val());
                var Bank=trim($("#txtSubBank").val());
                var BankNo=trim($("#txtBankNo").val());
                var Phone=trim($("#txtPhone").val());
                /*if(snum==0){
                    alert('每天只能提现1次!');
                    return false;
                }*/
                if(Money==''){
                    $("#tip1").html("*&nbsp;&nbsp;请输入提现金额");
                    return false;
                }else if(UserName==''){
                    $("#tip2").html("*&nbsp;&nbsp;请输入开户人");
                    return false;
                }else if(!isCardName(UserName)){
                    $("#tip2").html("*&nbsp;&nbsp;开户人输入有误");
                    $("#txtUserName").val("");
                    return false;
                }else if(BankName==''){
                    $("#tip3").html("*&nbsp;&nbsp;请输入银行名称");
                    return false;
                }else if(Bank==''){
                    $("#tip4").html("*&nbsp;&nbsp;请输入开户支行");
                    return false;
                }else if(BankNo==''){
                    $("#tip5").html("*&nbsp;&nbsp;请输入银行帐号");
                    return false;
                }else if(Phone==''){
                    $("#tip6").html("*&nbsp;&nbsp;请输入联系电话");
                    return false;
                }else{
                    if(!TXflag){
                        alert("请不要重复提交！");
                    }
                    TXflag=false;



                //提交后台

                var withdraw_price = $('input[name=withdraw_price]').val();
                var bank_name = $('input[name=bank_name]').val();
                var bank_id = $('input[name=bank_id]').val();
                var bank_username = $('input[name=bank_username]').val();
                var bank_zhi_name = $('input[name=bank_zhi_name]').val();
                var bank_phone = $('input[name=bank_phone]').val();
                $.ajax({
                    url : '/api/mcy/user/withdraw/fubi/apply',
                    type : 'post',
                    dataType : 'json',
                    data : {
                        _token : "{!! csrf_token() !!}",
                        withdraw_price : withdraw_price,
                        bank_name : bank_name,
                        bank_id : bank_id,
                        bank_username : bank_username,
                        bank_zhi_name:bank_zhi_name,
                        bank_phone:bank_phone
                    },
                    success: function(data) {

                        if(data == null) {
                            layer.msg('服务端错误', {icon:2, time:2000});
                            return;
                        }
                        if(data.ret != 0) {
                            layer.msg(data.msg, {icon:2, time:2000});
                            return;
                        }
                        //成功
                        if(data.ret=='0'){
                            layer.msg(data.msg,{icon:1,time:2000});
                            setTimeout(function(){
                                window.location.href=Gobal.Webpath+"/mcy/user/invite/cashout";
                            },2000);
                            return ;
                        }



                    },
                    error: function(xhr, ret, error) {
                        console.log(xhr);
                        console.log(ret);
                        console.log(error);
                        layer.msg('ajax error', {icon:2, time:2000});
                    },
                    beforeSend: function(xhr){
                        layer.load(0, {shade: false});
                    },
                    complete: function(){
                        layer.closeAll('loading');
                    },
                });

                }

            });
            $("#txtAppMoney").blur(function(){
                var Money=trim($("#txtAppMoney").val());
                if(Money==''){
                    $("#tip1").html("*&nbsp;&nbsp;请输入提现金额");
                }else if(Money>{{$active_money}}){
                    $("#tip1").html("*&nbsp;&nbsp;输入额超出可提现金额");
                    $(this).val("");
                }else if(Money<100){
                    $("#tip1").html("*&nbsp;&nbsp;福分余额未满100元,不能提现!");
                    $(this).val("");
                }else{
                    $("#tip1").html("");
                }
            });

            $("#txtBankName").blur(function(){
                var BankName=trim($("#txtBankName").val());
                if(BankName==''){
                    $("#tip3").html("*&nbsp;&nbsp;请输入银行名称");
                }else if(!isCardName(BankName)){
                    $("#tip3").html("*&nbsp;&nbsp;银行名称输入有误");
                    $(this).val("");
                }else{
                    $("#tip3").html("");
                }
            });
            $("#txtSubBank").blur(function(){
                var Bank=trim($("#txtSubBank").val());
                if(Bank==''){
                    $("#tip4").html("*&nbsp;&nbsp;请输入开户支行");
                }else if(!isCardName(Bank)){
                    $("#tip4").html("*&nbsp;&nbsp;开户支行输入有误");
                    $(this).val("");
                }else{
                    $("#tip4").html("");
                }
            });
            $("#txtBankNo").blur(function(){
                var BankNo=trim($("#txtBankNo").val());
                if(BankNo==''){
                    $("#tip5").html("*&nbsp;&nbsp;请输入银行帐号");
                }else if(!isNumber(BankNo)){
                    $("#tip5").html("*&nbsp;&nbsp;银行帐号输入有误");
                    $(this).val("");
                }else if(BankNo.length<16){
                    $("#tip5").html("*&nbsp;&nbsp;银行账号为16-19位数字");
                    $(this).val("");
                }else{
                    $("#tip5").html("");
                }
            });
            $("#txtPhone").blur(function(){
                var Phone=trim($("#txtPhone").val());
                if(Phone==''){
                    $("#tip6").html("*&nbsp;&nbsp;请输入联系电话");
                }else if(!isMobile(Phone)){
                    $("#tip6").html("*&nbsp;&nbsp;联系电话输入有误");
                    $(this).val("");
                }
            });
            $("#txtCZMoney").blur(function(){
                var CZMoney=trim($("#txtCZMoney").val());
                if(CZMoney==''){
                    $("#tip7").html("<font color='#FF6600'>*&nbsp;&nbsp;请输入提现金额</font>");
                }else if(CZMoney>{{$active_money}}){
                    $("#tip7").html("<font color='#FF6600'>*&nbsp;&nbsp;输入额超出可提现金额</font>");
                    $(this).val("");
                }else{
                    $("#tip1").html("");
                }
            });
            var flag=true;
            $("#btnSQCZ").click(function(){
                var CZMoney=trim($("#txtCZMoney").val());
                if(CZMoney==''){
                    $("#tip7").html("<font color='#FF6600'>*&nbsp;&nbsp;请输入充值金额</font>");
                    return false;
                }else{
                    if(!flag){
                        alert("请不要重复提交！");
                    }
                    flag=false;
                    return true;
                }
            });
            //检验汉字
            function isChinese(s){
                var patrn = /^\s*[\u4e00-\u9fa5]{1,15}\s*$/;
                if(!patrn.exec(s)){
                    return false;
                }
                return true;
            }
            //数字
            function isNumber(s){
                var patrn = /^\s*\d+\s*$/;
                //var patrn1=/^\s*\d{16}[\dxX]{2}\s*$/;
                if(!patrn.exec(s)){
                    return false;
                }
                return true;
            }
            //校验手机号码：必须以数字开头
            function isMobile(s){
                var patrn=/^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|17[0-9]{9}$|18[0-9]{9}$/;
                if(!patrn.exec(s)){
                    return false;
                }
                return true;
            }
            //检验姓名：姓名是2-15字的汉字
            function isCardName(s){
                var patrn = /^\s*[\u4e00-\u9fa5]{1,}[\u4e00-\u9fa5.·]{0,15}[\u4e00-\u9fa5]{1,}\s*$/;
                if(!patrn.exec(s)){
                    return false;
                }
                return true;
            }
        })
    </script>

@endsection