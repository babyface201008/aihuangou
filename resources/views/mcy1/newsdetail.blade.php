@extends('mcy.layout')
@section('title','梦苍源')
@section('my-css')
     <script>
        document.write('<link rel="stylesheet" href="/css/newsdetail.css?rnd='+Math.random()+'">');
    </script>
@endsection
@section('content')
<div class="main_box wrapper">
    <div class="main_scroll">
        <p class="title"></p>
        <div class="from">
            <p class="from_name">来源：<span></span></p>
            <p class="from_time"></p>
        </div>
        <div class="intro_box"><p class="intro">导读</p><span></span></div>
        <div class="jdcontent" id="jdcontent">

        </div>
        <a class="original" href="">查看原文<img src="../../images/artical/chakany.png" ></a>
    </div>
</div>
@endsection
@section('my-js')
@endsection
