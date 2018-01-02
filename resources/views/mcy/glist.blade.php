@extends('mcy.layout')
@section('title','商品列表')
@section('my-css')
<link href="/chyyg1/goods.css" rel="stylesheet" type="text/css"/>
 <style>
    .order_list {
        width: 100%;
    }
    .order_list::after {
        clear: both;
        content: "";
        display: table;
    }
    .order_list li {
        box-sizing: border-box;
        float: left;
        height: 44px;
        line-height: 42px;
        width: 100%;
    }
    .order_list li:not(:last-of-type) {
        border-bottom: 1px solid rgba(246,246,246,.8);
    }
    .order_list a {
        color: #666;
        display: block;
        font-size: 14px;
        padding: 0 15px;
    }
    .order_list li.current a {
        color: #dc332d;
    }

    em.cat-limit { /*限购商品标示*/
        display: block;
        position: absolute;
        width: 49px;
        height: 49px;
        background: transparent url("/images/cat_mark.png?v=1.3") no-repeat 0 -49px / 49px 147px;
        bottom: 0;
        right: 0;
    }
    em.cat-double { /*二人快购商品标示*/
        display: block;
        position: absolute;
        width: 49px;
        height: 49px;
        background: transparent url("/images/cat_mark.png?v=1.3") no-repeat 0 0 / 49px 147px;
        bottom: 0;
        right: 0;
    }
    em.cat-three { /*123商品标示*/
        display: block;
        position: absolute;
        width: 49px;
        height: 49px;
        background: transparent url("/images/cat_mark.png?v=1.4") no-repeat 0 -99px / 49px 147px;
        bottom: 0;
        right: 0;
    }
    #divGoodsLoading {
        width: 100%;
        height: 40px;
        text-align: center;
        margin-bottom: 4px;
        line-height: 26px;
    }
    #divGoodsLoading[data-isload="no"] s{
        width: 100%;
        text-align: center;
        text-decoration: none;
    }
    #divGoodsLoading[data-isload="no"] s::before {
        content: "我们是有底线的！！";
        color: #999;
        text-align: center;
        width: 100%;
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
        background: transparent url("/chyyg1/check_.png") center 51px / 130% 390%;
        text-align: center;
        line-height: 44px;
        color: #CCC;
    }
    .cateChk:checked + label, .cateChk.red:checked + label {
        background-position-y: -7px;
        color: #dc332d;
    }
    li:first-child .cateChk:checked + label {
        background-image: url("/chyyg1/check_bak.png");
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

    /*特殊分类说明*/
    #divSort span:last-of-type em {
        display: block;
        position: absolute;
        width: 1rem;
        height: 1rem;
        top: calc(50% - .5rem);
        right: 0.2rem;
        background: #dc332d;
        border-radius: 50%;
        z-index: 111;
    }
    #divSort span:last-of-type em::after{
        content: "?";
        color: #fff;
        position: absolute;
        top: calc(50% - 1.2rem);
        right: 0.22rem;
    }

    em.double i {
        display: none;
        width: 13.2rem;
        height: 3rem;
        padding: 0 5px;
        margin: 1.8rem 0 0 -3rem;
        line-height: 1.5rem;
        text-align: left;
        letter-spacing: 1px;
        color: #CCC;
        background: #FFF;
        border: 1px solid #dc332d;
        border-radius: 3px;
        -webkit-user-select: none;
    }

    em.double.notice i {
        display: block;
    }

    em.double i::before {
        content: ' ';
        display: block;
        width: .5rem;
        height: .5rem;
        background: #FFF;
        border-width: 1px 0 0 1px;
        border-style: solid;
        border-color: #dc332d;
        -webkit-transform: rotate(45deg);
        margin: -.3rem 0 -.2rem 3.1rem;
    }

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
</style>
@endsection
@section('content')
 <section class="goodsCon">
        <!-- 导航 -->
        <nav class="nav-wrapper" id="goodsNav">
            <input type="hidden" id="search" value=""/>
            <input type="hidden" id="parm_order" value="{{@$order}}"/>
            <input type="hidden" id="parm_cate" value="{{@$category_id}}"/>
            <!--点击添加或移除current-->
            <div class="select-btn current" id="divSort">
                <span class="arrow-up"></span>
                    <span class="select-icon">
                        <i></i><i></i><i></i>
                    </span>
                <span>商品分类</span>
            </div>
            <!--分类-->
            <div id="selectSort" class="select-total">
                <ul class="sort_list">
                    <li sortid="0">
                        <a href="javascript:;">全部商品</a>
                        <input id="chk0" class="cateChk" type="checkbox" name="0" value="0" />
                        <label for="chk0"></label>
                    </li>
                    @foreach($categorys as $category)
                    <li sortid="{{@$category->category_id}}">
                        <a href="javascript:;">{{$category->name}}</a>
                        <input id="chk{{@$category->category_id}}" class="cateChk" type="checkbox" name="{{@$category->category_id}}" value="{{@$category->category_id}}" />
                        <label for="chk{{@$category->category_id}}">{{@$category->count}}</label>
                    </li>
                    @endforeach

                </ul>

            </div>
            <div class="select-btn" id="divOrder">
                <span>即将揭晓</span>
            </div>
            <div id="selectOrder" class="select-total">
                <ul class="order_list">
                    <li order="10"><a href="javascript:;">即将揭晓</a></li>
                    <li order="20"><a href="javascript:;">人气</a></li>
                    <li order="30"><a href="javascript:;">最新</a></li>
                    <li order="50"><a href="javascript:;">价格</a></li>
                </ul>
            </div>
        </nav>
        <!-- 列表 -->
        <div id="goods_list" class="goodsList" style="padding-top: 40px">
        </div>
        <div id="divGoodsLoading" data-page="1" data-isload="yes"><s></s></div>
    </section>


