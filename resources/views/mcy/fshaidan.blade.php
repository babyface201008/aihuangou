@extends('mcy.layout')
@section('title','晒单')
@section('my-css')
 <link href="/chyyg1/single.css" rel="stylesheet" type="text/css">
 <style>
 .pagination {
    display: block;
    width: 100%;
    text-align: center;
    height: 50px;
    margin-top: -14px;
 }
 .pagination li {
    display: inline-block;
    width: 50px;
    height: 50px;
    background-color: white;
    border-radius: 5px;
    line-height: 50px;
    font-size: 20px;
 }
 .pagination .active {
    color: red;
    background-color: #d5efd2;
 }
 </style>
@endsection
@section('content')
    <!-- 晒单记录 -->
    <section class="goodsCon">
    	<div class="cSingleCon">
    		<div id="postList" class="cSingleCon2" style="display:block;" z-minheight="">
    			@foreach($shaidans as $shaidan)
    			<div class="cSingleInfo">
    				<dl class="fl"><a href="#"><img src="{{@$shaidan->avator_img}}"><b></b></a></dl>
    				<div class="cSingleR m-round" id="{{@$shaidan->shaidan_id}}">
    					<ul>
    						<li><em class="blue" >{{@$shaidan->username}}</em><strong>：</strong><span>{{@$shaidan->shaidan_title}}</span></li>
    						<li><h3><b>第{{@$shaidan->qishu}}期晒单</b> {{@$shaidan->shaidan_created_at}}</h3></li>
    						<li><p>{{@$shaidan->shaidan_content}}</p></li>
    						<li class="maxImg">
    							<img src="{{@$shaidan->shaidan_img}}">
    						</li>
    						<li><dd><s></s><strong>0</strong>人羡慕嫉妒</dd><dd><i></i><strong>0</strong>条评论</dd></li>
    					</ul><b class="z-arrow"></b>
    				</div>
    			</div>
    			@endforeach
    		</div>
                         {{$shaidans->links()}}
    	</div>
    </section>
@endsection
@section('my-js')
 <script>
 	var page = 1;
 	
 	$(".cSingleInfo li:not(:first)").click(function(){
 		var id=$(this).parent().parent().attr('id');
 		if(id){
 			window.location.href="/fshaidan/detail?shaidan_id="+id;
 		}			
 	});
 </script>
 <script type="text/javascript">
 	$(".f_car  > a").addClass("hover");
 </script>
@endsection