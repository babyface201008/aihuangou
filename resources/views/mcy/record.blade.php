@extends('mcy.layout')
@section('title','我的快购记录')
@section('my-css')
<style>
#btnLoadMore3 {
    width: 100%;
    height: 40px;
    text-align: center;
    margin-bottom: 4px;
    line-height: 26px;
}
#btnLoadMore3 s{
width: 100%;
text-align: center;
text-decoration: none;
}
#btnLoadMore3 s::before {
content: "亲，真的没有了~";
color: #999;
text-align: center;
width: 100%;
}
.pBtn a.buyBtn {

    background: #dc332d;

    border: 1px solid #EF6000;

}

.pBtn a.addBtn {

    background: #ffb320;

    border: 1px solid #FDA700;

}
.pBtn a.collectBtn
{
    background:#22AAFF ;

    border:1px solid #00b3ff;

    margin-right: 0px;

    width: 20%;
}

.joinAndGet {

    width: 100%;

    padding-top: 5px;

}

.joinAndGet dl a {

    display: block;

    color: #666;

    border-radius: 3px;

    height: 38px;

    line-height: 38px;

    margin: 10px 8px 0;

    padding: 0 13px;

    font-size: 14px;

    border: 1px solid #dcdcdc;

    border-radius: 5px;

    background: #fff;

    box-shadow: 1px 1px 1px #e7e7e7;

}

.joinAndGet dl a b {

    border-width: 2px 2px 0 0;

    position: relative;

    top: 15px;

}

.joinAndGet dl a em {

    color: #C0C0C0;

    font-size: 10px;

}

.joinAndGet dl a span {

    margin: 0 2px;

}

.joinAndGet dl a strong {

    font-weight: normal;

    margin: 0 2px 0 10px;

}

.joinAndGet ul {

    clear: both;

    padding: 10px;

    margin: 10px 8px 0;

    position: relative;

    color: #999;

}

.joinAndGet ul a {

    display: block;

    position: absolute;

    top: 0;

    left: 0;

    width: 100%;

    height: 100%;

    z-index: 10;

}

.joinAndGet li img {

    width: 70px;

    height: 70px;

    border-radius: 5px;

}

.joinAndGet li.getInfo {

    margin-left: 80px;

    line-height: 18px;

    font-size: 0.5em !important;

}

.joinAndGet li b {

    border-width: 2px 2px 0 0;

    margin-top: 40px;

    text-align: right;

}

.joinAndGet ul s {

    background-repeat: no-repeat;

    background-position: 0 0;

    width: 61px;

    height: 61px;

    position: absolute;

    left: -2px;

    top: -2px;

}

.recordCon {

    position: relative;

    margin-top: 1px;

    height: 100%;

    border-left: 1px solid #efefef;

}

.recordCon img {
    width: 100% !important;
    display: block
}

.recordCon ul {

    border-bottom: 1px solid #efefef;

    padding: 15px 0;

    position: relative;

    margin-top: -1px;

}

.recordCon li {

    color: #999;

    line-height: 20px;

    font-size: 12px;

}

.recordCon li.rBg {

    position: absolute;

    left: 0px;

    z-index: 15;

}

.recordCon li.rBg a {

    display: block;

    position: relative;

}

.recordCon li img {

    width: 40px !important;

    height: 40px;

    margin: 2px 0 0 3px;

}

.recordCon li.rBg a s {

    background-position: -44px -99px;

    background-repeat: no-repeat;

    width: 46px;

    height: 46px;

    position: absolute;

    left: 0;

    top: 0;

}

.recordCon li.rInfo {

    margin-left: 55px;

}

.recordCon a {

    color: #2af;

    font-size: 14px;

    margin-right: 3px;

}

.recordCon span {

    margin-right: 10px;

    font-size: 14px;

}

.recordCon em {

    color: #ccc;

}

.recordCon strong {

    word-wrap: break-word;

    display: inline-block;

    font-weight: normal;

}

