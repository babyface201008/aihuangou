@extends('welkin.layout')
@section('title','后台用户管理')
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
                        <h5>用户管理 <small> <a class="btn btn-sm btn-success" href="/welkin/mcy/user/create">添加用户</a>
                        </small> /共计 ：{{@$users->total()}} 用户</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-refresh refresh"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-1 m-b-xs">
                                <input placeholder="开始日期" class="form-control layer-date" name="starttime" id="starttime" value="{{@$_GET['starttime']}}">
                            </div>
                            <div class="col-sm-1 m-b-xs ">
                                <input placeholder="结束日期" class="form-control layer-date" name="endtime" id="endtime"  value="{{@$_GET['endtime']}}">
                            </div>
                            <div class="col-sm-1 m-b-xs">
                                <button type="button" class="btn btn-sm btn-primary btnsearch"> 搜索</button> 
                            </div>
                            <div class="col-sm-1">
                                <select name="is_robot" id="is_robot" data-placeholder="选择用户类型.." class="chosen-select" style="width:120px;">
                                    <option @if(@$is_robot == 0) selected="selected" @endif value="0" hassubinfo="true">0</option>
                                    <option @if(@$is_robot == 1) selected="selected" @endif value="1" hassubinfo="true">1</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <input type="text" placeholder="请输入ID" name="searchtext" value="{{@$searchtext}}" class="input-sm form-control"> <span class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-primary btnsearch"> 搜索</button> </span>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <input type="text" placeholder="请输入手机号码" name="searchmobile" value="{{@$searchmobile}}" class="input-sm form-control"> <span class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-primary btnsearch"> 搜索</button> </span>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <input type="text" placeholder="请输入上级ID" name="master_id" value="{{@$master_id}}" class="input-sm form-control"> <span class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-primary btnsearch"> 搜索</button> </span>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>

                                        <!-- <th></th> -->
                                        <th>ID</th>
                                        <th>名称</th>
                                        <th>手机</th>
                                        <th>金币</th>
                                        <th>经验值</th>
                                        <th>地址</th>
                                        <th>佣金</th>
                                        <th>上级ID</th>
                                        <th>创建时间</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr class="uid{{@$user->mcy_user_id}}">
                                 <!--  <td>
                                            <input type="checkbox" checked class="i-checks" name="input[]">
                                        </td> -->
                                        <td>{{@$user->mcy_user_id}}</td>
                                        <td>{{@$user->username}}</td>
                                        <td>{{@$user->mobile}}</td>
                                        <td>{{@$user->money}}</td>
                                        <td>{{@$user->jingyan}}</td>
                                        <td>{{@$user->ip_addr}}</td>
                                        <td>{{@$user->slave_money}}</td>
                                        <td>{{@$user->master_id}}</td>
                                        <td>{{@$user->created_at}}</td>
                                        <td>
                                        <a class="btn btn-sm btn-info updateuser" href="/welkin/mcy/user/update?user_id={{@$user->mcy_user_id}}">修改</a>
                                        <a class="btn btn-sm btn-primary updateuser" href="/welkin/mcy/orders?searchid={{@$user->mcy_user_id}}">查看购买记录</a>
                                        <button type="button" class="btn btn-sm btn-danger deleteuser" uname="{{@$user->username}}" uid="{{@$user->mcy_user_id}}" >删除</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$users->appends(['searchtext'=>$searchtext,'searchmobile'=>$searchmobile,'is_robot'=>$is_robot,'starttime'=>@$_GET['starttime'],'endtime'=>@$_GET['endtime']])->links()}}
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
            searchmobile = $("input[name=searchmobile]").val(),
            master_id = $("input[name=master_id]").val(),
            starttime = $("input[name=starttime]").val(),
            is_robot = $("#is_robot").val(),
            endtime = $("input[name=endtime]").val();
            location.href = '/welkin/mcy/users?searchtext='+ searchtext + '&starttime=' + starttime +'&searchmobile=' + searchmobile +'&master_id=' + master_id + '&is_robot=' + is_robot + '&endtime='+ endtime;
    });

    $('.deleteuser').on('click',function(){
        var uid = $(this).attr('uid'),
            name = $(this).attr('uname');
        parent.layer.confirm('确定删除名称为' + name + '的用户?',function(){
           $.ajax({
            url : '/api/welkin/mcy/user/delete',
              type : 'post',
              async : false,
              dataType : 'json',
              data : {
                _token : "{!! csrf_token() !!}",
                user_id : uid
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
              $(".uid"+data.user_id).hide();
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