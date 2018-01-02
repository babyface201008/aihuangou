@extends('mcy.layout')
@section('title','最新揭晓')
@section('my-css')
<style>
	.rolling-number {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 32px;
		z-index: 10;
		background: rgba(250, 250, 250, 0.9);
		padding: 4px;
		text-align: center;
		border-bottom: 1px solid #CCC;
		font-size: 16px;
		clear: both;
	}
	.rolling-number .rolling-content {
		margin: 4px auto;
		width: 280px;
	}
	.rolling-number .rolling-content ul {
		float: left;
		color: #dc332d;
	}
	.rolling-number .rolling-title {
		height: 22px;
		line-height: 22px;
		padding: 0 5px;
		float: left;
		color: #999;
	}
	.rolling-number .rolling-content ul li.num {
		position: relative;
		border: 1px solid #CCC;
		display: inline-block;
		width: 18px;
		font-size: 16px;
		overflow: hidden;
		height: 22px;
		line-height: 22px;
	}
	.rolling-number .rolling-content ul li cite {
		width: 18px;
		position: absolute;
		left: 0;
		z-index: 1;
	}
	.rolling-number .rolling-content ul li cite em {
		width: 18px;
		display: block;
	}
	.rolling-number li i {
		border-top: 1px solid #ededed;
		height: 0;
		left: 0;
		position: absolute;
		top: 11px;
		width: 100%;
		z-index: 0;
	}
	.fixed_header{
		position: fixed;
		display: flex;
		height:40px;
		width: 100%;
		background: #FFF;
		z-index: 1;
	}
	.fixed_header .fixed_content{
		flex-grow: 1;
		box-sizing: border-box;
		text-align: center;
		line-height: 40px;
		border-left: 1px solid #dddddd;
		border-bottom: 1px solid #dddddd;
	}
	.fixed_header .fixed_content a{
		width: 100%;
		height:100%;
		cursor: pointer;
		display: block;
		font-size: 14px;
		color: #999090;
	}
	.fixed_header .fixed_content.active{
		border-bottom: 2px solid #dc332d;
	}
	.fixed_header .fixed_content.active a {
		color: #dc332d;
	}
</style>
</script><link href="/chyyg1/lottery.css" rel="stylesheet" type="text/css">


@endsection
@section('content')
    <section class="revealed">
        <!--div class="rolling-number">
            <div class="rolling-content" id="rolling">
                <span class="rolling-title">参与</span>
                <ul>
                    <li class="num"></li>
                    <li class="num"></li>
                    <li class="num"></li>
                    <li class="num"></li>
                    <li class="num"></li>
                    <li class="num"></li>
                    <li class="num"></li>
                    <li class="num"></li>
                    <li class="num"></li>
                </ul>
                <span class="rolling-title">人次</span>
            </div>
        </div-->
	        <input id="newgid" type="hidden" value="{{@$lotterying[0]->yungou_id}}"/>
	    	<div id="divLottery" class="revCon">
            <div id="divLotteryLoading" class="loading" style="margin: 10px 0;"><s></s></div>
            <a id="btnLoadMore" class="loading" href="javascript:;" style="display: none;opacity: 0"></a>
        </div>
    </section>
@endsection
@section('my-js')
<script language="javascript" type="text/javascript" src="/chyyg1/Bottom.js"></script>
<script language="javascript" type="text/javascript" src="/chyyg1/BottomFun.js"></script>
<script language="javascript" type="text/javascript" src="/chyyg1/LotteryFun.js"></script>
<script language="javascript" type="text/javascript" src="/chyyg1/Comm.js"></script>
<script language="javascript" type="text/javascript" src="/chyyg1/LotteryTimeFun.js"></script></head>
<script>
	$(window).scroll(function () {
		var cHeight = document.documentElement.clientHeight;
		var sTop = $(window).scrollTop();
		var height = cHeight + sTop;
		var eTop = $("#btnLoadMore").offset().top - 300;
		if (height >= eTop) {
			if ($("#btnLoadMore").text() == "正在加载...")return;
			$("#btnLoadMore").click()
		}
	});
</script>
<script type="text/javascript">
        $(".f_announced  > a").addClass("hover");
    </script>
@endsection