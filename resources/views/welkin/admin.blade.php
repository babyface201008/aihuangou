@extends('welkin.layout')
@section('title','后台管理')
@section('my-css')
@endsection

@section('content')
<div id="wrapper">
    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="nav-close"><i class="fa fa-times-circle"></i>
        </div>
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <span><img alt="image" class="img-circle" src="{{ @$user->avator_img?$user->avator_img:'/favicon.ico'}}" width="64" height="64" /></span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear">
                                <span class="text-muted text-xs block username">{{ @$user->username }}<b class="caret"></b></span>
                            </span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="/welkin/logout">安全退出</a> </li>
                        </ul>
                    </div>
                </li>
                @if(@$user->privileges == 0)
               <li>
                <a href="#"><i class="fa fa-wechat"></i> <span class="nav-label">总后台管理</span><span class="fa arrow"></span></a>
                    <ul class=" nav nav-second-level collapse in ">
                        <li><a class="J_menuItem" href="/welkin/dashboard">数据分析</a>
                        <li><a class="J_menuItem" href="/welkin/users">用户管理</a>
                        <li><a class="J_menuItem" href="/welkin/users/password">密码管理</a>
                    </ul>
                </li>
                @endif
                @if(@$user->privileges == 0)
                <li><a href="#"><i class="fa fa-edit"></i> <span class="nav-label">文章管理</span><span class="fa arrow"></span></a>
                    <ul class=" nav nav-second-level collapse ">
                        <li><a class="J_menuItem" href="/welkin/article">文章列表</a>
                        <li><a class="J_menuItem" href="/welkin/tag">标签列表</a>
                        <li><a class="J_menuItem" href="/welkin/category">种类列表</a>
                    </ul>
                </li>
                @endif
                @if (($user->privileges == 0) || ($user->privileges == 1))
                <li><a href="#"><i class="fa fa-wechat"></i> <span class="nav-label">商城管理</span><span class="fa arrow"></span></a>
                    <ul class=" nav nav-second-level collapse ">
                        <li><a class="J_menuItem" href="/welkin/mcy/users">用户管理</a>
                        <li><a class="J_menuItem" href="/welkin/mcy/wxinfo">微信配置管理</a>
                        <li><a class="J_menuItem" href="/welkin/mcy/siteinfo">商城配置信息</a>
                        <li><a class="J_menuItem" href="/welkin/mcy/smsinfo">短信配置管理</a>
                        <li><a class="J_menuItem" href="/welkin/mcy/payinfo">支付配置管理</a>
                        <!-- <li><a class="J_menuItem" href="/welkin/mcy/smstemplate">短信模板管理</a> -->
                        <!-- <li><a class="J_menuItem" href="/welkin/mcy/emailinfo">邮件配置管理</a> -->
                        <li><a class="J_menuItem" href="/welkin/mcy/products">产品管理</a>
                        <li><a class="J_menuItem" href="/welkin/mcy/orders">订单管理</a>
                        <li><a class="J_menuItem" href="/welkin/mcy/topup">充值管理</a>
                        <li><a class="J_menuItem" href="/welkin/mcy/user/update/search">用户修改查询</a>
                        <li><a class="J_menuItem" href="/welkin/mcy/sends">发货订单管理</a>
                        {{--<li><a class="J_menuItem" href="/welkin/mcy/shaidan">晒单管理</a>--}}
                        <li><a class="J_menuItem" href="/welkin/mcy/withdraw">提现管理</a>
                        <li><a class="J_menuItem" href="/welkin/mcy/supper/master">超级代理商管理</a>
                        {{--<li><a class="J_menuItem" href="/welkin/mcy/activity">活动管理</a>--}}
                        <!-- <li><a class="J_menuItem" href="/welkin/mcy/replys">评论管理</a> -->
                        <li><a class="J_menuItem" href="/welkin/mcy/categorys">分类管理</a>
                        <!-- <li><a class="J_menuItem" href="/welkin/mcy/flinks">友链管理</a> -->
                        <!-- <li><a class="J_menuItem" href="/welkin/mcy/ads">广告管理</a> -->
                        <li><a class="J_menuItem" href="/welkin/mcy/loopimg">轮播图</a>
                        <!-- <li><a class="J_menuItem" href="/welkin/mcy/article">文章管理</a> -->
                        <li><a class="J_menuItem" href="/welkin/mcy/automan">测试购买</a>
                        <li><a class="J_menuItem" href="/welkin/mcy/automan/add">导入用户</a>
                    </ul>
                </li>
                @endif
                @if (($user->privileges == 0) || ($user->privileges == 2))
               <li><a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">企业管理</span><span class="fa arrow"></span></a>
                    <ul class=" nav nav-second-level collapse ">
                        <li><a class="J_menuItem" href="/welkin/kuurin/users">企业用户管理</a>
                        <li><a class="J_menuItem" href="/welkin/kuurin/sites">企业站点管理</a>
                        <li><a class="J_menuItem" href="/welkin/kuurin/navs">企业导航管理</a>
                        <li><a class="J_menuItem" href="/welkin/kuurin/pages">企业页面管理</a>
                        <li><a class="J_menuItem" href="/welkin/kuurin/articles">企业文章管理</a>
                        <li><a class="J_menuItem" href="/welkin/kuurin/flinks">企业友链管理</a>
                        <li><a class="J_menuItem" href="/welkin/kuurin/styles">企业风格管理</a>
                        <li><a class="J_menuItem" href="/welkin/kuurin/flinks">企业文章管理</a>
                        <li><a class="J_menuItem" href="/welkin/kuurin/categorys">企业分类管理</a>
                        <li><a class="J_menuItem" href="/welkin/kuurin/messages">企业留言管理</a>
                    </ul>
                </li>
                @endif
        </ul>
    </div>
</nav>
<!--左侧导航结束-->
<!--右侧部分开始-->
<div id="page-wrapper" class="gray-bg dashbard-1">
    <!-- 搜索栏开始 -->
    <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header"><a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a></div>
                </nav>
            </div>
            <div class="row J_mainContent" id="content-main">
                @if ($user->privileges == 0)
                <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="/welkin/users" frameborder="0" data-id="/welkin/users" seamless></iframe>
                @elseif($user->privileges == 1)
                <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="/welkin/mcy/users" frameborder="0" data-id="/welkin/users" seamless></iframe>
                @elseif($user->privileges == 2)
                <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="/welkin/kuurin/users" frameborder="0" data-id="/welkin/users" seamless></iframe>
                @endif
            </div>
            <div class="footer">
                <div class="pull-right">&copy; 2016-2017 <a href="http://www.kuurin.com/" target="_blank">叶云梦天</a>
                </div>
            </div>
        </div>
        <!--右侧部分结束-->
    </div>
    @endsection
    @section('my-js')
    @endsection
