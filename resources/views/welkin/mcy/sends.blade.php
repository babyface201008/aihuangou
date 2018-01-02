@extends('welkin.layout')
@section('title','后台发货单管理')
@section('my-css')
    <link href="/admin/css/plugins/iCheck/custom.css" rel="stylesheet"> 
    <style type="text/css">
        
    </style>
@endsection
@section('content')
 
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>发货单管理 /共计：{{@$sends->total()}} 项<small> 
                        <!-- <a class="btn btn-sm btn-success" href="/welkin/mcy/sends/create">添加发货单</a> -->
                        </small></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-refresh refresh"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-3 m-b-xs">
                                <input placeholder="开始日期" class="form-control layer-date" name="starttime" id="starttime" value="{{@$_GET['starttime']}}">
                            </div>
                            <div class="col-sm-3 m-b-xs ">
                                <input placeholder="结束日期" class="form-control layer-date" name="endtime" id="endtime"  value="{{@$_GET['endtime']}}">
                            </div>
                             <div class="col-sm-1">
                                <select name="is_robot" id="is_robot" data-placeholder="选择用户类型.." class="chosen-select" style="width:120px;">
                                    <option @if(@$is_robot == 0) selected="selected" @endif value="0" hassubinfo="true">普通用户</option>
                                    <option @if(@$is_robot == 1) selected="selected" @endif value="1" hassubinfo="true">高级用户</option>
                                </select>
                            </div>
                             <div class="col-sm-1">
                                <select name="order_status" id="order_status" data-placeholder="选择订单状态.." class="chosen-select" style="width:120px;">
                                    <option @if(@$order_status == 2) selected="selected" @endif value="2" hassubinfo="true">已支付</option>
                                    <option @if(@$order_status == 3) selected="selected" @endif value="3" hassubinfo="true">已发货</option>
                                </select>
                            </div>
                            <div class="col-sm-1 m-b-xs">
                                <button type="button" class="btn btn-sm btn-primary btnsearch"> 搜索</button> 
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" placeholder="请输入名称" name="searchtext" value="{{@$searchtext}}" class="input-sm form-control"> <span class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-primary btnsearch"> 搜索</button> </span>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <!-- <th></th> -->
                                        <th>订单号</th>
                                        <th>订单产品</th>
                                        <th>订单状态</th>
                                        <th>订单人</th>
                                        <th>订单人ID</th>
                                        <th>订单人注册手机</th>
                                        <th>订单地址</th>
                                        <th>联系电话</th>
                                        <th>联系人</th>
                                        <th>下单时间</th>
                                        <th>快递名称</th>
                                        <th>快递号</th>
                                        <th>备注</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sends as $send)
                                    <tr class="uid{{@$send->order_id}}">
                                 <!--  <td>
                                            <input type="checkbox" checked class="i-checks" name="input[]">
                                        </td> -->
                                        <td>{{@$send->order_no}}</td>
                                        <td><a href="{{Request::root()}}/going/product?product_id={{@$send->product_id}}&qishu={{@$send->qishu}}">{{@$send->product_name}}</a></td>
                                        <!-- <td>{{@$send->product_id}}</td> -->
                                        <!-- <td>{{@$send->qishu}}</td> -->
                                        <td>
                                            @if ($send->order_status == 1)
                                            未支付
                                            @elseif ($send->order_status ==2 && $send->order_deal!=3)
                                            已支付
                                            @elseif ($send->order_deal ==3)
                                            已送货
                                            @elseif ($send->order_status ==4)
                                            不送货
                                            @elseif ($send->order_status == 5)
                                            已退款
                                            @endif
                                        </td>
                                        <td>{{@$send->order_username}}</td>
                                        <td>{{@$send->mcy_user_id}}</td>
                                        <td>{{@$send->mobile}}</td>
                                        <td>{{@$send->order_addr}}</td>
                                        <td>{{@$send->order_mobile}}</td>
                                        <td>{{@$send->order_people}}</td>
                                        <td>{{@$send->created_at}}</td>
                                        <td>{{@$send->order_kd}}</td>
                                        <td>{{@$send->order_kd_number}}</td>
                                        <td>{{@$send->order_desc}}</td>
                                        <td>
                                        {{--<a class="btn btn-sm btn-info sendmessage1" oid="{{@$send->order_id}}" target="_blank" href="javascript:;">发送提醒消息</a>--}}
                                        <a class="btn btn-sm btn-danger sendmessage" oid="{{@$send->order_id}}"  product_name="{{@$send->product_name}}" target="_blank" href="javascript:;">发送发货消息</a>
                                        <a class="btn btn-sm btn-info updatesends" target="_blank" href="/welkin/mcy/sends/update?yungou_id={{@$send->yungou_id}}">填写发货信息</a>
                                        <!-- <button type="button" class="btn btn-sm btn-danger deletesends" uname="{{@$send->sendsname}}" uid="{{@$send->order_id}}" >删除</button> -->
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$sends->appends(['searchtext'=>$searchtext,'is_robot'=>$is_robot,'order_status'=>$order_status,'starttime'=>@$_GET['starttime'],'endtime'=>@$_GET['endtime']])->links()}} 
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@section('my-js')
    <script src="/admin/js/plugins/layer/laydate/laydate.js"></script>
    <script src="/admin/js/plugins/peity/jquery.peity.min.js"></script>
    <script src="/admin/js/demo/peity-demo.min.js"></script>
    <script>
        $(document).ready(function(){$(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",})});
    var start={elem:"#starttime",format:"YYYY-MM-DD",max:"2099-06-16 23:59:59",istime:true,istoday:false,choose:function(datas){end.min=datas;end.start=datas}};var end={elem:"#endtime",format:"YYYY-MM-DD",min:laydate.now(),max:"2099-06-16 23:59:59",istime:true,istoday:false,choose:function(datas){start.max=datas}};laydate(start);laydate(end);
    $(".btnsearch").on('click',function(){
        var searchtext = $("input[name=searchtext]").val(),
            starttime = $("input[name=starttime]").val(),
            is_robot = $("select[name=is_robot]").val(),
            order_status = $("select[name=order_status]").val(),
            endtime = $("input[name=endtime]").val();
            location.href = '/welkin/mcy/sends?searchtext='+ searchtext + '&starttime=' + starttime + '&endtime='+ endtime+ '&is_robot='+ is_robot+ '&order_status='+ order_status;
    });

    $('.deletesends').on('click',function(){
        var uid = $(this).attr('uid'),
            name = $(this).attr('uname');
        parent.layer.confirm('确定删除名称为' + name + '的发货单?',function(){
           $.ajax({
            url : '/api/welkin/mcy/sends/delete',
              type : 'post',
              async : false,
              dataType : 'json',
              data : {
                _token : "{!! csrf_token() !!}",
                sends_id : uid
            },
            success: function(data) {
                console.log(data);
                if(data == null) {
                  layer.msg('服务端错误', {icon:2, time:2000});
                  return;
              }
              if(data.ret != 0) {
                  layer.msg(data.msg, {icon:2, time:2000});
                  return;
              }
              layer.msg(data.msg,{icon:1,time:2000});
              $(".uid"+data.sends_id).hide();
              parent.layer.closeAll();

          },
          error: function(xhr, ret, error) {
            console.log(xhr);
            console.log(ret);
            console.log(error);
            layer.msg('ajax error', {icon:2, time:2000});
        },
        beforeSend: function(xhr){
            layer.load(0, {shade: false});
        },
        complete: function(){
            layer.closeAll('loading');
        },
    });
       });

    }); 
    $('.sendmessage').on('click',function(){
        var oid = $(this).attr('oid');
        var product_name = $(this).attr('product_name');
        parent.layer.confirm('确定发送通知?',function(){
           $.ajax({
            url : '/api/welkin/mcy/sends/message',
              type : 'post',
              async : false,
              dataType : 'json',
              data : {
                _token : "{!! csrf_token() !!}",
                sends_id : oid,
                product_name : product_name,
                sends_id : oid,
            },
            success: function(data) {
                parent.layer.closeAll();

                if(data == null) {
                  layer.msg('服务端错误', {icon:2, time:2000});
                  return;
              }
              if(data.ret != 0) {
                  layer.msg(data.msg, {icon:2, time:2000});
                  return;
              }
              layer.msg(data.msg,{icon:1,time:2000});

          },
          error: function(xhr, ret, error) {
            console.log(xhr);
            console.log(ret);
            console.log(error);
            layer.msg('ajax error', {icon:2, time:2000});
        },
        beforeSend: function(xhr){
            layer.load(0, {shade: false});
        },
        complete: function(){
            layer.closeAll('loading');
        },
    });
       });

    });
    $('.sendmessage1').on('click',function(){
        var oid = $(this).attr('oid');
        parent.layer.confirm('确定发送通知?',function(){
           $.ajax({
            url : '/api/welkin/mcy/sends/message1',
              type : 'post',
              async : false,
              dataType : 'json',
              data : {
                _token : "{!! csrf_token() !!}",
                sends_id : oid
            },
            success: function(data) {
                console.log(data);
                if(data == null) {
                  layer.msg('服务端错误', {icon:2, time:2000});
                  return;
              }
              if(data.ret != 0) {
                  layer.msg(data.msg, {icon:2, time:2000});
                  return;
              }
              layer.msg(data.msg,{icon:1,time:2000});
              parent.layer.closeAll();

          },
          error: function(xhr, ret, error) {
            console.log(xhr);
            console.log(ret);
            console.log(error);
            layer.msg('ajax error', {icon:2, time:2000});
        },
        beforeSend: function(xhr){
            layer.load(0, {shade: false});
        },
        complete: function(){
            layer.closeAll('loading');
        },
    });
       });

    });
   $(".chosen-select").chosen({disable_search_threshold: 10});

    </script>

@endsection