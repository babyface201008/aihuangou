@extends('welkin.layout')
@section('title','后台超级代理商管理')
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
                        <h5>超级代理商管理 <small>
                        <!-- <a class="btn btn-sm btn-success" href="/welkin/mcy/withdraw/create">添加充值</a> -->
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

                            <div class="col-sm-2">
                                <div class="input-group">
                                    <input type="text" placeholder="请输入申请人姓名" name="real_name" value="{{@$real_name}}" class="input-sm form-control">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" placeholder="请输入手机号" name="searchtext" value="{{@$searchtext}}" class="input-sm form-control">
                                </div>
                            </div>
                            <div class="col-sm-1 m-b-xs">
                                <button type="button" class="btn btn-sm btn-primary btnsearch"> 搜索</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>会员</th>
                                        <th>姓名</th>
                                        <th>手机号</th>

                                        <th>创建时间</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($suppermasters as $suppermaster)
                                    <tr class="uid{{@$suppermaster->super_id}}">
                                        <td>{{@$suppermaster->super_id}}</td>
                                        <td>{{@$suppermaster->mcy_user_id}}</td>
                                        <td>{{@$suppermaster->real_name}}</td>

                                        <td>{{@$suppermaster->phone}}</td>
                                        <td>{{@$suppermaster->created_at}}</td>
                                        <td>
                                        <!-- <a class="btn btn-sm btn-info updatewithdraw" href="/welkin/mcy/withdraw/update?withdraw_id={{@$withdraw->withdraw_id}}">修改提款信息</a> -->
                                        @if($suppermaster->status == 1)
                                                <a class="btn btn-sm btn-info withdrawok" superid="{{@$suppermaster->super_id}}" href="javascript:;">通过</a>
                                                <button type="button" class="btn btn-sm btn-danger withdrawbad withdrawno"   superid="{{@$suppermaster->super_id}}"  >不通过</button>
                                        @elseif($suppermaster->status == 2)
                                        <a class="btn btn-sm btn-success withdrawbad" superid="{{@$suppermaster->super_id}}" href="javascript:;">已通过</a>
                                                <a class="btn btn-sm  btn-link showQRCode"
                                                href="{{Request::root()}}/super/master/my_code/{{$suppermaster->mcy_user_id}}" title="" target="_blank">点击查看二维码</a>

                                                <a class="btn btn-sm btn-link"  href="{{Request::root()}}/welkin/mcy/supper/master/client/{{$suppermaster->mcy_user_id}}">查看推广客户</a>
                                        @elseif($suppermaster->status == 3)
                                                <a class="btn btn-sm btn-danger withdrawbad" superid="{{@$suppermaster->super_id}}" href="javascript:;">不通过</a>
                                        @elseif($suppermaster->status == 4)
                                                <a class="btn btn-sm btn-warning withdrawbad" superid="{{@$suppermaster->super_id}}" href="javascript:;">取消资格</a>
                                        @endif

                                        </td>


                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
           {{$suppermasters->appends(['searchtext'=>@$searchtext,'real_name'=>@real_name,'starttime'=>@$_GET['starttime'],'endtime'=>@$_GET['endtime']])->links()}}
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
            real_name = $("input[name=real_name]").val(),
            endtime = $("input[name=endtime]").val();
        location.href = '/welkin/mcy/supper/master?searchtext='+ searchtext + '&starttime=' + starttime + '&real_name=' + real_name + '&endtime='+ endtime;
    });


    //审核通过
    $('.withdrawok').on('click',function(){
        var super_id = $(this).attr('superid');
        parent.layer.confirm('确定通过该申请记录?',function(){
           $.ajax({
            url : '/api/welkin/mcy/supper/master/ok',
              type : 'post',
              async : false,
              dataType : 'json',
              data : {
                _token : "{!! csrf_token() !!}",
                  super_id : super_id
            },
            success: function(data) {

                if(data == null) {
                  layer.msg('服务端错误', {icon:2, time:2000});
                  return;
              }
              if(data.ret != 0) {
                  layer.msg(data.msg, {icon:2, time:2000});
                  return;
              }
              layer.msg(data.msg,{icon:1,time:2000});
               $(".super_id"+data.super_id).hide();
               parent.layer.closeAll();
              location.reload();
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

        //审核不通过
        $('.withdrawno').on('click',function(){
            var super_id = $(this).attr('superid');
            parent.layer.confirm('是否不给予通过该申请记录?',function(){
                $.ajax({
                    url : '/api/welkin/mcy/supper/master/no',
                    type : 'post',
                    async : false,
                    dataType : 'json',
                    data : {
                        _token : "{!! csrf_token() !!}",
                        super_id : super_id
                    },
                    success: function(data) {

                        if(data == null) {
                            layer.msg('服务端错误', {icon:2, time:2000});
                            return;
                        }
                        if(data.ret != 0) {
                            layer.msg(data.msg, {icon:2, time:2000});
                            return;
                        }
                        layer.msg(data.msg,{icon:1,time:2000});
                        $(".super_id"+data.super_id).hide();
                        parent.layer.closeAll();
                        location.reload();
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