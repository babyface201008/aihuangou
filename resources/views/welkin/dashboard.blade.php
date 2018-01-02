@extends('welkin.layout')
@section('title','后台主页')
@section('my-css')

@endsection
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-sm-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>折线图</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-refresh refresh"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
					<div class="echarts" id="echarts-line-chart"></div>
				</div>
				<div class="ibox-content">
					<div class="echarts" id="echarts-pi"></div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('my-js')
 <script src="/js/plugins/echarts/echarts-all.js"></script>
<script type="text/javascript">
  	$(".btnsearch").on('click',function(){
 		var cday = $("input[name=cday]").val();
 		location.href = "/admin/dashboard?cday="+ cday;
 	});
	var days = '{{$days}}';
	var acs = '{{$acs}}';
	var p=echarts.init(document.getElementById("echarts-pi"));
	var e=echarts.init(document.getElementById("echarts-line-chart"));

	var orders = '{{@orders}}';
	option = {
		title : {
			text: '{{@$toptitle}}',
			subtext: ''
		},
		tooltip : {
			trigger: 'axis'
		},
		legend: {
			data:['{{@$lefttitle}}']
		},
		toolbox: {
			show : true,
			feature : {
				mark : {show: true},
				dataView : {show: true, readOnly: false},
				magicType : {show: true, type: ['line', 'bar']},
				restore : {show: true},
				saveAsImage : {show: true}
			}
		},
		calculable : true,
		xAxis : [
		{
			type : 'category',
			boundaryGap : false,
			data : days.split(",")
		}
		],
		yAxis : [
		{
			type : 'value',
			axisLabel : {
				formatter: '{value} 次数'
			}
		}
		],
		series : [
		{
			name:'{{@$lefttitle}}',
			type:'line',
			data:acs.split(","),
			markPoint : {
				data : [
				{type : 'max', name: '最大值'},
				{type : 'min', name: '最小值'}
				]
			},
			// markLine : {
			// 	data : [
			// 	{type : 'average', name: '平均值'}
			// 	]
			// }
		}
		]
	};
	option1 = {
		title : {
			text: '插件订单情况',
			// subtext: '纯属虚构',
			x:'center'
		},
		tooltip : {
			trigger: 'item',
			formatter: "{a} <br/>{b} : {c} ({d}%)"
		},
		legend: {
			orient : 'vertical',
			x : 'left',
			data:[
				@foreach($orders as $order)
				'{{@$order->plugin_name}}',
				@endforeach
			]
		},
		toolbox: {
			show : true,
			feature : {
				mark : {show: true},
				dataView : {show: true, readOnly: false},
				magicType : {
					show: true, 
					type: ['pie', 'funnel'],
					option: {
						funnel: {
							x: '25%',
							width: '50%',
							funnelAlign: 'left',
							max: 1548
						}
					}
				},
				restore : {show: true},
				saveAsImage : {show: true}
			}
		},
		calculable : true,
		series : [
		{
			name:'访问来源',
			type:'pie',
			radius : '55%',
			center: ['50%', '60%'],
			data:[
				@foreach($orders as $order)
				{value:{{@$order->plugin_num}}, name:'{{@$order->plugin_name}}'},
				@endforeach
			]
		}
		]
	};
	e.setOption(option,true),$(window).resize(e.resize);
	p.setOption(option1,true),$(window).resize(p.resize);


</script>
@endsection