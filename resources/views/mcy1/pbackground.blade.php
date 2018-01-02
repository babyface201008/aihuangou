@extends('mcy.layout')
@section('title','梦苍源')
@section('my-css')
 <link rel="stylesheet" href="/css/app.css"> 
@endsection
@section('content')
<div id="app">
	<router-view></router-view>
</div>
@endsection
@section('my-js')
 <script src="/js/app.js"></script>
@endsection