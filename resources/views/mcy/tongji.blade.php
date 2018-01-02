@extends('welkin.layout')
@section('title','后台统计')
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
                                    @foreach($tongjis as $tongji)
                                    <tr class="uid{{@$tongji->mcy_user_id}}">
                                        <td>{{@$tongji->payinfo_id}}</td>
                                        <td>{{@$tongji->order_no}}</td>
                                        <td>{{@$tongji->username}}</td>
                                        <td>{{@$tongji->jingyan}}</td>
                                        <td>{{@$tongji->mcy_user_id}}</td>
                                        <td>{{@$tongji->price}}</td>
                                        <td>{{@$tongji->created_at}}</td>
                                        <td>
                                        <a class="btn btn-sm btn-info updatetongji" target="_blank" href="/welkin/mcy/orders?searchid={{@$tongji->mcy_user_id}}">查看购买记录</a>
                                        <!-- <button type="button" class="btn btn-sm btn-danger deletetongji" uname="{{@$tongji->tongjiname}}" uid="{{@$tongji->mcy_user_id}}" >删除</button> -->
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$tongjis->appends(['searchtext'=>@$searchtext,'is_robot'=>@$is_robot,'status'=>@$status,'order_no'=>@$order_no,'starttime'=>@$_GET['starttime'],'endtime'=>@$_GET['endtime']])->links()}}
                        </div>

                    </div>
                </div>
            </div>
            <h5>统计 当前列表金额：<span style="color:red;"> {{$money}}</span><small>  </small></h5>
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
        location.href = '/welkin/mcy/tongjis?searchtext='+ searchtext + '&starttime=' + starttime + '&order_no=' + order_no + '&endtime='+ endtime + '&is_robot='+ is_robot+ '&status='+ status;
    });

    </script>

@endsection