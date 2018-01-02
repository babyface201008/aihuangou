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
                        <h5>超级代理商管理 -> @if($mcy_user){{$mcy_user->username}}@endif<small>
                        <!-- <a class="btn btn-sm btn-success" href="/welkin/mcy/withdraw/create">添加充值</a> -->
                        </small></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-refresh refresh"></i>
                            </a>
                        </div>
                    </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>邀请用户</th>
                                        <th>邀请时间</th>
                                        <th>邀请编号</th>
                                        <th>消费状态</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($inviteUser)
                                    @foreach($inviteUser as $supperclient)
                                    <tr class="uid">
                                        <td>{{@$supperclient->username}}</td>
                                        <td>{{@$supperclient->created_at->format('Y.m.d H:i')}}</td>
                                        <td>{{@$supperclient->mcy_user_id}}</td>
                                        <td>{{@$supperclient->is_chongzhi}}</td>

                                    </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            {{ $inviteUser->links() }}
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