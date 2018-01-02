@extends('welkin.layout')
@section('title','后台晒单管理')
@section('my-css')
    <link href="/admin/css/plugins/iCheck/custom.css" rel="stylesheet"> 
    <style type="text/css">
        .red{
            color: red;
        }
    </style>
@endsection
@section('content')
 
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>晒单管理 <small> 
                        <a class="btn btn-sm btn-success" href="/welkin/mcy/shaidan/create">添加晒单</a>
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
                            <div class="col-sm-1 m-b-xs">
                                <button type="button" class="btn btn-sm btn-primary btnsearch"> 搜索</button> 
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>晒单号</th>
                                        <th>晒单人</th>
                                        <th>晒单内容</th>
                                        <th>晒单照片</th>
                                        <th>晒单时间</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($shaidans as $shaidan)
                                    <tr class="uid{{@$shaidan->shaidan_id}} @if ($shaidan->status == 1) red @endif">
                                        <td>{{@$shaidan->shaidan_id}}</td>
                                        <td>{{@$shaidan->username}}</td>
                                        <td>{{@$shaidan->shaidan_content}}</td>
                                        <td>
                                            <img src="{{@$shaidan->shaidan_img}}" width="150px;">
                                        </td>
                                        <td>{{@$shaidan->created_at}}</td>
                                        <td>
                                        <a class="btn btn-sm btn-info updatestatus" uname="{{@$shaidan->shaidanname}}" uid="{{@$shaidan->shaidan_id}}" mid="{{@$shaidan->mcy_user_id}}" status="{{@$shaidan->status}}">审核</a>
                                        <a class="btn btn-sm btn-info updateshaidan" href="/welkin/mcy/shaidan/update?shaidan_id={{@$shaidan->shaidan_id}}">修改</a>
                                        <button type="button" class="btn btn-sm btn-danger deleteshaidan" uname="{{@$shaidan->shaidanname}}" uid="{{@$shaidan->shaidan_id}}" >删除</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$shaidans->appends(['starttime'=>@$_GET['starttime'],'endtime'=>@$_GET['endtime']])->links()}}
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
            order_no = $("input[name=order_no]").val(),
            endtime = $("input[name=endtime]").val();
        location.href = '/welkin/mcy/shaidans?searchtext='+ searchtext + '&starttime=' + starttime + '&order_no=' + order_no + '&endtime='+ endtime;
    });

    $('.deleteshaidan').on('click',function(){
        var uid = $(this).attr('uid'),
            name = $(this).attr('uname');
        parent.layer.confirm('确定删除名称为' + name + '的晒单?',function(){
           $.ajax({
            url : '/api/welkin/mcy/shaidan/delete',
              type : 'post',
              async : false,
              dataType : 'json',
              data : {
                _token : "{!! csrf_token() !!}",
                shaidan_id : uid
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
              $(".uid"+data.shaidan_id).hide();
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
$('.updatestatus').on('click',function(){
        var uid = $(this).attr('uid'),
            status = $(this).attr('status'),
            mid = $(this).attr('mid'),
            name = $(this).attr('uname');
        var _this = $(this);
        parent.layer.confirm('确定审核名称为' + name + '的晒单?',function(){
           $.ajax({
            url : '/api/welkin/mcy/shaidan/update/status',
              type : 'post',
              async : false,
              dataType : 'json',
              data : {
                _token : "{!! csrf_token() !!}",
                shaidan_id : uid,
                mcy_user_id : mid,
                status : status,
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
              // $(".uid"+data.shaidan_id).hide();
              console.log(data.obj.status);
              if (data.obj.status == 0){
                  $(".uid"+data.obj.shaidan_id).removeClass('red');
                  _this.attr('status',data.obj.status);
              }else{
                  $(".uid"+data.obj.shaidan_id).addClass('red');
                  _this.attr('status',data.obj.status);
              }
              setTimeout(function(){
                  parent.layer.closeAll();
              },400);
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