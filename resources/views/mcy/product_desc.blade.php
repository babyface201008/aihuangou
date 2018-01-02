@extends('mcy.layout')
@section('title','title')
@section('my-css')
<style>
    .recordCon img {
        width: 100% !important;
        display: block;
    }
    body {
        background-color: rgb(255, 255, 255);
        width: 100%;
    }
    table {
        width: 100% !important;
    }
</style>
@endsection
@section('content')
    <header class="g-header">
        <div class="head-l">
            <a href="javascript:;" onclick="history.go(-1)" class="z-HReturn"><s></s><b>返回</b></a>
        </div>
        <h2></h2>
        <div class="head-r">
            <a id="btnSort" href="javascript:;" class="z-sort"><i></i>排序<s class="z-SswOn"></s><s class="z-SswNt"></s></a>
        </div>
    </header>

    <!-- 快购记录 -->
    <section id="buyRecordPage" class="goodsCon">
        <div id="divRecordList" class="recordCon z-minheight" style="display:block;">
        {!!$product->product_desc!!}
        </div>
    </section>
@endsection

@section('my-js')

@endsection