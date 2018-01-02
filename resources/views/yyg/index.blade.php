@extends('yyg.layout')
@section('title','潮惠云购-惊喜无限')
@section('my-css')
 <style type="text/css">
     .m-public-icon {
        background-image: url("")
     }
 </style>
@endsection
@section('content')
        <!--首页头部-->
        <div class="m-block-header" style="display: none"><a href="/" class="m-public-icon m-1yyg-icon"></a></div>
        <!--首页头部 end-->

        <!-- 关注微信 -->
        <div id="div_subscribe" class="app-icon-wrapper" style="display: none;">
            <div class="app-icon">
                <a href="javascript:;" class="close-icon"><i class="set-icon"></i></a>
                <a href="javascript:;" class="info-icon">
                    <i class="set-icon"></i>
                    <div class="info">
                        <p>点击关注潮惠云购官方微信^_^</p>
                    </div>
                </a>
            </div>
        </div>
        <!-- 焦点图 -->
        <div class="hotimg-wrapper">
            <div class="hotimg-top"></div>
            <section id="sliderBox" class="hotimg">
                <div class="loading clearfix"><b></b>正在加载</div>
            </section>
        </div>
        <!--分类-->
        <div class="index-menu thin-bor-top thin-bor-bottom">
            <ul class="menu-list">
                <li>
                    <a href="javascript:;" id="btnNew">
                        <i class="xinpin"></i>
                        <span class="title">新品</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" id="btnRecharge">
                        <i class="chongzhi"></i>
                        <span class="title">充值</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" id="btnLimitbuy">
                        <i class="xiangou"></i>
                        <span class="title">限购</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" id="btnDownApp">
                        <i class="xiazai"></i>
                        <span class="title">下载APP</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" id="btnAllGoods">
                        <i class="fenlei"></i>
                        <span class="title">全部分类</span>
                    </a>
                </li>
            </ul>
        </div>
        <!--导航-->
        <div>
            <nav id="goodsNav" class="nav-wrapper">
                <div class="nav-inner">
                    <ul id="ulOrder" class="nav-list clearfix">
                        <li order="10" class="current"><a href="javascript:;"><span>即将揭晓</span></a></li>
                        <li order="20"><a href="javascript:;"><span>人气</span></a></li>
                        <li order="50"><a href="javascript:;"><span>最新</span></a></li>
                        <li order="31"><a href="javascript:;"><span>价值</span></a></li>
                    </ul>
                </div>
                <!--点击添加或移除current-->
                <!--<div id="divSort" class="select-btn">
                    <span class="select-icon">
                        <i></i><i></i><i></i><i></i>
                    </span>
                    分类
                </div>-->
                <!--分类-->
                <!--<div class="select-total" style="display: none">
                    <ul class="sort_list">
                        <li sortid="0"><a href="javascript:;">全部分类</a></li>
                        <li sortid="100"><a href="javascript:;">手机数码</a></li>
                        <li sortid="106"><a href="javascript:;">电脑办公</a></li>
                        <li sortid="104"><a href="javascript:;">家用电器</a></li>
                        <li sortid="222"><a href="javascript:;">钟表首饰</a></li>
                        <li sortid="2"><a href="javascript:;">化妆个护</a></li>
                        <li sortid="276"><a href="javascript:;">运动户外</a></li>
                        <li sortid="397"><a href="javascript:;">食品饮料</a></li>
                        <li sortid="213"><a href="javascript:;">家居家纺</a></li>
                        <li sortid="251"><a href="javascript:;">礼品箱包</a></li>
                        <li sortid="310"><a href="javascript:;">母婴</a></li>
                        <li sortid="428"><a href="javascript:;">营养保健</a></li>
                        <li sortid="305"><a href="javascript:;">汽车</a></li>
                        <li sortid="617"><a href="javascript:;">房子</a></li>
                        <li sortid="312"><a href="javascript:;">其他商品</a></li>
                        <li sortid="400"><a href="javascript:;">限购专区</a></li>
                    </ul>
                </div>-->
                <!--搜索-->
                <div class="select-btn thin-bor-left" id="btnSearch">
                    <span class="select-icon"></span>
                    <span>搜索</span>
                </div>
            </nav>
        </div>
        <!--商品列表-->
        <div class="goods-wrap marginB">
            <ul id="ulGoodsList" class="goods-list clearfix"></ul>
            <div class="loading clearfix"><b></b>正在加载</div>
        </div>
        <!--底部-->
@endsection
@section('my-js')
 
@endsection