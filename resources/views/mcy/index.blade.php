@extends('mcy.layout')
@section('my-css')
<style>
.footer_w {
    display: block;
    text-align: center;
    margin: auto;
    margin-bottom: 5px;
}
#divLottery{ background:#fff; }
#divLottery li{ width:49.8%; height:90px; text-align:right; overflow:hidden; float:left; }
#divLottery li:nth-child(2n+1){ border-right:1px solid #eaeaea; }
#divLottery li:nth-child(-n+2){ border-top:1px solid #eaeaea; border-bottom:1px solid #eaeaea; }
#divLottery li a{ color:#4c4c4c; display:block; }
#divLottery li .u-lott-pic{ display:-webkit-box; -webkit-box-align:center; width:40%; height:90px; overflow:hidden; float:right; }
#divLottery li img{ width:60px; height:60px; display:block; }
#divLottery li div{ width:50%; height:90px; display:inline-block; text-align:left; float:left; }
#divLottery li div p{ width:100%; display:block; overflow:hidden; }
#divLottery li .shopname{ height:37px; padding:0 8px; margin-top:10px; }
#divLottery li .shopname a{ height:37px; line-height:18px; }
#divLottery li .countdown{ margin-top:10px; }
#divLottery li .countdown .z-lott-time{ display:block; width:55px; height:20px; line-height:20px; font-size:14px; text-align:center; background:#dc332d; color:#fff; border-radius:15px; margin:0 auto; }
#divLottery li .obtain{ height:35px; line-height:18px; font-size:0.83em; color:#bbb; text-indent:8px; margin-top:5px; }
#divLottery li .obtain a{ width:100%; margin:0; overflow:hidden; color:#dc332d; }
#mask {
    position: absolute;
    top:0px;
    height: 10px;
    width: 100%;
}
.g-main .overflow{
    height:183px;
    overflow:hidden;
}

.g-main .overflow .haveNot{
    line-height:143px;
}

.g-main ul.slides div.loading{
    background-color:#FFF;
    margin-top:70px;
    box-shadow:none;
}

.g-main ul.slides li.m-xs-li{
    display:none;
}

.g-main .flex-control-nav{
    height:34px;
    margin-top:11px;
    overflow:hidden;
    zoom:1;
    text-align:center;
    position:relative;
    display:block;
}

.g-main:after{
    content:"\0020";
    display:block;
    height:0;
    clear:both;
}

