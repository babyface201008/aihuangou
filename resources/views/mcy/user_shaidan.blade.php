@extends('mcy.layout')
@section('title','我的晒单')
@section('my-css')
 <link href="/chyyg1/single.css" rel="stylesheet" type="text/css">
<style type="text/css">
	.shaidan_text{
		text-align: center;
		font-size: 150%;
		width: 200px;
		height: 200px;
	}
	.fl {
		margin: 10px 15px;
	    float: left;
	}
	.fl img {
	    width: 80px;
	    height: 80px;
	    display: inline-block;
	    overflow: hidden;
	}
	.shaidan_dl {
		    padding: 10px 5px;
	}
</style>
@endsection
@section('content')
<div class="g-goods-single">
		@if(isset($shaidans))
			@foreach($shaidans as $shaidan)
			<ul id="ul_list">
				<li postid="{{$shaidan->shaidan_id}}">
					<p class="fl"><img src="{{$shaidan->shaidan_img}}"></p>
					<dl class="shaidan_dl">
						<dt><a href="#" class="blue">{{@$shaidan->username}}</a></dt>
						<dd class="gray6">{{@$shaidan->title}}</dd>
						<dd class="gray9">{{@$shaidan->shaidan_content}}</dd>
						<dd class="colorbbb">{{@$shaidan->created_at}}</dd>
					</dl>
				</li>
			</ul>
			@endforeach
			<div class="noRecords colorbbb clearfix">
				<s class="z-y9"></s>亲，没有了哟 ~
			</div>
		@else
		<div class="noRecords colorbbb clearfix">
			<s class="z-y9"></s>主银，您还没有晒单记录哟 ~
		</div>
		@endif
	<!-- <div id="divLoading" class="loading clearfix g-acc-bg"><b></b>正在加载</div> -->
</div>
@endsection
@section('my-js')
  <script type="text/javascript">
    $(".f_personal  > a").addClass("hover");
</script>
@endsection