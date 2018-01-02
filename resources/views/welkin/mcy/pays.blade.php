@extends('welkin.layout')
@section('title','后台支付管理')
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
                        <h5>支付管理 <small> <a class="btn btn-sm btn-success" href="/welkin/mcy/payinfo/create">添加支付</a>
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
                                        <th>支付名称</th>
                                        <th>支付账号</th>
                                        <th>支付调用方法</th>
                                        <th>产品类型</th>
                                        <!-- <th>支付接口</th> -->
                                        <!-- <th>支付前台回调</th> -->
                                        <!-- <th>支付后台回调</th> -->
                                        <th>支付状态</th>
                                        <th>排序</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payinfos as $payinfo)
                                    <tr class="uid{{@$payinfo->payinfo_id}}">
                                 <!--  <td>
                                            <input type="checkbox" checked class="i-checks" name="input[]">
                                        </td> -->
                                        <td>{{@$payinfo->pay_name}}</td>
                                        <td>{{@$payinfo->pay_account}}</td>
                                        <td>{{@$payinfo->method}}</td>
                                        <td>{{@$payinfo->product_type}}</td>
                                        <td>
                                            @if ($payinfo->status == 0)
                                            启用
                                            @elseif ($payinfo->status ==1)
                                            不启用
                                            @endif
                                        </td>
                                        <td>
                                            {{@$payinfo->sort}}
                                        </td>
                                        <td>
                                        <a class="btn btn-sm btn-info updatepayinfo" href="/welkin/mcy/payinfo/update?payinfo_id={{@$payinfo->payinfo_id}}">修改</a>
                                        <button type="button" class="btn btn-sm btn-danger deletepayinfo" uname="{{@$payinfo->payinfoname}}" uid="{{@$payinfo->payinfo_id}}" >删除</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$payinfos->appends(['searchtext'=>$searchtext,'starttime'=>@$_GET['starttime'],'endtime'=>@$_GET['endtime']])->links()}}
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
            endtime = $("input[name=endtime]").val();
        location.href = '/welkin/mcy/payinfo?searchtext='+ searchtext + '&starttime=' + starttime + '&endtime='+ endtime;
    });

    $('.deletepayinfo').on('click',function(){
        var uid = $(this).attr('uid'),
            name = $(this).attr('uname');
        parent.layer.confirm('确定删除名称为' + name + '的支付?',function(){
           $.ajax({
            url : '/api/welkin/mcy/payinfo/delete',
              type : 'post',
              async : false,
              dataType : 'json',
              data : {
                _token : "{!! csrf_token() !!}",
                payinfo_id : uid
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
              $(".uid"+data.payinfo_id).hide();
              parent.layer.closeAll();

          },
          error: function(xhr, ret, error) {
            console.log(xhr);
            console.log(ret);
            console.log(error);
            layer.msg('ajax error', {icon:2, time:2000});
        },
        beforepayinfo: function(xhr){
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