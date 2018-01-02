@extends('welkin.layout')
@section('title','后台充值管理')
@section('my-css')
    <link href="/admin/css/plugins/iCheck/custom.css" rel="stylesheet"> 
    <style type="text/css">
        .red { color: red; }
        .green { color: green; }
    </style>
@endsection
@section('content')
 
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>用户金额变化 <small> 
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
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" placeholder="请输入ID" name="searchtext" value="{{@$searchtext}}" class="input-sm form-control"> <span class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-primary btnsearch"> 搜索</button> </span>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>用户ID</th>
                                        <th>用户昵称</th>
                                        <th>原有金额</th>
                                        <th>修改金额</th>
                                        <th>变化金额</th>
                                        <th>原有积分</th>
                                        <th>修改积分</th>
                                        <th>变化积分</th>
                                        <th>原有佣金</th>
                                        <th>修改佣金</th>
                                        <th>变化佣金</th>
                                        <th>修改时间</th>
                                        <!-- <th>充值</th> -->
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user_update_searchs as $user_update_search)
                                    <tr class="uid{{@$user_update_search->mcy_user_id}}">
                                        <td>{{@$user_update_search->mcy_user_id}}</td>
                                        <td>{{@$user_update_search->username}}</td>
                                        <td>{{@$user_update_search->money_origin}}</td>
                                        <td>{{@$user_update_search->money_update}}</td>
                                        <td class="@if($user_update_search->money_change > 0) red @elseif ($user_update_search->money_change < 0) green @endif">{{@$user_update_search->money_change}}</td>
                                        <td>{{@$user_update_search->score_origin}}</td>
                                        <td>{{@$user_update_search->score_update}}</td>
                                        <td class="@if($user_update_search->score_change > 0) red @elseif ($user_update_search->score_change < 0) green @endif">{{@$user_update_search->score_change}}</td>
                                        <td>{{@$user_update_search->slave_money_origin}}</td>
                                        <td>{{@$user_update_search->slave_money_update}}</td>
                                        <td class="@if($user_update_search->slave_money_change > 0) red @elseif ($user_update_search->slave_money_change < 0) green @endif">{{@$user_update_search->slave_money_change}}</td>
                                        <td>{{@$user_update_search->created_at}}</td>
                                        <td>
                                        <a class="btn btn-sm btn-info updateuser_update_search" target="_blank" href="/welkin/mcy/orders?searchid={{@$user_update_search->mcy_user_id}}">查看购买记录</a>
                                        <!-- <button type="button" class="btn btn-sm btn-danger deletetopup" uname="{{@$user_update_search->topupname}}" uid="{{@$user_update_search->mcy_user_id}}" >删除</button> -->
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$user_update_searchs->appends(['searchtext'=>@$searchtext,'starttime'=>@$_GET['starttime'],'endtime'=>@$_GET['endtime']])->links()}}
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
            endtime = $("input[name=endtime]").val();
        location.href = '/welkin/mcy/user/update/search?searchtext='+ searchtext + '&starttime=' + starttime +  '&endtime='+ endtime ;
    });

    </script>

@endsection