.recordCon i {

    background: url(../Images/r-line.gif) no-repeat;

    height: 1px;

    width: 230px;

    position: absolute;

    left: 0;

    top: -1px;

}
</style>
  
@endsection
@section('content')
   <input type="hidden" id="hid-sid" value="{{@$product_id}}">
    <input type="hidden" id="hid-qishu" value="{{@$qishu}}">

    <!-- 云购记录 -->
    <section id="buyRecordPage" class="goodsCon">
        <div id="divRecordList" class="recordCon" style="display:block;">

        </div>
        <div class="goodsList">
            <div id="divGoodsLoading" data-isload="yes" style="display:none;"><b></b>正在加载...</div>
            <a id="btnLoadMore" class="loading" href="javascript:;" style="display:none;"><s></s></a>
            <a id="btnLoadMore3" class="loading" style="display:none;"><s></s></a>
        </div>
    </section>
<!-- <div id="divBuyList" class="m_buylist m_buylist_n">
    <ul id="ul_list">
        <div class="noRecords colorbbb clearfix">
            <s class="z-y8"></s>最近还没有参与快购？<br> 梦想与您只有1元的距离！~</div>
        </ul>
        <div id="divLoading" class="loading clearfix g-acc-bg" style="display: none;"><b></b>正在加载</div>
    </div> -->
@endsection
@section('my-js')
<script language="javascript" type="text/javascript" src="/chyyg1/static/Bottom.js"></script>
<script type="text/javascript">
    var rid = 0; //最新id不变
    var sid = $("#hid-sid").val();
    var qishu = $("#hid-qishu").val();
    var pos = 0;
    var table = 0;
    //打开页面加载数据
    window.onload = function () {
        glist_json(sid + "/" + qishu + "/" + table + "/" + pos + "/" + rid);
    }
    //获取数据
    function glist_json(parm) {
        if ($("#divGoodsLoading").attr("data-isload") == "yes" && !$("#divGoodsLoading").hasClass("loading")) {
            $("#divGoodsLoading").addClass("loading");
            $.getJSON('{{Request::root()}}/apiGetBuyRecords/' + parm, function (data) {
                if (pos == 0) {
                    rid = data.records[data.records.length - 1].go_id; //进入页面后，保持最新id不变，避免异步加载重复数据
                }
                pos = data.pos;
                table = data.table;
                var records = data.records;
                var length = records.length;
                for (var i = 0; i < length; i++) {
                    var record = records[i];
                    var ul = '<ul><li class="rBg">' +
                            '<a href="' + '{{Request::root()}}' + '/userinfo/' + record.uid + '">' +
                            '<img id="imgUserPhoto" src="' + record.uphoto + '" border="0"/>' +
                            '<s></s></a></li><li class="rInfo">' +
                            '<a href="' + '{{Request::root()}}' + '/userinfo/' + record.uid + '">' + record.user +'<span class="user_buy_addr"> (购买地址:' +record.ip+ ')</span> </a>' +
                            '<strong></strong><br><span>云购了<b class="orange">' + record.gonumber + '</b>人次</span>' +
                            '<em class="arial">' + record.time.date + '</em></li><i></i></ul>';

                    $("#divRecordList").append(ul);
                }
                if (length == 10) {
                    $("#btnLoadMore").css('display', 'block');
                } else {
                    $("#btnLoadMore").css('display', 'none');
                    $("#btnLoadMore3").css('display', 'block');
                    $("#btnLoadMore3").removeClass("loading");
                    $("#divGoodsLoading").attr("data-isload", "no");
                }
                $("#divGoodsLoading").removeClass("loading");
            });
        }
    }
    $(document).ready(function () {
        // 远添加了自动加载功能
        $(window).scroll(function () {
            var cHeight = document.documentElement.clientHeight;
            var sTop = $(window).scrollTop();
            var height = cHeight + sTop;
            var eTop = $("#btnLoadMore").offset().top - 300;
            if (height >= eTop) {
                glist_json(sid + "/" + qishu + "/" + table + "/" + pos + "/" + rid);
                console.log('welkin');
            }
        });
    });

</script>
@endsection