.g-main{
    zoom:1;
}

      #divLottery{
            background: #fff;
        }
        #divLottery::after{
            content: "";
            width: 100%;
            height:0px;
            clear: both;
            display: block;
        }
        #divLottery li {
            float: left;
            /*height: 124px;*/
            height: 90px;
            box-sizing: border-box;
            border-right:1px solid rgba(246,246,246,.7);
            overflow: hidden;
        }
        #divLottery li a {
            position: relative;
            display: block;
        }
        #divLottery li a.limit::before {
            content: '';
            display: block;
            position: absolute;
            width: 35px;
            height: 35px;
            bottom: 0;
            right: 0;
            background: transparent url("/images/cat_mark.png?v=1.3") no-repeat;
            background-size: 35px;
            background-position:  0 -35px;
        }

        #divLottery li a.double::before {
            content: '';
            display: block;
            position: absolute;
            width: 35px;
            height: 35px;
            bottom: 0;
            right: 0;
            background: transparent url("/images/cat_mark.png?v=1.3") no-repeat;
            background-size: 35px;
            background-position:  0 0;
        }
        #divLottery li a.three::before {
            content: '';
            display: block;
            position: absolute;
            width: 35px;
            height: 35px;
            bottom: 0;
            right: 0;
            background: transparent url("/images/cat_mark.png?v=1.3") no-repeat;
            background-size: 35px;
            background-position:  0 -71px;
        }
        #divLottery li img{
            width: 70px;
            height: 70px;
            display: block;
            margin:0 auto;
            box-sizing: border-box;
            padding:4px;
        }
        #divLottery li p{
            color:#c9c0c0;
            text-align: center;
            margin:0 auto;
        }
        #divLottery .u-user a{
            overflow: hidden;
            display: block;
            width: 100%;
            text-overflow:ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }
        #divLottery .m-lott-state{
            margin:4px 0 10px;
        }
        #divLottery .m-lott-state .u-time{
            padding: 4px;
            border: 1px solid #eee;
            border-radius: 10px;
        }
        #divLottery .m-lott-state{
            text-align: center;
        }
        #divLottery .m-lott-pic{
            margin: 4px auto;
            width: 70px;
        }
        ul {
            list-style-type: none;
        }

        #partner { /*战略合作伙伴*/
            border: none;
            border-radius: 0;
            background: #fff;
            box-shadow: none;
            border-bottom: 1px solid rgba(246,246,246,0.8);
        }

        li.ptn {
            /*width: 25%;*/
            width: 25%;
            display: inline-block;
            box-sizing: border-box;
            border: none;
        }

        li.ptn > a {
            display: block;
            padding: .2rem 0;
            color: #999;
            text-align: center;
            text-decoration: none;
            outline: 0;
        }

        li.ptn a img {
            display: block;
            margin: auto;
            width: 75%;
            height: 75%;
        }

        li.ptn a span {
            text-align: center;
            /*font-size: .72rem*/
        }

        #notice { /*首页公告*/
            position: relative;
            margin-bottom: 5px;
            background: #FFF;
        }

        #notice:after {
            content: ' ';
            display: block;
            position: absolute;
            width: 8px;
            height: 8px;
            right: 15px;
            top: 14px;
            border-width: 1px 1px 0 0;
            border-style: solid;
            border-color: #BBB;
            -webkit-transform: rotate(45deg);
        }

        .anouncement {
            /*height: 40px;*/
            height: 30px;
            width: calc(100% - 40px);
            overflow: hidden;
            margin: 0 0 0 15px;
            z-index: 100;
            background-color: white;
        }

        .anouncement::before {
            content: ' ';
            display: block;
            position: absolute;
            width: 18px;
            height: 18px;
            /* margin: 11px 0 0; */
             margin: 5px 0 0; 
            border-right: 4px solid #FFF;
            z-index: 1002;
            background: #FFF url("/chyyg1/nt.png") center center / contain;
        }
        ..wnotice {
            position: relative;
            /*margin-bottom: 5px;*/
            background: #FFF;
        }

        #anMarquee {
            color: #dc332d;
            /*color: #0581fb;*/
            line-height: 30px;
            font-size: 12px;
        }

        .nav-wrapper {
            background-color: #fff;
            border-bottom: 1px solid #eee;
            border-top: 1px solid #eee;
            height: 44px;
             /*height: 57px;*/
            position: relative;
            width: 100%;
        }
        .nav-wrapper .nav-wrapper {
            border-bottom: 1px solid #eee;
            left: 0;
            position: fixed;
            top: 0;
            z-index: 99;
        }
        .nav-wrapper .nav-inner {
            box-sizing: border-box;
            float: left;
            height: 44px;
            padding-left: 6px;
            /*width: 60%;*/
            width: 80%;
        }

        .nav-wrapper .nav-inner li {
            float: left;
            height: 44px;
            text-align: center;
            width: 22%;
        }

        .nav-wrapper .nav-list {
            width: 100%;
        }

        .nav-wrapper .nav-inner li:last-child {
            width: 31%;
        }

        .nav-wrapper .nav-inner a {
            display: block;
            font-size: 14px;
        }

        .nav-wrapper .nav-inner li.current span {
            border-color: #dc332d;
            color: #dc332d;
        }

        .nav-wrapper .nav-inner span {
            border-bottom: 2px solid transparent;
            color: #999;
            display: inline-block;
            height: 30px;
            line-height: 30px;
            margin-top: 6px;
        }

        .nav-wrapper .select-btn::before {
            border-bottom-color: #dedede;
            border-style: solid;
            top: 30px;
            z-index: 3;
        }

        .nav-wrapper .select-btn::before, .nav-wrapper .select-btn::after {
            border-color: transparent;
            border-width: 7px 6px;
            content: "";
            display: none;
            height: 0;
            left: 50%;
            margin-left: -6px;
            position: absolute;
            width: 0;
        }

        .nav-wrapper .select-btn::after {
            border-bottom-color: #fff;
            border-style: solid;
            top: 31px;
            z-index: 4;
        }

        .nav-wrapper .select-btn::before, .nav-wrapper .select-btn::after {
            border-color: transparent;
            border-width: 7px 6px;
            content: "";
            display: none;
            height: 0;
            left: 50%;
            margin-left: -6px;
            position: absolute;
            width: 0;
        }

        .nav-wrapper .select-btn {
            border-left: 1px solid #eee;
            box-sizing: border-box;
            color: #999;
            float: left;
            font-size: 14px;
            height: 44px;
            line-height: 42px;
            position: relative;
            text-align: center;
            width: 20%;
        }

        .nav-wrapper .select-icon {
            background-color: #fff;
            display: inline-block;
            height: 12px;
            overflow: hidden;
            position: relative;
            top: -1px;
            vertical-align: middle;
            width: 13px;
        }

        .nav-wrapper .select-icon i:first-child {
            margin-top: 0;
        }

        .nav-wrapper .select-icon i {
            background-color: #bbb;
            display: block;
            height: 2px;
            margin-top: 3px;
            width: 13px;
        }
        .nav-wrapper .select-total {
            background-color: #fff;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.19);
            position: absolute;
            right: 0;
            top: 45px;
            width: 100%;
            z-index: 4;
        }
        .sort_list::after {
            clear: both;
            content: "";
            display: table;
        }
        .sort_list {
            width: 100%;
        }
        .sort_list li {
            border-bottom: 1px solid #eee;
            border-right: 1px solid #eee;
            box-sizing: border-box;
            float: left;
            height: 44px;
            line-height: 42px;
            width: 33.3%;
        }
        .sort_list a {
            color: #666;
            display: block;
            font-size: 14px;
            padding: 0 20px;
            text-align: left;
        }
        #divGoodsLoading {
            min-height: 45px;
            border-top:1px solid #ccc;
        }
        #ulRecommend > li {
            position: relative;
            padding: 10px 0;
        }
        #btnsearch {
            cursor: pointer;
        }
        #btnsearch .select-icon
        {
            width: 11px;
            height: 11px;
            display: inline-block;
            vertical-align: middle;
            position: relative;
            background-color: #fff;
            top: -2px;
            border: 1px solid #999;
            border-radius: 50%;
            overflow: visible;
        }
        #btnsearch .select-icon::before
        {
            content: '';
            position: absolute;
            width: 4px;
            height: 1px;
            background-color: #999;
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
            top: 11px;
            left: 9px;
            z-index:2;
        }

        /*商品分类导航栏添加商品选择框*/
        .sort_list li {
            position: relative;
            overflow: hidden;
        }
        .sort_list li > input {
            display: none;
        }
        .sort_list li em {
            color: #dc332d;
        }
        .cateChk + label {
            position: absolute;
            height: 44px;
            width: 44px;
            top: 0;
            right: -6px;
            box-sizing: border-box;
            cursor: pointer;
            z-index: 1;
            background: transparent url("/statics/templates/ffxiang/images/mobile/check_.png") center 51px / 130% 390%;
            text-align: center;
            line-height: 44px;
            color: #CCC;
        }
        .cateChk:checked + label, .cateChk.red:checked + label {
            background-position-y: -7px;
            color: #dc332d;
        }
        li:first-child .cateChk:checked + label {
            background-image: url("/statics/templates/ffxiang/images/mobile/check_bak.png");
        }
    /*.cateChk.disabled:checked + label { //disabled类暂不删除，留待使用
        background-position-y: 51px;
        color: #CCC;
    }*/
    .cateChk.red + label {
        background-position: center;
        color: #000;
    }
    #addAll {
        position: relative;
        width: 100%;
        height: 44px;
        text-align: center;
        border-top: 1px solid #eee;
        margin-top: -1px;
    }

    #addAll p {
        border: 1px solid #dc332d;
        border-radius: 3px;
        width: 33%;
        margin: 7px auto;
        height: 28px;
        color: #FFF;
        font-size: 15px;
        line-height: 28px;
        letter-spacing: 5px;
        cursor: pointer;
        background: #dc332d;
    }

    #addAll p#catUp {
        position: absolute;
        width: 31%;
        margin-left: 1%;
        overflow: hidden;
        background: #FFF;
        border: none;
    }

    #addAll p#catUp::after {
        content: '\00AB';
        width: 2rem;
        height: 2rem;
        font-size: 2rem;
        line-height: 2rem;
        -webkit-transform: rotate(90deg);
        display: block;
        margin: 0 auto;
        color: #dc332d;
    }

    #addAll em {
        position: absolute;
        top: 0;
        left: 70%;
        height: 44px;
        line-height: 44px;
        color: #CCC;
        font-size: 12px
    }

    #addAll em.num {
        color: #dc332d;
        text-shadow: 0 0 3px #dc332d;
    }

    .special a {
        color: #1A9DEC !important;
    }

    /*鸡年活动超链接*/
    /*
        position: fixed;
        z-index: 111;
        bottom: 10%;
        right: 1rem;
        -webkit-animation: runing 25s infinite linear;
        animation-fill-mode: forwards;
        cursor: pointer;
    }

    #chk:before {
        position: absolute;
        content: '点我砸蛋';
        display: block;
        width: 4rem;
        height: 1.1rem;
        line-height: 1.1rem;
        top: -1.6rem;
        text-align: center;
        color: #FFF;
        font-size: .75rem;
        letter-spacing: .1rem;
        background: #dc332d;
        border-radius: 3px;
        -webkit-animation: chkBf 25s infinite linear;
        animation-fill-mode: forwards;

    }

    #chk:after {
        position: absolute;
        content: '';
        display: block;
        width: .6rem;
        height: .6rem;
        top: -.85rem;
        left: calc(50% - .25rem);
        text-align: center;
        color: #FFF;
        font-size: .8rem;
        background: #dc332d;
        transform: rotate(45deg);
        z-index: -1;
    }

    @-webkit-keyframes chkBf {
        0.01% {
            transform: scaleX(-1);
        }

        20% {
            transform: scaleX(-1);
        }

        20.01% {
            transform: scaleX(1);
        }

        50% {
            transform: scaleX(1)
        }

        50.01% {
            transform: scaleX(-1)
        }

        70% {
            transform: scaleX(-1)
        }

        70.01% {
            transform: scaleX(1);
        }

        100% {
            transform: scaleX(1);
        }
    }

    #chk img {
        width: 5rem;
        height: auto;
    }

    @-webkit-keyframes runing {
        0.01% {
            bottom: 10%;
            right: 1rem;
            transform: scaleX(-1);
        }

        20% {
            right: calc(100% - 6rem);
            bottom: 10%;
            transform: scaleX(-1);
        }

        20.01% {
            transform: scaleX(1);
        }

        50% {
            right: 1rem;
            bottom: 50%;
            transform: scaleX(1)
        }

        50.01% {
            transform: scaleX(-1)
        }

        70% {
            right: calc(100% - 6rem);
            bottom: 50%;
            transform: scaleX(-1)
        }

        70.01% {
            transform: scaleX(1);
        }

        100% {
            right: 1rem;
            bottom: 10%;
            transform: scaleX(1);
        }
    }
    */
    /*end*/

    /*添加“我的收藏”到分类列表*/
    #lucky a, #myCollect a {
        height: 26px;
        padding: 0;
        margin: 8px 12px 0;
        color: #dc332d;
        border: 1px solid #dc332d;
        line-height: 26px;
        text-indent: 5px;
        border-radius: 5px;
    }

    #lucky a::after, #myCollect a::after {
        content: '\279C';
        font-size: 1.1rem;
        display: block;
        position: absolute;
        width: 44px;
        height: 30px;
        right: 2px;
        top: 0;
        line-height: 44px;
        text-align: center;
        text-indent: 0;
    }

    .check_more{
        text-align: center;
        cursor: pointer;
        color: #a4a0a0;
        display: none;
        height: 52px;
        line-height: 30px;
    }
    .friendarea{
        display: none;
        width: 100%;
        background: rgba(0,0,0,0.6);
        position: fixed;
        bottom: 0px;
        left: 0px;
        margin-bottom: 52px;
        height: 125px;
        z-index: 112;
    }
    .hidefirend{
        width: 100%;
        height:100%;
        position: fixed;
        top: 0;
        left:0;
        opacity: 0;
        display: none;
        z-index: 111;
    }
    .friendarea .friend_content div{
        box-sizing: border-box;
    }
    .friendarea .friend_content .link_box{
        height: 100px;
        width: calc((100% - 25px) / 4);
        box-sizing: border-box;
        float: left;
        background: #FFF;
        margin: 10px 0 10px 5px;
        border-radius: 2px;
        padding: 5px;
    }
    .friendarea .friend_content a{
        display: block;
        margin-top:5px;
    }
    .friend_content img{
        height: 60px;
        width: 60px;
        margin: 0 auto;
        display: block;
    }
    .friend_content h3{
        text-align: center;
        width: 100%;
        color: #666;
        height: 20px;
        line-height: 20px;
    }
    .link_box::after{
        content: "";
        display: block;
        width: 100%;
        height: 0px;
        clear: both;
    }
    .star{
        position: absolute;
        width: 20px;
        height: 20px;
        left: 8px;
        background-image: url("{{Request::root()}}/images/star.png");
        background-size: 100% 100%;
        top: 5px;
        cursor: pointer;
    }
    .stars {
        background-image: url("{{Request::root()}}/images/stars.png");
        background-size: 100% 100%;
    }
    #friendlink{
        margin-bottom:5px;
    }
    #friendlink .z-arrow{
        width: 8px;
        height: 8px;
        border-width: 1px 1px 0 0;
        float: right;
        margin-top: 10px;
        margin-right: 14px;
    }
    #friendlink h1{
        color: #999;
        font-size: 14px;
        border-bottom: 1px solid #f5f5f5;
        box-sizing: border-box;
        height: 32px;
        line-height: 32px;
        padding-left: 15px;
    }
    #friendlink li.ptn{
        width: 20%;
        position: relative;
        cursor: pointer;
    }
    #wximg{
        width: 12rem;
        height: 12rem;
        position: fixed;
        background: #7b7878;
        top: 100px;
        left: 50%;
        z-index: 3;
        margin-left: -6rem;
        border-radius: 10px;
        opacity: 0.9;
        display:none;
    }
    #wximg p{
        color: #fff;
        box-sizing: border-box;
        padding-left: 0.7rem;
        padding-top: 0.7rem;
    }
    #wximg img{
        display: block;
        width: 8rem;
        height: 8rem;
        margin: 0 auto;
        box-sizing: border-box;
        padding: 0.4rem;
    }
    .wximghide{
        width: 100%;
        height:100%;
        position: fixed;
        top: 0;
        left:0;
        opacity: 0;
        display: none;
        z-index: 2;
    }
    /*转盘跳转*/
    #rotate {
        display: block;
        position: fixed;
        width: 80px;
        height: 80px;
        top: 50%;
        left: calc(50% - 40px);
        z-index: 111;
    }
    #rotate img {
        width: 100%;
        height: 100%;
        vertical-align: middle;
        -webkit-animation: rotate 3s infinite linear;
        -webkit-animation-fill-mode: forwards;
    }
    @-webkit-keyframes rotate {
        0% {
            -webkit-transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    /*添加到购物车动画*/
    img#forFun {
        position: absolute;
        width: 0;
        height: 0;
        overflow: hidden;
        z-index: 111;
        -webkit-animation: forFun .65s ease-in-out;
        -webkit-animation-fill-mode: backwards;
    }
    .flower:nth-of-type(1){
        width: 60px;
        position: absolute;
        bottom: 20px;
        left: calc(50% - 2px);
        transition: all 1s;
        transform-origin: bottom left;
        animation: flower-fly1 8s ease-in-out infinite;
        z-index: 1;
        /*background-image:url('http://yyygbh-static.oss-cn-shenzhen.aliyuncs.com/images/mobile/hp/flower.png');*/
        background-repeat: no-repeat;
        background-position: center top;
        background-size: 100% 100%;
        transform: rotate(-36deg);
        cursor: pointer;
    }
    @keyframes flower-fly1{
        0%{
            transform: rotate(-36deg);
        }
        50%{
            transform: rotate(14deg);
        }
        100%{
            transform: rotate(-36deg);
        }
    }
    .friend_list{
        position: relative;
    }
    .flower_content{
        width: 100%;
        height: 100%;
        position: relative;
    }
    .flower .rol-text{
        position: absolute;
        color: #f00;
        border-radius: 50%;
        width: 1.2rem;
        height: 1.2rem;
        text-align: center;
        line-height: 1.2rem;
        transition: all 0.5s;
        font-size: 12px;
        top:0;
        left: 50%;
        opacity: 1;
        font-weight: bold;
    }
    .flower .rol-text:nth-of-type(1){
        animation: text-show-1 8s ease-in-out infinite;
        left: -60%;
        top: -4%;
    }
    .flower .rol-text:nth-of-type(2){
        animation: text-show-1 8s ease-in-out infinite;
        left: -22%;
        top: -32%;
    }
    .flower .rol-text:nth-of-type(3){
        animation: text-show-1 8s ease-in-out infinite;
        left: 23%;
        top: -42%;
    }
    .flower .rol-text:nth-of-type(4){
        animation: text-show-1 8s ease-in-out infinite;
        left: 70%;
        top: -41%;
    }
    .flower .rol-text:nth-of-type(5){
        animation: text-show-1 8s ease-in-out infinite;
        left: 110%;
        top: -25%;
    }
    .flower .rol-text:nth-of-type(6){
        animation: text-show-1 8s ease-in-out infinite;
        left: 134%;
        top: 6%;
    }
    @keyframes text-show-1{
        0%{
            opacity:0.5;
        }
        25%{
            opacity:1;
        }
        50%{
            opacity:0.5;
        }
        75%{
            opacity:1;
        }
        100%{
            opacity:0.5;
        }
    }
        .f1 {
        width: 100%;
        line-height: 35px;
        font-size: 14px;
        text-align: center;
        position: relative;
        margin-top: 10px;
        background: #fff;
    }
    a {
        color: #5c5c5c;
        text-decoration: none;
        -webkit-tap-highlight-color: transparent;
    }
    /*客服*/
    /*#service_pic{ width:45px; position:fixed; top:60%; right:0; cursor:pointer; padding-right:5px; border-top-left-radius:8px; border-bottom-left-radius:8px; }*/
    #service_bg{ width:100%; background:rgba(0,0,0,0.5); position:fixed; top:0; left:0; z-index:120; display:none; }
    #service_info{ width:85%; background:#fff; position:absolute; margin:auto; top:5%; left:0; right:0; z-index:140; display:none; border-radius:8px; }
    #service_info ul{ padding:0 25px; }
    #service_info li{ font-size:14px; line-height:50px; text-align:center; text-indent:10px; border-bottom:1px solid #eaeaea; }
    #service_info a{ text-decoration:none; color:#5c5c5c; display:block; }
    #service_code{ margin-bottom:20px; }
    #service_code p{ font-size:14px; line-height:45px; text-align:center; color:#5c5c5c; }
    #service_code img{ display:block; width:180px; margin:0 auto; }
    #chkg_bg{ width:100%; background:rgba(0,0,0,0.5); position:fixed; top:0; left:0; z-index:120; display:none; }
    #chkg_info{ width:85%; background:#fff; position:absolute; margin:auto; top:5%; left:0; right:0; z-index:140; display:none; border-radius:8px; }
    #chkg_info ul{ padding:0 25px; }
    #chkg_info li{ font-size:14px; line-height:50px; text-align:center; text-indent:10px; border-bottom:1px solid #eaeaea; }
    #chkg_info a{ text-decoration:none; color:#5c5c5c; display:block; }
    #chkg_code{ margin-bottom:20px; }
    #chkg_code p{ font-size:14px; line-height:45px; text-align:center; color:#5c5c5c; }
    #chkg_code img{ display:block; width:180px; margin:0 auto; }
    .chkg-icon{ width:100%; height:40px; margin:0 auto; position:relative; background-color:#e67222; }
    .chkg-icon .info-icon{ position:absolute; height:40px; top:0; left:2%; }
    .chkg-icon .info-icon i{ display:block; width:20px; height:20px; float:left; padding:10px 5px; }
    .chkg-icon .info-icon .info{ padding-left:8px; float:left; }
    .chkg-icon .info-icon h6{ color:#fff; font-size:14px; line-height:40px; }
    .chkg-icon .info-icon p{ color:#b5b5b5; }
    .chkg-icon .down-icon{ width:65px; height:24px; line-height:24px; border-radius:3px; display:block; background-color:#ffe643; color:#da1d1d; font-weight:bold; text-align:center; position:absolute; top:8px; right:8px; }
    .chkg-icon a{ display:block; cursor:pointer; }
    .ptn-gradient {
      /*  background:-moz-linear-gradient(top, red, rgba(0, 0, 255, 0.5));  
        background:-webkit-gradient(linear, 0 0, 0 bottom, from(#ff0000), to(rgba(0, 0, 255, 0.5)));  
        background:-o-linear-gradient(top, red, rgba(0, 0, 255, 0.5)); */
        }
</style>
<!-- <script id="pageJS" data="/chyyg1/Index.js" language="javascript" type="text/javascript"></script> -->
<!-- <script type="text/javascript" src="/chyyg1/ILotteryFun.js"></script> -->
    <link href="/chyyg1/goodn.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/chyyg1/topn.css">
@endsection
@section('content')

<!-- <div class="chkg-icon">
    <a class="info-icon">
    <i class="set-icon"><img src="/chyyg1/index_share.jpg" width="20" style="border-radius:360px;"></i>
        <div class="info">
            <h6>点击关注潮惠快购！！！</h6>
        </div>
    </a>
    <a href="javascript:;" target="_blank" id="chkg_pic" class="down-icon">立即关注</a>
</div> -->

<div class="h5-1yyg-v1" id="loadingPicBlock">

    <!-- 幻灯片 -->
    <div class="swiper-container swiper-container-horizontal">
        <div class="swiper-wrapper" style="transform: translate3d(-2898px, 0px, 0px); transition-duration: 0ms;">
            @foreach($loopimgs as $loopimg)
            <div class="swiper-slide" >
                <a href="{{@$loopimg->link_href}}">
                    <img src="{{@$loopimg->loopimg_url}}" class="swiper-lazy swiper-lazy-loaded">
                </a>
            </div>
            @endforeach
        </div>
        <div class="swiper-pagination swiper-pagination-bullets"><span class="swiper-pagination-bullet swiper-pagination-bullet-active"></span><span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span></div>
    </div>
    <!--  幻灯片结束 -->
    <!-- 图标导航 -->
    <section class="nva-list">
        <!--<div class="m-tt1">-->
        <!--<h2><a href="javascript:" style="cursor: default">战略合作伙伴</a></h2>-->
        <!--</div>-->
        <article id="partner" class="m-round m-lott-list">
            <ul>
                <li class="ptn ptn-gradient">
                    <a href="#" id="chkg_pic">
                        <img src="/chyyg1/index_guanzhu.png">
                        <!-- <img src="/chyyg1/qiandao.png"> -->
                        <span>点击关注</span>
                    </a>
                </li>
                <li class="ptn ptn-gradient">
                    <a href="/mcy/user/apply/supper/master">
                        <img src="/chyyg1/index_share.png">
                        <!-- <img src="/chyyg1/fenxiang.png"> -->
                        <span>超级代理</span>
                    </a>
                </li>
                <li class="ptn ptn-gradient">
                    <a href="javascript:;" id="service_pic">
                        <img src="/chyyg1/index_kefu.png">
                        <span>联系客服</span>
                    </a>
                </li>
                
                <li class="ptn ptn-gradient">
                    <a href="/mcy/user/topup">
                        <img src="/chyyg1/index_charge.png">
                        <span>账户充值</span>
                    </a>
                </li>
                {{--<li class="ptn ptn-gradient" style="color: gray;">
                    <a href="#">
                        <img src="/chyyg1/index_xiangou1.png">
                        <span>秒杀商城</span>
                    </a>
                </li>--}}
            </ul>
        </article>
    </section>
    <div id="service_bg" >
        <div id="service_info">
            <ul>
                <li style="color:#dc332d;">客服时间：早09:00 至 晚18:00</li>
                <!-- <li><a href="http://wpa.qq.com/msgrd?v=1&amp;uin=2569000243&amp;site=qq&amp;menu=yes" target="_blank">客服QQ：2569000243</a></li> -->
                <!-- <li><a href="tel:15820140307">客服电话：15820140307</a></li> -->

            </ul>
            <div id="service_code">
                <p>长按二维码，添加客服微信</p>
                <img src="{{$site->service_wexin}}">
            </div>
        </div>
    </div>
    <div id="chkg_bg" >
        <div id="chkg_info">
            <ul>
                <li style="color:#dc332d;">{{$site->site_name}}大家庭，欢迎您的加入!</li>
            </ul>
            <div id="chkg_code">
                <p>长按二维码，关注{{$site->site_name}}！</p>
                <img src="/chyyg1/logo.jpg">
            </div>
        </div>
    </div>
    <!--  图标导航结束 -->
    <!--  公告轮播 -->
    <section class="nva-list">
        <article  class="m-lott-list wnotice">
            <div class="anouncement">
                <pre id="anMarquee" style="margin-left: -491.549px;">{{@$site->site_ad}}</pre>
            </div>
        </article>
    </section>
    <!--  公告轮播结束 -->


    <!-- 滑动最新揭晓结束 -->
    <div  class="g-main" >
        <nav class="nav-wrapper" id="goodsNav">
            <div class="nav-inner">
            <input type="hidden" value="" id="parm_order">
                <ul class="nav-list clearfix" id="ulOrder">
                    <li  class="current"  order="50"><a href="javascript:;"><span>价值</span></a></li>
                    <li order="30"><a href="javascript:;"><span>最新</span></a></li>
                    <li order="20"><a href="javascript:;"><span>人气</span></a></li>
                    <li order="10"><a href="javascript:;"><span>即将揭晓</span></a></li>
                </ul>
            </div>
            <!--点击添加或移除current-->
            <div class="select-btn" id="divSort">
                <span class="select-icon">
                    <i></i><i></i><i></i><i></i>
                </span>
                分类
            </div>
<!--             <div class="select-btn" id="btnsearch">
                <span class="select-icon"></span>
                <span>搜索</span>
            </div> -->
            <!--分类-->
            <div style="display: none;" class="select-total">
                <ul class="sort_list">
                    <li sortid="0">
                        <a href="javascript:;">全部商品</a>
                        <input id="chk0" class="cateChk" type="checkbox" name="0" value="0">
                        <label for="chk0"></label>
                    </li>
                    @foreach($categorys as $category)
                    <li sortid="{{@$category->category_id}}">
                        <a href="javascript:;">{{@$category->name}}</a>
                        <input id="chk{{@$category->category_id}}" class="cateChk" type="checkbox" name="{{@$category->category_id}}" value="{{@$category->category_id}}">
                        <label for="chk{{@$category->category_id}}">{{@$category->count}}</label>
                    </li>
                    @endforeach

                </ul>
            </nav>
        </div>
        <section class="g-main">
            <article class="clearfix h5-1yyg-w310 m-round m-tj-li">
                <ul id="ulRecommend" class="clearfix">
                @foreach($products as $product)
                 <li id="{{@$product->product_id}}">
                    <div class="f_bor_tr">
                        <div class="m-tj-pic">
                            <a href="/product?product_id={{@$product->product_id}}" class="u-lott-pic">
                                <img src="{{@$product->product_img}}" border="0" alt="{{@$product->product_name}}">
                                <div class="zhuangxiang"></div>
                            </a>
                        </div>
                        <p class="g-name">(第
                            <em>{{@$product->go_now_qishu}}
                            </em>期){{@$product->product_name}}
                        </p>
                        <div class="Progress-bar">
                            <p class="u-progress">
                                <span class="pgbar" style="width:{{(1 - $product->has_go / @$product->go_number) * 100}}%;">
                                    <span class="pging">
                                    </span>
                                </span>
                            </p>
                            <ul class="Pro-bar-li">
                                {{--<li class="P-bar01">
                                    <em>剩：{{@$product->has_go}}人次
                                    </em>
                                </li>
                                <li class="P-bar02">
                                    <em>总人次：{{@$product->go_number}}
                                    </em>
                                </li>--}}
<!--                                 <li class="P-bar03">
                                    <em>已买：{{@$product->level_go}}人次
                                    </em>
                                </li> -->

                                    <li class="P-bar04">
                                        <em>价值：￥{{@$product->product_price}}
                                        </em>
                                    </li>
                            </ul>
                        </div>
                        <div class="btn-wrap">
                            <div class="star" codeid="{{@$product->product_id}}">
                            </div>
                            <a href="javascript:;" class="buy-btn addCart" pid="{{@$product->product_id}}" n=1 qishu="{{@$product->go_now_qishu}}" t=1 >立即快购
                            </a>
                            <a href="javascript:;" class="gRate addCart" pid="{{@$product->product_id}}" n=1 qishu="{{@$product->go_now_qishu}}" t=2>
                                <s>
                                </s>
                            </a>
                        </div>
                    </div>
                </li>
                @endforeach

            </ul>
            <div id="divGoodsLoading" data-page="1" data-isload="no" style="display: none" class=""><s></s></div>
        </article>
    </section>
    <span class="check_more" style="display: block;">点击查看更多...</span>
    <div class="footer_w">
        <a href="http://www.miibeian.gov.cn">{{$site->site_icp}}</a>
        <br>
        <span>{{$site->site_name}}拥有对该网站的最终解释权</span>
    </div>
    <div class="hidefirend" style="display: none;"></div>
    <div class="friendarea" style="">
        <ul class="friend_content">
        </ul>
    </div>
    <div id="wximg">
        <p>
            客服QQ:{{@$site->site_qq}}        </p>
            <p>
                客服微信:{{@$site->site_name}}
            </p>
            <img src="/chyyg1/weixin-service.png">
        </div>
         <div id="cc">
                <div id="service_info">
                    <ul>
                        <li style="color:#dc332d;">客服时间：早08:30 至 晚18:00</li>
                        <li><a href="http://wpa.qq.com/msgrd?v=1&amp;uin={{@$site->site_qq}}&amp;site=qq&amp;menu=yes" target="_blank">客服QQ：{{@$site->site_qq}}</a></li>
                        <li><a href="tel:{{@$site->site_400}}">客服电话：{{@$site->site_400}}</a></li>
                    </ul>
                    <div id="service_code">
                        <p>长按二维码，添加客服微信</p>
                        <img src="/chyyg1/weixin.png">
                    </div>
                </div>
            </div>
    @endsection
    @section('my-js')
    <!--开启全站微信分享自定义-->
<script type="text/javascript" src="/chyyg1/jquery.cookie.js"></script>
<!--end-->
    <script language="javascript" type="text/javascript">
        var Path = new Object();
        Path.Skin = "{{Request::root()}}";
        Path.Webpath = "{{Request::root()}}";
        Path.imgpath = "{{Request::root()}}";
        Path.remoteImg = "{{Request::root()}}";
        var showlink="";

        var Base = {
            head: document.getElementsByTagName("head")[0] || document.documentElement,
            Myload: function (B, A) {
                this.done = false;
                B.onload = B.onreadystatechange = function () {
                    if (!this.done && (!this.readyState || this.readyState === "loaded" || this.readyState === "complete")) {
                        this.done = true;
                        A();
                        B.onload = B.onreadystatechange = null;
                        if (this.head && B.parentNode) {
                            this.head.removeChild(B)
                        }
                    }
                }
            },
            getScript: function (A, C) {
                var B = function () {
                };
                if (C != undefined) {
                    B = C
                }
                var D = document.createElement("script");
                D.setAttribute("language", "javascript");
                D.setAttribute("type", "text/javascript");
                D.setAttribute("src", A);
                this.head.appendChild(D);
                this.Myload(D, B)
            },
            getStyle: function (A, B) {
                var B = function () {
                };
                if (callBack != undefined) {
                    B = callBack
                }
                var C = document.createElement("link");
                C.setAttribute("type", "text/css");
                C.setAttribute("rel", "stylesheet");
                C.setAttribute("href", A);
                this.head.appendChild(C);
                this.Myload(C, B)
            }
        };

        Base.getScript('{{Request::root()}}/chyyg1/Bottom.js');

        $(function () {
            var div_subscribe = $("#div_subscribe");
            var index_show = $.cookie('div_subscribe_show');
            if (!index_show) {
                div_subscribe.show();
            }

            $(".popimage").fancybox({
                openEffect: 'none',
                closeEffect: 'none',
                closeClick: true,
            });
            div_subscribe.find(".close-icon").click(function () {
                $("#div_subscribe").hide();
                $.cookie('div_subscribe_show', '1', {expires: 1});
            });

            var mySwiper = new Swiper('.swiper-container', {
                lazyLoading: true,
                longSwipesRatio: 0.1, //最小拖动距离
                speed: 500, //切换速度
                autoplay: 5000, //自动滑动,多少时间后切换
                autoplayDisableOnInteraction: false, //人工切换操作后是否关闭自动切换
                /*scrollbar: '.swiper-scrollbar', //滚动条
                scrollbarHide: true, //滚动条是否自动隐藏*/
                pagination : '.swiper-pagination',
                paginationClickable : false,
                loop : true,
            });


            //立即快购
            $(document).on("click", '.buy-btn[codeid]', function (o) {
                addCar(1, $(this).attr('codeid'));
            });
            //添加到购物车
            $(document).on("click", '.gRate[codeid]', function (o) {
                addCar(0, $(this).attr('codeid'));
            })


            function addCar(r, codeid) {
                // $.getJSON('{{Request::root()}}/index.php/mobile/cart/addShopCart/' + codeid + '/1', function (data) {
                //     if (data.code == 1) {
                //         if (r == 1 && data.redirect == 'ok') { //不可添加数量但可购买数量大于1
                //             location.href = "{{Request::root()}}/index.php/mobile/cart/cartlist";
                //         } else {
                //             addsuccess('本件商品您已达到限购上限');
                //         }
                //         //addsuccess('添加失败');
                //     } else if (data.code == 2) {
                //         addsuccess('添加失败，购物车已满');
                //     } else {
                //         if (r == 0) {
                //             //addsuccess('添加成功');
                //             var img = $("li#" + codeid + " img");
                //             var src = img.attr("src");
                //             var cart = $("#btnCart");
                //             var arr = [
                //                 img.attr("src"),
                //                 img.offset().left + "px",
                //                 img.offset().top + "px",
                //                 cart.offset().left + 20 + "px",
                //                 cart.offset().top + 10 + "px"
                //             ];
                //             imgFun(arr);
                //         } else {
                //             location.href = "{{Request::root()}}/index.php/mobile/cart/cartlist"
                //         }
                //         //更新购物车数量
                //         $("#btnCart > i").append('<em>' + data.num + '</em>');
                //     }
                //     return false;
                // });
            }
            function addsuccess(dat) {
                $("#pageDialogBG .Prompt").text("");
                var w = ($(window).width() - 255) / 2, h = ($(window).height() - 45) / 2;
                $("#pageDialogBG").css({top: h, left: w, opacity: 0.8});
                $("#pageDialogBG").stop().fadeIn(1000);
                $("#pageDialogBG .Prompt").append('<s></s>' + dat);
                setTimeout(function () {
                    $("#pageDialogBG").fadeOut(1000);
                }, 1000);
            }

            var nav = $("#goodsNav");
            var nav_top = 0;
            var elm = $("#divGoodsLoading");
            var remove = false;
            //即将揭晓,人气,最新,价格
            $("#ulOrder li").click(function () {
                var parm = $(this).attr('order');
                console.log('welkin');
                console.log(parm);
                console.log($("#parm_order").val());
                if (parm) {
                    if (parm < 0)return;
                    if(parm == "50") $(this).attr('order', "60");
                    else if(parm == "60") $(this).attr('order', "50");

                    // 即将揭晓正倒序
                    if(parm == "10") $(this).attr('order', "11");
                    else if(parm == "11") $(this).attr('order', "10");

                    elm.attr("data-page", "1").attr("data-isload", "yes");
                    $("#parm_order").val(parm);
                    glist_json();
                    remove = true;
                    var re = $("#ulRecommend");
                    re.parent().css("height", re.height());
                    re.css("position", "absolute").fadeOut(200);
                    if(parm==20){
                        $(".check_more").show();
                    }else{
                        $(".check_more").hide();
                    }
                }
                $("#ulOrder .current").removeClass('current');
                $(this).addClass('current');
                if(nav_top == 0) nav_top = nav.offset().top;
                dl.hide();
            });
            var dl = $("#goodsNav .select-total");
            $("#divSort").click(function () {
                dl.toggle(); //改用toggle切换显示状态
            });
            $(".sort_list li[sortid]").click(function () {
                var sortid = parseInt($(this).attr("sortid"));
                // console.log('welkin func');
                location.href = "{{Request::root()}}/glists?category_id=" + sortid;
            });
            function glist_json() {
                if(elm.attr("data-isload") == "yes" && !elm.hasClass("loading")) {
                    elm.addClass("loading");
                    var order = $("#parm_order").val();
                    var page = elm.attr("data-page");
                    var url = '{{Request::root()}}/api/index_get_product/' + order + "/" + page + "?num=20";
                    $.getJSON(url, {model: 0}, function (data) {
                        var re = $("#ulRecommend");
                        if(remove) {
                            re.children().remove();
                        }

                        //判断特殊商品
                        var cat_mark, cust = "";

                        //人气排序预加载：在指定位置后插入选中分类下的n个即将满员的商品
                        var index = "";
                        if (data.index) {
                            index = data.index;
                        }
                        if (data.cust) {
                            for (var x = 0; x < data.cust.length; x++) {
                                cat_mark = "";
                                if (data.cust[x].cateid == 59) { //二人快购
                                    cat_mark = " cat-double";
                                } else if (data.cust[x].cateid ==  60) { //限购商品
                                    cat_mark =" cat-limit";
                                } else if (data.cust[x].cateid ==  66) { //123商品
                                    cat_mark =" cat-three";
                                }

                                cust += '<li id="' + data.cust[x].sid + '"><div class="f_bor_tr"><div class="m-tj-pic">';
                                cust += '<a href="{{Request::root()}}/product?product_id=' + data.cust[x].sid + '" class="u-lott-pic' + cat_mark + '">'
                                cust += '<img src="{{Request::root()}}/statics/templates/ffxiang/images/loading.gif" src2="' + getOSSImage_300(data.cust[x].thumb) + '" border=0 alt=""/>';
                                cust += '</a>';
                               /* cust += '<ins class="u-promo">第' + data.cust[x].qishu + '期' + '</ins></div>';*/
                                cust += '</div>';
                                cust += '<p class="g-name">(第<em>' + data.cust[x].qishu + '</em>期)' + data.cust[x].title + '</p>';
                                cust += '<div class="Progress-bar">';
                                cust += '<p class="u-progress"><span class="pgbar" style="width:' + (1 - data.cust[x].shenyurenshu / data.cust[x].zongrenshu) * 100 + '%;"><span class="pging"></span></span></p>';
                                cust += '<ul class="Pro-bar-li">';
                                cust += '<li class="P-bar01"><em>' + (data.cust[x].zongrenshu - data.cust[x].shenyurenshu) + '</em></li>';
                                cust += '<li class="P-bar02"><em>' + data.cust[x].zongrenshu + '</em></li>';
                                cust += '<li class="P-bar03"><em>' + data.cust[x].shenyurenshu + '</em></li>';
                                cust += '</ul>';
                                cust += '</div>';
                                cust += '<div class="btn-wrap"><div class="star" codeid="' + data.cust[x].sid  + '"></div><a href="javascript:;" class="buy-btn" codeid="' + data.cust[x].sid + '"">立即快购</a>';
                                cust += '<a href="javascript:;" class="gRate" codeid="' + data.cust[x].sid + '"><s></s></a>';
                                cust += '</div></div></li>';
                            }
                        }
                        /*end*/

                        var ul = "";

                        var shop = data.shoplist;
                        for (var i = 0; i < shop.length; i++) {
                            cat_mark = "";
                            if (shop[i].cateid == 59) { //二人快购
                                cat_mark = " cat-double";
                            } else if (shop[i].cateid ==  60) { //限购商品
                                cat_mark =" cat-limit";
                            } else if (shop[i].cateid ==  66) { //123商品
                                cat_mark =" cat-three";
                            }

                            ul += '<li id="' + shop[i].sid + '"><div class="f_bor_tr"><div class="m-tj-pic">';
                            ul += '<a href="{{Request::root()}}/product?product_id=' + shop[i].sid + '" class="u-lott-pic' + cat_mark + '">'
                            ul += '<img src="{{Request::root()}}/chyyg1/loading.gif" src2="' + shop[i].thumb + '" border=0 alt=""/>';
                            ul += '</a>';
                            /* ul += '<ins class="u-promo">第' + shop[i].qishu + '期' + '</ins></div>';*/
                            ul += '</div>';
                            ul += '<p class="g-name">(第<em>' + shop[i].qishu + '</em>期)' + shop[i].title + '</p>';
                            ul += '<div class="Progress-bar">';
                            ul += '<p class="u-progress"><span class="pgbar" style="width:' + (1 - shop[i].shenyurenshu / shop[i].zongrenshu) * 100 + '%;"><span class="pging"></span></span></p>';
                            ul += '<ul class="Pro-bar-li">';
                            ul += '<li class="P-bar01" style="width:100% !important"><em> 总价值：' +  shop[i].product_price + '</em></li>';
                            // ul += '<li class="P-bar02"><em> 总人次：' + shop[i].zongrenshu + '</em></li>';
                            // ul += '<li class="P-bar03"><em>' + shop[i].shenyurenshu + '</em></li>';
                            ul += '</ul>';
                            ul += '</div>';
                            ul += '<div class="btn-wrap"><div class="star" codeid="' + shop[i].sid + '"></div><a href="javascript:;" class="buy-btn add addCart" qishu=' +shop[i].qishu + '  t=1 n=1 pid= ' +shop[i].sid+ ' codeid="' + shop[i].sid + '"">立即快购</a>';
                            ul += '<a href="javascript:;" class="gRate addCart" qishu=' +shop[i].qishu + ' t=2 n=1 pid= ' +shop[i].sid+ ' codeid="' + shop[i].sid + '"><s></s></a>';
                            ul += '</div></div></li>';
                        }
                        ul += cust;
                        re.append(ul);

                        if(remove) {
                            remove = false;
                            re.css("position", "relative").fadeIn(300);
                            re.parent().css("height", "auto");
                            $(window).scrollTop(nav_top);
                        }
                        if (shop.length < 20) {
                            elm.removeClass("loading").attr("data-isload", "no");
                        } else {
                            elm.removeClass("loading").attr("data-page", parseInt(page) + 1);
                        }

                        if (order == "20") { //人气分类商品后台改为一次性输出，异步禁用 2017/03/27
                            elm.removeClass("loading").attr("data-isload", "no");
                            $(".check_more").css("display","block");
                        }

                        loadImgFun(0);
                    });
                }
            }

            var i = false;
            var bodyScroll = function () {
                var cHeight = document.documentElement.clientHeight;
                var sTop = $(document).scrollTop();
                var height = cHeight + sTop;
                var eTop = elm.offset().top;
                if (height >= eTop) {
                    glist_json();
                }
//                dl.hide();
                if(nav_top == 0) nav_top = nav.offset().top;
                if (sTop >= nav_top) {
                    if (i) {
                        return
                    }
                    i = true;
                    nav.parent().addClass("nav-wrapper");
                } else {
                    i = false;
                    nav.parent().removeClass("nav-wrapper");
                }

                $(".friendarea").slideUp();
                $(".hidefirend").hide();
            };
            window.onload = function () {
                $(window).bind("scroll", bodyScroll);
                glist_json();
            };

            /*商品分类栏check事件*/
            $(".sort_list label").click(function (e) {
                if (e && e.stopPropagation) {//非IE浏览器
                    e.stopPropagation();
                } else {//IE浏览器
                    window.event.cancelBubble = true;
                }
            });

            $(".sort_list input").click(function (e) {
                if (e && e.stopPropagation) {//非IE浏览器
                    e.stopPropagation();
                } else {//IE浏览器
                    window.event.cancelBubble = true;
                }
            });

            $(".check_more").click(function(){
                var last_product_id = $("#ulRecommend>li:last").attr('id');
                window.location.href = "{{Request::root()}}/glists";
            });

            function getNum () { //计算已添加数量
                var selectLen = $(".doChk").length;
                if (selectLen > 0) {
                    $("#addAll em").addClass("num");
                    var totalNum = 0;
                    for (var i=0; i<selectLen; i++) {
                        totalNum += parseInt($(".doChk").eq(i).next().text());
                    }
                    if (totalNum > 200) {
                        totalNum = "200+";
                    }
                    $("#addAll em").html("已选&nbsp;" + totalNum + "&nbsp;件");
                } else {
                    $("#addAll em").removeClass("num").text("（最多200件）");
                }
            }

            $("#chk0").change(function () {
                var value = $(this).prop("checked");
                if (value == true) {
                    $(".cateChk").not(":eq(0)").not(".red").prop("checked", true).addClass("disabled doChk");
                    $(".cateChk.red").prop("checked", false).removeClass("doChk");
                } else {
                    $(".cateChk").not(":eq(0)").not(".red").prop("checked", false).removeClass("disabled doChk");
                }

                //回调函数
                getNum();
            });

            $(".cateChk").not(":eq(0)").not(".red").change(function () {
                var value = $(this).prop("checked");
                if (value) {
                    $(this).addClass("doChk");
                    chkLen();
                } else {
                    $(this).removeClass("doChk");
                    $("#chk0").prop("checked", false);
                    $(".cateChk").not(":eq(0)").not(".red").removeClass("disabled");
                }

                getNum();
            });

            $(".cateChk.red").change(function () {
                var value = $(this).prop("checked");
                if (value) {
                    $(this).addClass("doChk");
                    $("#chk0").prop("checked", false);
                    $(".cateChk").not(":eq(0)").not(".red").removeClass("disabled");
                } else {
                    $(this).removeClass("doChk");
                    chkLen();
                }

                getNum();
            });

            //添加到购物车按钮事件
            $("#addCat").click(function () {
                var Len = $(".doChk").length;
                if (Len > 0) {
                    //开始向后台发送数据，将商品添加到购物车
                    var allCate = $("#chk0").prop("checked");
                    if (allCate) {
                        var cid = 0;
                    } else {
                        var value, cid = "";
                        for (var i=0; i<Len; i++) {
                            value = $(".doChk").eq(i).val();
                            if (i != (Len - 1)) {
                                cid += value + ",";
                            } else {
                                cid += value;
                            }
                        }
                    }
                    $.getJSON("{{Request::root()}}/index.php/mobile/cart/addAllToCart", {"cid": cid}, function (json) {
                        if (json.success == true) {
                            var num = json.num;
                            var successNum = json.successNum;
                            $("#btnCart i").html("<em>" + num + "</em>");
                            addsuccess("成功添加" + successNum + "件商品，跳转中");
                            $(".cateChk").prop("checked", false);
                            setTimeout(function () {
                                window.location.href = "{{Request::root()}}/index.php/mobile/cart/cartlist";
                            }, 2000);
                        } else {
                            var message = json.message;
                            addsuccess(message);
                        }
                    });
                } else {
                    addsuccess("请选择商品分类");
                }
            });
            /*end*/

            /*收起分类列表*/
            $("#catUp").click(function () {
                dl.slideUp();
            });

            /*chicken*/
            $("#chk").click(function () {
                window.location.href = "{{Request::root()}}/index.php/mobile/chicken/chicken_index";
            });
            /*end*/

            $(".friendlink").bind("click",function(event){
                event.preventDefault();
            })

        });

        /*判断选择事件（一键添加商品）*/
        function chkLen() {
            var simple = $(".cateChk").not(":eq(0)").not(".red");
            var simpleLen = simple.length;
            var smChkLen = $(".cateChk.doChk").not(".red").length;
            var redLen = $(".cateChk.red.doChk").length;
            //console.log(simpleLen + "," + smChkLen + "," + redLen);
            if ((simpleLen == smChkLen) && redLen == 0) {
                $("#chk0").prop("checked", true);
                simple.prop("checked", true).addClass("disabled");
            }
        }
        /**/

        var btnsearch=$("#btnsearch");
        var WEB_PATH="{{Request::root()}}/index.php";
        btnsearch.click(function () {
            window.location.href=WEB_PATH+"/mobile/mobile/search";
        });

        var parWidth = $(".anouncement").width();
        var anlenght = $("#anMarquee")[0].scrollWidth - parWidth / 2;
        function MarqueeAnimate() {
            $("#anMarquee").css("margin-left", parWidth + "px");
            $("#anMarquee").animate({marginLeft: "-" + anlenght + "px"}, 25000, "linear", MarqueeAnimate);
        }
        MarqueeAnimate();


        /*首页揭晓部分滑动处理*/
        // $(document).ready(function(){
        //    var winwidth=$(window).width();//获取屏幕宽度
        //    var liheight=$("#divLottery").find("li").height();//获取揭晓li的高度
        //    $("#divLottery").parent().css("height",liheight+"px");//设置滑动条父类的高度
        //    $("#divLottery").css("height",liheight+"px");//设置滑动条高度 防止溢出
        //    var liwidth=winwidth / 4;//计算li的宽度
        //    $("#divLottery").find("li").css("width",liwidth);//设置li的宽度
        //    $("#divLottery").css("width", 5 * liwidth);//设置滑动条的宽度 +1 是为了防止溢出
        // });

        // /*屏幕切换时重新设置滑动条的宽高*/
        // $(window).resize(function(){
        //     var winwidth=$(window).width();
        //     var liheight=$("#divLottery").find("li").height();
        //     $("#divLottery").parent().css("height",liheight+"px");
        //     $("#divLottery").css("height",liheight+"px");
        //     var liwidth=winwidth / 4;
        //     $("#divLottery").find("li").css("width",liwidth);
        //     $("#divLottery").css("width", 5 * liwidth);

        //     //重置通知栏滚动距离
        //     parWidth = $(".anouncement").width();
        //     anlenght = $("#anMarquee")[0].scrollWidth - parWidth / 2;
        // });
        /*滑动条结束*/

        /*友情链接*/
          $(document).ready(function(){
              if($("#partner ul li").length>=5){
                  $("#partner").find(".ptn").css("width","20%");
              }

               if(showlink==1) {
                   $("#partner").find(".ptn").css("width","20%");
               }

               $(".friendlink").click(function(){
                   $(".friendarea").slideDown();
                   $(".hidefirend").show();
               })

                $(".hidefirend").click(function(){
                    $(".friendarea").slideUp();
                    $(".hidefirend").hide();
                })
              /*end*/
               $('#service_bg').height($(document).height());
                $('#service_pic').click(function(){
                    $('#service_info').css('display','block');
                    $('#service_bg').css('display','block');
                });
                $('#service_bg').click(function(){
                    $('#service_info').css('display','none');
                    $('#service_bg').css('display','none');
                });
                $('#chkg_bg').height($(document).height());
                $('#chkg_pic').click(function(){
                    $('#chkg_info').css('display','block');
                    $('#chkg_bg').css('display','block');
                });
                $('#chkg_bg').click(function(){
                    $('#chkg_info').css('display','none');
                    $('#chkg_bg').css('display','none');
                });
              /*招募中..*/
              $("#friendlink").find("a[status='wait']").click(function(){
                  $("#wximg").show(1000);
                  $(".wximghide").show();
                  $(".wximghide").click(function(){
                      $("#wximg").hide();
                      $(".wximghide").hide();
                  })
              })
              /*end*/

              /*收藏*/
              $(document).on("click", '.star', function (o) {
                  var codeid=$(this).attr("codeid");
                  $(this).addClass("stars");
                  addCollect(codeid);
              })

              function addCollect(codeid)
              {
                  $.getJSON("{{Request::root()}}/index.php/mobile/mobile/addcollect",{codeid:codeid},function(json){
                      addsuccess(json.tip);
                  })
              }

              function addsuccess(dat) {
                  $("#pageDialogBG .Prompt").text("");
                  var w = ($(window).width() - 255) / 2, h = ($(window).height() - 45) / 2;
                  $("#pageDialogBG").css({top: h, left: w, opacity: 0.8});
                  $("#pageDialogBG").stop().fadeIn(1000);
                  $("#pageDialogBG .Prompt").append('<s></s>' + dat);
                  setTimeout(function () {
                      $("#pageDialogBG").fadeOut(1000);
                  }, 1000);
              }
              /*end*/

              var flowerwidth=$(".flower").width();
              var flowerheight=$(".flower").width();
              $(".flower").css("height",flowerheight+"px");

              //公告历史
              $("#notice").click(function () {
                  window.location.href = '{{Request::root()}}/index.php/mobile/mobile/noticeLog';
              });
           });
    </script>
    <script type="text/javascript">
        $(".f_home > a").addClass("hover");
    </script>

    @endsection
