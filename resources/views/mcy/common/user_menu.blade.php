<style>
    html,body,.h5-1yyg-v11{ background:#f4f4f4 !important; }
    #header-div,#ulFun,#hot,#setting{ background:#fff; margin-bottom:10px; }
    #user,#user a,#user-info,#user-block,#ulFun,#ulFun li a,#hot,#setting{ display:-webkit-box; -webkit-box-align:center; }
    #user-block,#ulFun,#hot,#setting{ border-top:1px solid #eaeaea; border-bottom:1px solid #eaeaea; }
    #ulFun,#setting{ padding:5px 10px;text-align: center; }
    #hot{ padding:0 10px; }
    i{ display:block; margin:0 auto; }
    /*用户信息*/
    /*#uid{ float:left; margin-top:2%; font-weight:bold; font-size:14px; text-indent:10px; }*/
    #user{ padding:10px; /*height:62px; */}
    .z-Himg img{ display:block; width:60px; height:60px; border-radius:360px; border:1px solid #eaeaea; margin:0 10px 0 5px; }
    #user-info{ width:calc(100% - 77px); width:-moz-calc(100% - 77px); width:-webkit-calc(100% - 77px); overflow:hidden; }
    #user-info p{ width:100%; display:inline-block; color:#5c5c5c; line-height:14px; }
    #user-info p.name-info{ font-size:14px; text-indent:1px; }
    #user-info p.phone-info{ text-indent:1px; margin:3px 0 5px; position:relative; top:-3px; }
    #user-info p.lv-info{ text-indent:3px; color:#f1b128; }
    #user .qiandao{ display:block; width:60px; line-height:24px; text-align:center; color:#dc332d; border:1px solid #dc332d; border-radius:7px; position:relative; right:65px; }
    #user .qok{ color:#5c5c5c; border:1px solid #5c5c5c; }
    #user-block div{ width:calc(25% - 1px); width:-moz-calc(25% - 1px); width:-webkit-calc(25% - 1px); padding:5px 0; text-align:center; line-height:20px; /*border-right:1px solid #eaeaea;*/ position:relative; }
    #user-block div:nth-last-child(1){ width:25%; border:none; }
    #user-block p,#user-block span{ display:block; }
    #user-block div span{ color:#dc332d; }
    #user-block div i{ width:20px; height:20px; background:url({{Request::root()}}/chyyg1/my_chongzhi.png) no-repeat center center; background-size:10px; }
    #user-block div b{ height:75%; background:linear-gradient(#f9f9f9,#eaeaea,#f9f9f9); width:1px; position:absolute; top:6px; right:0; z-index:10; }
    /*功能区*/
    #ulFun ul,#hot-block,.hot-title,#setting ul{ width:100%; }
    #ulFun li,#hot-block li,#setting li{ float:left; width:25%; text-align:center; overflow:hidden; margin:5px 0; }
    #ulFun li p,#hot-block li p,#setting li p{ height:25px; line-height:25px; }
    #ulFun li a,#hot-block li a,#setting li a{ display:block; width:100%; color:#5c5c5c; text-align:center; margin:0 auto; }
    #ulFun li a i,#hot-block li a i,#setting li a i{ width:45%; height:0; padding-top:46%; }
    .hot-title{ background:#fff; line-height:30px; font-size:13px; text-indent:2em; border-top:1px solid #eaeaea; }
    .hot-title i{ display:inline-block; width:15px; height:11px; position:relative; top:-1px; left:2px; background:url({{Request::root()}}/my_hot.png) no-repeat center center; background-size:100%; }
    #hot-block{ padding-top:5px; }
    #ulFun #u-cart{ background:url({{Request::root()}}/chyyg1/cart.png) no-repeat center center; background-size:100%; }
    #ulFun #u-shengqing{ background:url({{Request::root()}}/chyyg1/my_shengqing.png) no-repeat center center; background-size:100%; }
    #ulFun #u-detail{ background:url({{Request::root()}}/chyyg1/detail.png) no-repeat center center; background-size:100%; }
    #ulFun #u-account{ background:url({{Request::root()}}/chyyg1/my_zhanghu.png) no-repeat center center; background-size:100%; }
    #ulFun #u-record{ background:url({{Request::root()}}/chyyg1/kuaigoujilu.png) no-repeat center center; background-size:100%; }
    #ulFun #u-obtain{ background:url({{Request::root()}}/chyyg1/obtain.png) no-repeat center center; background-size:100%; }
    #ulFun #u-single{ background:url({{Request::root()}}/chyyg1/my_shaidan.png) no-repeat center center; background-size:100%; }
    #ulFun #u-focus{ background:url({{Request::root()}}/chyyg1/my_shoucang.png) no-repeat center center; background-size:100%; }
    #ulFun #u-code{ background:url({{Request::root()}}/chyyg1/my_eweima.png) no-repeat center center; background-size:100%; }
    #ulFun #service_pic{ background:url({{Request::root()}}/chyyg1/my_kefu.png) no-repeat center center; background-size:100%; }
    #ulFun #u-ziliao{ background:url({{Request::root()}}/chyyg1/ziliao.png) no-repeat center center; background-size:100%; }
    #hot-block #u-miaosha{ background:url({{Request::root()}}/chyyg1/my_miaosha.png) no-repeat center center; background-size:100%; }
    #hot-block #u-fenxiang{ background:url({{Request::root()}}/chyyg1/my_fenxiang.png) no-repeat center center; background-size:100%; }
    #hot-block #u-diyongjuan{ background:url({{Request::root()}}/chyyg1/diyongjuan.png) no-repeat center center; background-size:100%; }
    #hot-block #u-qiandao{ background:url({{Request::root()}}/chyyg1/my_qiandao.png) no-repeat center center; background-size:100%; }
    #hot-block #u-notice{ background:url({{Request::root()}}/chyyg1/xinshouzhinan.png) no-repeat center center; background-size:100%; position:relative; }
    #hot-block #new_icon{ display:block; background:url({{Request::root()}}/chyyg1/new.gif) no-repeat center center; background-size:100%; width:28px; height:11px; position:absolute; top:0; right:-15px; }
    #setting #u-pwd{ background:url({{Request::root()}}/chyyg1/my_setting.png) no-repeat center center; background-size:100%; }
    #setting #u-logout{ background:url({{Request::root()}}/chyyg1/my_logout.png) no-repeat center center; background-size:100%; }
    #setting #u-vip{ background:url({{Request::root()}}/chyyg1/my_vip.png) no-repeat center center; background-size:100%; }
    #ulFun #u-packet{ background-position:-57px -1px; }
    #ulFun #u-home{ background-position:-57px -80px; }
    #ulFun #u-logout{ background-position:-56px -163px; }
    /*客服*/
    /*#service_pic{ width:45px; position:fixed; top:60%; right:0; cursor:pointer; padding-right:5px; border-top-left-radius:8px; border-bottom-left-radius:8px; }*/
    #service_bg{ width:100%; background:rgba(0,0,0,0.5); position:fixed; top:0; left:0; z-index:120; display:none; }
    #service_info{ width:85%; background:#fff; position:absolute; margin:auto; top:10%; left:0; right:0; z-index:140; display:none; border-radius:8px; }
    #service_info ul{ padding:0 25px; }
    #service_info li{ font-size:14px; line-height:50px; text-align:center; text-indent:10px; border-bottom:1px solid #eaeaea; }
    #service_info a{ text-decoration:none; color:#5c5c5c; display:block; }
    #service_code{ margin-bottom:20px; }
    #service_code p{ font-size:14px; line-height:45px; text-align:center; color:#5c5c5c; }
    #service_code img{ display:block; width:180px; margin:0 auto; }
    #code_bg{ width:100%; height:100%; background:rgba(0,0,0,0.5); position:fixed; top:0; left:0; z-index:150; }
    #sz_code{ width:66%; background:#fff; font-size:14px; padding:25px; border-radius:10px; box-shadow:3px 5px 5px rgba(0,0,0,0.3); overflow:hidden; margin:auto; position:absolute; left:0; right:0; top:20%; z-index:160; }
    #sz_code p{ margin-bottom:10px; text-align:center; color:#5c5c5c; }
    #sz_code img{ display:block; width:100%; }
    .logout ul li{
        text-align: center !important;
        float: none !important;
        margin: auto !important;
    }
    .logout ul {
        text-align: center;
    }
    .logout {
        text-align: center;
    }
    .red_mobile {
        color: red !important;
        margin: auto;
    }
    .mcy_user {
        color: #f1b128;
    }
</style>
<section class="clearfix">
    <div id="header-div">
        <!--<p id="uid">ID: {{@$mcy_user->mcy_user_id}}</p>-->
        <div id="user"><!-- fl  -->
            <a href="javascript:;" class="z-Himg">
                <img src="
                        @if($mcy_user->avator_img=='')
                {{@$site->site_m_logo}}
                @else
                {{@$mcy_user->avator_img}}
                @endif

                        " border="0/">
            </a>
            <div id="user-info">
                <p class="name-info">{{@$mcy_user->username}} </p>

                <p class="phone-info">
                    @if ($mcy_user->mobile == '')
                        <a href="/mcy/user/add/mobile"  class="red_mobile">点击验证手机</a>
                    @else
                        {{$mcy_user->mobile}}
                    @endif
                    (ID: {{@$mcy_user->mcy_user_id}})
                </p>
                {{-- <p class="lv-info">LV:
                 @if (@$mcy_user->jingyan > 100000 )
                 快购大将
                 @elseif (@$mcy_user->jingyan > 50000 )
                 快购中将
                 @elseif (@$mcy_user->jingyan > 10000 )
                 快购小将
                 @else
                 快购新兵
                 @endif
                 ,经验值：{{@$mcy_user->jingyan}}
                 </p>--}}
            </div>
            <!--<a href="{{Request::root()}}/mcy/user/uqiandao/mobile/submit" class="qiandao">签到</a>-->
            <a href="/mcy/user/qiandao" class="qiandao">签到</a>
        </div>
        <div id="user-block">
            <div>
                <p>余额</p>
                <span>￥{{@$mcy_user->money}}</span>
                <b></b>
            </div>
            <div>
                <p>福分</p>
                <span>{{@$mcy_user->score}}</span>
                <b></b>
            </div>
            <div>
                <a href="/mcy/user/red/bag">
                    <p>红包</p>
                    <span>0 个</span>
                </a>
                <b></b>
            </div>
            <div>
                <a href="/mcy/user/topup">
                    <i></i>
                    <p>充值</p>
                </a>
            </div>
        </div>
    </div>
</section>