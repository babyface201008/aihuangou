@extends('mcy.layout')
@section('title','好友管理')
@section('my-css')
    <link href="/chyyg1/static/member.css" rel="stylesheet" type="text/css">
    <script src="/chyyg1/static/jquery190.js" language="javascript" type="text/javascript"></script>
    <style>
        .iTop{ padding:12px; }
        .iTop .iBanner img{ display:block; width:100%; }
        .iTop .iBtn{ margin: 15px 0; }
        .iTop .iBtn a{ display:inline-block; width:35%; line-height:35px; font-size:15px; text-align:center; color:#fff; background:#dc332d; border-radius:4px; margin-left:10%; }
        .iTop .iRule{ font-size:13px; line-height:1.8; }
        #share-nav ul li{ line-height:50px; border-bottom:1px solid #eaeaea; }
        #share-nav ul li:nth-child(1){ border-top:1px solid #eaeaea; }
        #share-nav ul li a{ display:block; padding:0 15px; color:#8f8f8f; font-size:15px; text-indent:25px; position:relative; }
        #share-nav ul li a span{ font-size:0.8em; padding-left:15px; }
        #share-nav b.z-arrow{ float:right; width:9px; height:9px; border-width:1px 1px 0 0; margin-top:19px; }
        #share-nav i{ display:block; width:20px; height:20px; background:url(http://m2.lhcz99.com/statics/templates/quyu-1yygkuan/images/mobile/share_icon.png) no-repeat center center; background-size:25px; float:left; position:absolute; top:0; bottom:0; margin:auto; }
        #share-nav #share_share{ background-position:1px -83px; }
        #share-nav #share_code{ background-position:1px 0px; }
        #share-nav #share_hy{ background-position:1px -21px; }
        #share-nav #share_mx{ background-position:0px -41px; }
        #share-nav #share_tx{ background-position:1px -62px; }
    </style>
@endsection
@section('content')
    <div class="h5-1yyg-v11">
        <section class="clearfix">

            <div id="share-nav">
                <ul>
                    <li><a href="{{Request::root()}}/mcy/user/home/friends/"><i id="share_hy"></i><b class="z-arrow"></b>好友管理 </a></li>
                    <li><a href="{{Request::root()}}/mcy/user/invite/commissions/"><i id="share_mx"></i><b class="z-arrow"></b>明细</a></li>
                    <li><a href="{{Request::root()}}/mcy/user/invite/cashout"><i id="share_tx"></i><b class="z-arrow"></b>提现</a></li>
                </ul>
            </div>
        </section>
        ﻿<br><br>


    </div>
@endsection
@section('my-js')

@endsection