@endsection
@section('my-js')
 <script type="text/javascript">
      var Path = new Object();
        Path.Skin = "{{Request::root()}}";
        Path.Webpath = "{{Request::root()}}";
        Path.imgpath = "{{Request::root()}}";
        Path.remoteImg = "http://wmcy.oss-cn-hangzhou.aliyuncs.com";
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
        }

        Base.getScript('{{Request::root()}}/chyyg1/Bottom.js');

        //打开页面加载数据
        window.onload = function () {
            var cate = $("#parm_cate").val();
            var t = $("#goodsNav li[sortid='"+ cate + "']").addClass("current").find("a").html();
            $("#divSort > span:last").html(t);
            if (cate == 59) {
                $("#divSort > span:last").append('<em class="double"><i>二人快购商品每期只有2人次，<br>每人次价格为商品总价格的一半</i></em>');
                notice();
            };

            var order = $("#parm_order").val();
            var t = $("#goodsNav li[order='"+ order + "']").addClass("current").find("a").html();
            $("#divOrder > span").html(t);

            glist_json();
        };

        var elm = $("#divGoodsLoading");
        //获取数据
        function glist_json() {
            if(elm.attr("data-isload") == "yes" && !elm.hasClass("loading")) {
                elm.addClass("loading");
                var search = $("#search").val();
                var order = $("#parm_order").val();
                var cate = $("#parm_cate").val();
                var page = elm.attr("data-page");
                var url = '{{Request::root()}}/glistajax/' + cate + "/" + order + "/" + page;
                if (search != "") {
                    url = url + '?s=' + search;
                }
                $.getJSON(url, function (data) {
                    var shop = data.shoplist;
                    // for (var i = 0; i < shop.length; i++) {
                    // shop.each(function(i,k){
                    $.each(shop,function(i,k){
                        //判断特殊商品
                        var cat_mark = "";
                        var limitTxt = "";
                        if (shop[i].extend_model == 11) { //二人快购
                            cat_mark = "<em class='cat-double'></em>";
                        } else if (shop[i].extend_model ==  12) { //限购商品
                            cat_mark ="<em class='cat-limit'></em>";
                            limitTxt = "<span class='purchase-txt'>限购" + shop[i].extend.limitNum + "人次</span>";
                        } else if (shop[i].extend_model ==  13) { //123商品
                            cat_mark ="<em class='cat-three'></em>";
                        }

                        var ul = '<ul id="' + shop[i].sid + '"><li>';
                        ul += '<span class="z-Limg"><img style="cursor: pointer" src="' + (shop[i].thumb) + '">' + cat_mark +'<div class="zhuangxiang"></div></span>';
                        ul += '<div class="goodsListR">';
                        ul += '<h2>(第' + shop[i].qishu + '期)' + shop[i].title + '</h2>';
                        ul += '<p class="price">价值：<em class="arial gray">￥' + shop[i].money + '</em>' + limitTxt + '</p>';
                        ul += '<div class="pRate">';
                        ul += '<div class="Progress-bar">';
                        ul += '<p class="u-progress"><span class="pgbar" style="width:' + (1 - shop[i].shenyurenshu / shop[i].zongrenshu) * 100 + '%;"><span class="pging"></span></span></p>';
                        ul += '<ul class="Pro-bar-li">';
                        ul += '<li class="P-bar01 welkinbar01"><em>' + (shop[i].zongrenshu - shop[i].shenyurenshu) + '</em>已参与</li>';
                        ul += '<li class="P-bar02 welkinbar02"><em>' + shop[i].zongrenshu + '</em>总需人次</li>';
                        ul += '<li class="P-bar03 welkinbar03"><em>' + shop[i].shenyurenshu + '</em>剩余</li>';
                        ul += '</ul></div>';
                        ul += '<a class="add addCart" t="2" qishu=' +shop[i].qishu + ' n=1 pid= ' +shop[i].sid+ ' codeid="' + shop[i].sid + '" href="javascript:;"><s></s></a>';
                        ul += '</div></div></li></ul>';
                        $("#goods_list").append(ul);
                    });
                    // }
                    if (shop.length < 20) {
                        elm.removeClass("loading").attr("data-isload", "no");
                    } else {
                        elm.removeClass("loading").attr("data-page", parseInt(page) + 1);
                    }
                });
            }
        }

        $(document).ready(function () {
            //商品分类
            var dl = $("#selectSort"),
                arrow_up = $("#divSort .arrow-up");
            $("#divSort").click(function () {
                if (dl.css("display") == 'none') {
                    dl.show();
                    arrow_up.show();
                    dr.hide();
                } else {
                    dl.hide();
                    arrow_up.hide();
                }
            });
            $("#goodsNav li[sortid]").click(function () {
                var t = $(this).find("a").html();
                var id = parseInt($(this).attr('sortid'));
                if (id < 0)return;
                $("#parm_cate").val(id);
                elm.attr("data-page", "1").attr("data-isload", "yes");
                $("#goods_list").children().remove();
                glist_json();

                $("#divSort > span:last").html(t);
                if (t == '二人快购') {
                    $("#divSort > span:last").append('<em class="double"><i>二人快购商品每期只有2人次，<br>每人次价格为商品总价格的一半</i></em>');
                    notice();
                };
                dl.hide();
                arrow_up.hide();
                $("#selectSort .current").removeClass('current');
                $(this).addClass('current');
            });
            var dr = $("#selectOrder");
            $("#divOrder").click(function () {
                if (dr.css("display") == 'none') {
                    dr.show();
                    dl.hide();
                    arrow_up.hide();
                } else {
                    dr.hide();
                }
            });
            $("#goodsNav li[order]").click(function () {
                var t = $(this).find("a").html();
                var id = parseInt($(this).attr('order'));
                if (id < 0)return;
                if(id == "50") $(this).attr('order', "60");
                else if(id == "60") $(this).attr('order', "50");
                $("#parm_order").val(id);
                elm.attr("data-page", "1").attr("data-isload", "yes");
                $("#goods_list").children().remove();
                glist_json();

                $("#divOrder > span").html(t);
                dr.hide();
                $("#selectOrder .current").removeClass('current');
                $(this).addClass('current');
            });

            $(window).scroll(function () {
                var cHeight = document.documentElement.clientHeight;
                var sTop = $(window).scrollTop();
                var height = cHeight + sTop;
                var eTop = elm.offset().top;
                if (height >= eTop) {
                    glist_json();
                }

                dl.hide();
                arrow_up.hide();
                dr.hide();

                $("em.double.notice").removeClass("notice"); //滚动时自动隐藏提示
            });

            //添加到购物车
            $(document).on("click", '.add', function (o) {
                dl.hide();
                // arrow_up.hide();
                
                dr.hide();
            });
            function addsuccess(dat) {
                $("#pageDialogBG .Prompt").text("");
                var w = ($(window).width() - 255) / 2,
                        h = ($(window).height() - 45) / 2;
                $("#pageDialogBG").css({top: h, left: w, opacity: 0.8});
                $("#pageDialogBG").stop().fadeIn(1000);
                $("#pageDialogBG .Prompt").append('<s></s>' + dat);
                $("#pageDialogBG").fadeOut(1000);
            }

            //跳转页面
            $(document).on('click', '.goodsList ul', function () {
                var id = $(this).attr('id');
                if (id) {
                    window.location.href = "{{Request::root()}}/product?product_id=" + id;
                }
            });


            /*商品分类栏check事件*/
            $(".sort_list label").click(function (e) {
                //阻止冒泡
                if (e && e.stopPropagation) {//非IE浏览器
                    e.stopPropagation();
                } else {//IE浏览器
                    window.event.cancelBubble = true;
                }
            });

            $(".sort_list input").click(function (e) {
                //阻止冒泡
                if (e && e.stopPropagation) {//非IE浏览器
                    e.stopPropagation();
                } else {//IE浏览器
                    window.event.cancelBubble = true;
                }
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
                    $.getJSON("{{Request::root()}}/mobile/cart/addAllToCart", {"cid": cid}, function (json) {
                        if (json.success == true) {
                            var num = json.num;
                            var successNum = json.successNum;
                            $("#btnCart i").html("<em>" + num + "</em>");
                            addsuccess("成功添加" + successNum + "件商品，跳转中");
                            $(".cateChk").prop("checked", false);
                           /* setTimeout(function () {
                                window.location.href = "{{Request::root()}}/mobile/cart/cartlist";
                            }, 2000);*/
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
                arrow_up.hide();
            });

            setTimeout(function () { //自动展开分类栏（由购物车‘一键添加商品’跳转过来）
                var url = window.location.href;
                if (url.indexOf('oneKey') != -1) {
                    $("#selectSort").slideDown(1000);
                }
            }, 1000);

        });


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

        function notice () { //特殊商品提示
            $("em.double").click(function (e) {
                e.stopPropagation();
                $(this).toggleClass("notice");
            });
        }
 </script>
   <script type="text/javascript">
        $(".f_allgoods  > a").addClass("hover");
    </script>
@endsection