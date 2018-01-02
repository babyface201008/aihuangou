@extends('welkin.layout')
@section('title','后台充值管理')
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
                        <h5>充值管理 当前列表金额：<span style="color:red;"> {{$money}}</span><small> 
                        <!-- <a class="btn btn-sm btn-success" href="/welkin/mcy/topup/create">添加充值</a> -->
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
                                <input placeholder="开始日期" class="form-control layer-date" name="starttime" id="starttime" value="{{@$starttime}}">
                            </div>
                            <div class="col-sm-3 m-b-xs ">
                                <input placeholder="结束日期" class="form-control layer-date" name="endtime" id="endtime"  value="{{@$endtime}}">
                            </div>
                            <div class="col-sm-1">
                            用户类型：
                                <select name="is_robot" id="is_robot" data-placeholder="选择用户类型.." class="chosen-select select select-text" style="width:120px;">
                                    <option @if(@$is_robot == 0) selected="selected" @endif value="0" hassubinfo="true">正常用户</option>
                                    <option @if(@$is_robot == 1) selected="selected" @endif value="1" hassubinfo="true">特殊用户</option>
                                </select>
                            </div>
                            <div class="col-sm-1">
                            充值类型：
                            <select name="status" id="status" data-placeholder="选择充值状态.." class="chosen-select select select-text" style="width:120px;">
                                    <option @if(@$status == 1) selected="selected" @endif value="1" hassubinfo="true">已支付</option>
                                    <option @if(@$status == 0) selected="selected" @endif value="0" hassubinfo="true">未支付</option>
                                    <option @if(@$status == 2) selected="selected" @endif value="2" hassubinfo="true">已取消</option>
                                </select>
                            </div>
                            <div class="col-sm-1 m-b-xs">
                                <button type="button" class="btn btn-sm btn-primary btnsearch"> 搜索</button> 
                            </div>
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <input type="text" placeholder="请输入订单号" name="order_no" value="{{@$order_no}}" class="input-sm form-control"> <span class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-primary btnsearch"> 搜索</button> </span>
                                </div>
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
                                        <th>充值类型ID</th>
                                        <th>充值单号</th>
                                        <th>充值人</th>
                                        <th>充值人经验</th>
                                        <th>充值人ID</th>
                                        <th>充值金额</th>
                                        <th>充值时间</th>
                                        <!-- <th>充值</th> -->
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topups as $topup)
                                    <tr class="uid{{@$topup->mcy_user_id}}">
                                        <td>{{@$topup->payinfo_id}}</td>
                                        <td>{{@$topup->order_no}}</td>
                                        <td>{{@$topup->username}}</td>
                                        <td>{{@$topup->jingyan}}</td>
                                        <td>{{@$topup->mcy_user_id}}</td>
                                        <td>{{@$topup->price}}</td>
                                        <td>{{@$topup->created_at}}</td>
                                        <td>
                                        <a class="btn btn-sm btn-info updatetopup" target="_blank" href="/welkin/mcy/orders?searchid={{@$topup->mcy_user_id}}">查看购买记录</a>
                                        <!-- <button type="button" class="btn btn-sm btn-danger deletetopup" uname="{{@$topup->topupname}}" uid="{{@$topup->mcy_user_id}}" >删除</button> -->
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$topups->appends(['searchtext'=>@$searchtext,'is_robot'=>@$is_robot,'status'=>@$status,'order_no'=>@$order_no,'starttime'=>@$_GET['starttime'],'endtime'=>@$_GET['endtime']])->links()}}
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
    var start={elem:"#starttime",format:"YYYY-MM-DD hh:mm:ss",max:"2099-06-16 23:59:59",istime:true,istoday:false,choose:function(datas){end.min=datas;end.start=datas}};var end={elem:"#endtime",format:"YYYY-MM-DD hh:mm:ss",min:laydate.now(),max:"2099-06-16 23:59:59",istime:true,istoday:false,choose:function(datas){start.max=datas}};laydate(start);laydate(end);
    $(".btnsearch").on('click',function(){
        var searchtext = $("input[name=searchtext]").val(),
            starttime = $("input[name=starttime]").val(),
            order_no = $("input[name=order_no]").val(),
            status = $("select[name=status]").val(),
            is_robot = $("select[name=is_robot]").val(),
            endtime = $("input[name=endtime]").val();
        location.href = '/welkin/mcy/topups?searchtext='+ searchtext + '&starttime=' + starttime + '&order_no=' + order_no + '&endtime='+ endtime + '&is_robot='+ is_robot+ '&status='+ status;
    });

    $('.deletetopup').on('click',function(){
        var uid = $(this).attr('uid'),
            name = $(this).attr('uname');
        parent.layer.confirm('确定删除名称为' + name + '的充值?',function(){
           $.ajax({
            url : '/api/welkin/mcy/topup/delete',
              type : 'post',
              async : false,
              dataType : 'json',
              data : {
                _token : "{!! csrf_token() !!}",
                topup_id : uid
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
              $(".uid"+data.topup_id).hide();
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

    </script>

@endsection