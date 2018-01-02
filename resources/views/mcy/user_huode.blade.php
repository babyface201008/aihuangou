@extends('mcy.layout')
@section('title','中奖记录')
@section('my-css')
<style type="text/css">
    .btn_r {
        color: red;
    }
    .huode_span  {
        width: 100%;
        display: block;
    }
    .huode_btn {
        display: inline-block;
        width: 48%;
        line-height: 24px;
        text-align: center;
        color: #dc332d;
        border: 1px solid #dc332d;
        border-radius: 7px;
        position: relative;
    }
</style>
<link href="/chyyg1/static/star.css" rel="stylesheet" type="text/css">

@endsection
@section('content')
   <div class="m_buylist m_get">
            <ul id="ul_list">
                <input type="hidden" value="{!! csrf_token() !!}" id="_token">
            @if(count($huode_list) <= 0)

                <div class="noRecords colorbbb clearfix">
                    <s class="z-y9"></s>主银，您最近还没有获得商品哦~
                </div>
            @else
                 <div  id="divGetGoods" class="colorbbb clearfix mBuyRecord">
                 @foreach($huode_list as $list)
                   <ul  class="BuyRecordList">
                   <li class="mBuyRecordL" onclick="location.href='/going/product?qishu={{$list->qishu}}&product_id={{$list->product_id}}'"><img src="{{$list->product_img}}"></li>
                   <li class="mBuyRecordR"><p class="BRtitle">(第{{$list->qishu}}期){{$list->product_name}}</p><p class="mValue">价值：¥{{$list->product_price}}</p>
                   <span>幸运云购码：<em class="orange">{{$list->huode_code}}</em><br>揭晓时间：{{$list->huode_order_time}} </span>
                   <span class="huode_span">
                       @if ($list->order_deal == 0 || $list->order_deal==1 || $list->order_deal==3)
                        @if (($list->order_mobile == ''))
                        <a href="/mcy/user/huode_list/create/kuaidi/{{$list->yungou_id}}" class="btn btn_r huode_btn">填写地址信息</a>
                        @else
                            @if ($list->order_kd == '')
                                <a href="#" class="btn btn_r huode_btn kuaidiloop" msg="正在加紧备货中" >备货中</a>
                            @else
                                <a href="#" class="btn btn_r huode_btn kuaidiloop" msg="{{$list->order_kd}}--{{$list->order_kd_number}}" >点击查看单号</a>
                            @endif
                        @endif
                       @endif

                       @if ($list->order_deal == 0 )
                               <a href="/mcy/user/duihuan/{{$list->yungou_id}}"  class="btn btn_r huode_btn"  style="margin-bottom: 8px">兑换福分</a>
                       @else
                               @if ($list->order_deal == 2)
                                   <a href="#" class="btn btn_r huode_btn kuaidiloop" msg="已兑换福分" >已兑换福分</a>
                               @endif

                       @endif
    {{--<a href="/mcy/user/fshaidan/create/{{$list->yungou_id}}" class="btn btn_r huode_btn">晒单</a>--}}
</span>
</li>
</ul>
@endforeach
</div>
@endif
<div class="hot-recom">
<div class="title thin-bor-top gray6"><span><b class="z-set"></b>人气推荐</span><em></em></div>
<div class="goods-wrap thin-bor-top">
   <!--  <ul class="goods-list clearfix">
        <li><a href="//v41/products/24003.do" class="g-pic"><img src="/chyyg1/20170414155920834.jpg" width="136" height="136"></a>
            <p
            class="g-name"><a href="//v41/products/24003.do">(第19949云)苹果（Apple）iPad 9.7英寸平板电脑 32G WLAN版</a></p>
            <ins
            class="gray9">价值:￥2666.00</ins>
            <div class="btn-wrap">
                <div class="Progress-bar">
                    <p class="u-progress"><span class="pgbar" style="width:4%;"><span class="pging"></span></span>
                    </p>
                </div>
                <div class="gRate" data-productid="24003">
                    <a href="javascript:;">
                        <s></s>
                    </a>
                </div>
            </div>
        </li>
        <li><a href="//v41/products/23251.do" class="g-pic"><img src="/chyyg1/20160530174846601.jpg" width="136" height="136"></a>
            <p
            class="g-name"><a href="//v41/products/23251.do">(第27045云)中国黄金 梯形投资金条 Au9999 50g</a></p>
            <ins
            class="gray9">价值:￥16500.00</ins>
            <div class="btn-wrap">
                <div class="Progress-bar">
                    <p class="u-progress"><span class="pgbar" style="width:9%;"><span class="pging"></span></span>
                    </p>
                </div>
                <div class="gRate" data-productid="23251">
                    <a href="javascript:;">
                        <s></s>
                    </a>
                </div>
            </div>
        </li>
        <li><a href="//v41/products/23924.do" class="g-pic"><img src="/chyyg1/20170320164351202.jpg" width="136" height="136"></a>
            <p
            class="g-name"><a href="//v41/products/23924.do">(第8069云)平安银行 五福临门金条 Au9999 15g</a></p>
            <ins
            class="gray9">价值:￥4950.00</ins>
            <div class="btn-wrap">
                <div class="Progress-bar">
                    <p class="u-progress"><span class="pgbar" style="width:7%;"><span class="pging"></span></span>
                    </p>
                </div>
                <div class="gRate" data-productid="23924">
                    <a href="javascript:;">
                        <s></s>
                    </a>
                </div>
            </div>
        </li>
        <li><a href="//v41/products/23490.do" class="g-pic"><img src="/chyyg1/20160923090132510.jpg" width="136" height="136"></a>
            <p
            class="g-name"><a href="//v41/products/23490.do">(第12726云)平安银行 金鸡送福金条 Au9999 20g</a></p>
            <ins
            class="gray9">价值:￥6600.00</ins>
            <div class="btn-wrap">
                <div class="Progress-bar">
                    <p class="u-progress"><span class="pgbar" style="width:12%;"><span class="pging"></span></span>
                    </p>
                </div>
                <div class="gRate" data-productid="23490">
                    <a href="javascript:;">
                        <s></s>
                    </a>
                </div>
            </div>
        </li>
    </ul> -->
</div>
</div>
</ul>
<div id="divLoading" class="loading clearfix g-acc-bg" style="display: none;"><b></b>正在加载</div>
</div>
@endsection
@section('my-js')
<script>
$(".kuaidiloop").on('click',function(){
var msg = $(this).attr('msg');
alert(msg);
return false;
});
</script>
<script id="pageJS" data="/chyyg1/userFun.js"></script>
@endsection