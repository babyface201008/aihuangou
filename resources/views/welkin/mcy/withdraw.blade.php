@extends('welkin.layout')
@section('title','后台提现管理')
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
                        <h5>充值管理 <small> 
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
                            <div class="col-sm-1 m-b-xs">
                                <button type="button" class="btn btn-sm btn-primary btnsearch"> 搜索</button> 
                            </div>
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <input type="text" placeholder="请输入提款人姓名" name="bank_username" value="{{@$bank_username}}" class="input-sm form-control"> <span class="input-group-btn">
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
                                        <th>提款单号</th>
                                        <th>提款ID</th>
                                        <th>提款金额</th>
                                        <th>提款人</th>
                                        <th>提款银行</th>
                                        <th>提款银行支行</th>
                                        <th>提款银行号</th>
                                        <th>手机号</th>
                                        <th>提款申请时间</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($withdraws as $withdraw)
                                    <tr class="uid{{@$withdraw->withdraw_id}}">
                                        <td>{{@$withdraw->withdraw_id}}</td>
                                        <td>{{@$withdraw->mcy_user_id}}</td>

                                        <td>{{@$withdraw->withdraw_price}}</td>
                                        <td>{{@$withdraw->bank_username}}</td>
                                        <td>{{@$withdraw->bank_name}}</td>
                                        <td>{{@$withdraw->bank_zhi_name}}</td>
                                        <td>{{@$withdraw->bank_id}}</td>
                                        <td>{{@$withdraw->bank_phone}}</td>
                                        <td>{{@$withdraw->created_at}}</td>
                                        <td>
                                        <!-- <a class="btn btn-sm btn-info updatewithdraw" href="/welkin/mcy/withdraw/update?withdraw_id={{@$withdraw->withdraw_id}}">修改提款信息</a> -->
                                        @if($withdraw->status == 0)
                                        <a class="btn btn-sm btn-info withdrawok" withdrawid="{{@$withdraw->withdraw_id}}" href="javascript:;">通过</a>
                                        @else
                                        <a class="btn btn-sm btn-danger withdrawbad" withdrawid="{{@$withdraw->withdraw_id}}" href="javascript:;">已通过</a>
                                        @endif
                                        <!-- <button type="button" class="btn btn-sm btn-danger withdrawbad"   withdrawid="{{@$withdraw->withdraw_id}}"  >不通过</button> -->
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$withdraws->appends(['searchtext'=>@$searchtext,'bank_username'=>@$bank_username,'starttime'=>@$_GET['starttime'],'endtime'=>@$_GET['endtime']])->links()}}
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
            bank_username = $("input[name=bank_username]").val(),
            endtime = $("input[name=endtime]").val();
        location.href = '/welkin/mcy/withdraws?searchtext='+ searchtext + '&starttime=' + starttime + '&bank_username=' + bank_username + '&endtime='+ endtime;
    });

    $('.withdrawok').on('click',function(){
        var withdraw_id = $(this).attr('withdrawid');
        parent.layer.confirm('确定通过该提款记录?',function(){
           $.ajax({
            url : '/api/welkin/mcy/withdraw/ok',
              type : 'post',
              async : false,
              dataType : 'json',
              data : {
                _token : "{!! csrf_token() !!}",
                withdraw_id : withdraw_id
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
               $(".withdraw_id"+data.withdraw_id).hide();
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