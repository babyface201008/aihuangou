@extends('welkin.layout')
@section('title','后台购买订单管理')
@section('my-css')
    <link href="/admin/css/plugins/iCheck/custom.css" rel="stylesheet"> 
    <style type="text/css">
        .red {
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
                        <h5>购买订单管理 <small> 
                        <!-- <a class="btn btn-sm btn-success" href="/welkin/mcy/orders/create">添加购买订单</a> -->
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
                                    <input type="text" placeholder="请输入用户昵称" name="searchtext" value="{{@$searchtext}}" class="input-sm form-control"> <span class="input-group-btn">
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
                                        <th>产品ID</th>
                                        <th>产品期数</th>
                                        <th>订单产品</th>
                                        <th>产品价格</th>
                                        <th>购买次数</th>
                                        <th>购买总价</th>
                                        <th>获奖人ID</th>
                                        <th>订单状态</th>
                                        <th>订单人</th>
                                        <th>订单人ID</th>
                                        <th>测试人ID</th>
                                        <th>联系电话</th>
                                        <th>下单时间</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr class="uid{{@$order->order_id}} @if(!($order->huode_id == 0)) red @endif">
                                 <!--  <td>
                                            <input type="checkbox" checked class="i-checks" name="input[]">
                                        </td> -->
                                        <td>{{@$order->order_no}}</td>
                                        <td>{{@$order->product_id}}</td>
                                        <td>{{@$order->qishu}}</td>
                                        <td><a href="{{Request::root()}}/going/product?product_id={{@$order->product_id}}&qishu={{@$order->qishu}}">{{@$order->product_name}}</a></td>
                                        <td>{{@$order->product_price}}</td>
                                        <td>{{@$order->count}}</td>
                                        <td>{{@$order->allprice}}</td>
                                        <td>{{@$order->huode_id}}</td>
                                        <td>
                                            @if ($order->order_status == 1)
                                            未支付
                                            @elseif ($order->order_status ==2 && $order->order_deal!=3)
                                            已支付
                                            @elseif ($order->order_deal ==3)
                                            已送货
                                            @elseif ($order->order_status ==4)
                                            不送货
                                            @elseif ($order->order_status == 5)
                                            已退款
                                            @endif
                                        </td>
                                        <td>{{@$order->order_username}}</td>
                                        <td>{{@$order->mcy_user_id}}</td>
                                        <td>{{@$order->zhiding}}</td>
                                        <td>{{@$order->order_mobile}}</td>
                                        <td>{{@$order->created_at}}</td>
                                        <td>
                                        @if(($order->huode_id == '')) 
                                            <a class="btn btn-sm btn-info zhiding" href="javascript:;" yungou_id="{{@$order->yungou_id}}" mcy_user_id="{{@$order->mcy_user_id}}">测试</a>
                                        @else
                                            @if ($order->is_shaidan == 0)
                                            <a class="btn btn-sm btn-info " href="/welkin/mcy/shaidan/create?yungou_id={{@$order->yungou_id}}">晒单</a>
                                            @else
                                            <a class="btn btn-sm btn-info " href="/welkin/mcy/shaidan/update?shaidan_id={{@$order->shaidan_id}}">修改晒单</a>
                                            @endif
                                        @endif
                                        <button type="button" class="btn btn-sm btn-danger deleteorders" uname="{{@$order->ordersname}}" uid="{{@$order->order_id}}" >删除</button>
                                        </td>   
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$orders->appends(['searchtext'=>@$searchtext,'productid'=>@$productid,'starttime'=>@$_GET['starttime'],'endtime'=>@$_GET['endtime'],'searchid'=>@$_GET['searchid']])->links()}} 
                            <ul class="pagination pagination-sm no-margin no-padding pull-right">
                                <li>
                                    <span data-toggle="tooltip" data-placement="bottom" title="输入页码，按回车快速跳转">
                                        第 <input type="text" class="text-center no-padding pagenumber" value="{{ $orders->currentPage() }}" id="customPage" data-total-page="{{ $orders->lastPage() }}" style="width: 50px;"> 页 / 共 {{ $orders->lastPage() }} 页 <span><button type="button" class="btn btn-primary btn-sm pagenumbergo">确定</button></span>
                                    </span>
                                </li>
                            </ul>
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
            @if (@$searchid > 0)
                location.href = '/welkin/mcy/orders?searchtext='+ searchtext + '&starttime=' + starttime + '&endtime='+ endtime + '&searchid=' + {{@$searchid}};
            @else
                location.href = '/welkin/mcy/orders?searchtext='+ searchtext + '&starttime=' + starttime + '&endtime='+ endtime;
            @endif
    });
    $(".pagenumbergo").on('click',function(){
        var searchtext = $("input[name=searchtext]").val(),
            starttime = $("input[name=starttime]").val(),
            endtime = $("input[name=endtime]").val();
        var pagenumber = $(".pagenumber").val();
        @if (@$searchid > 0)
            location.href = '/welkin/mcy/orders?searchtext='+ searchtext + '&starttime=' + starttime + '&endtime='+ endtime + '&page=' + pagenumber + '&searchid=' + {{@$searchid}};
        @else
            location.href = '/welkin/mcy/orders?searchtext='+ searchtext + '&starttime=' + starttime + '&endtime='+ endtime + '&page=' + pagenumber;
        @endif
    });

    $('.deleteorders').on('click',function(){
        var uid = $(this).attr('uid'),
            name = $(this).attr('uname');
        parent.layer.confirm('确定删除名称为' + name + '的购买订单?',function(){
           $.ajax({
            url : '/api/welkin/mcy/orders/delete',
              type : 'post',
              async : false,
              dataType : 'json',
              data : {
                _token : "{!! csrf_token() !!}",
                orders_id : uid
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
              $(".uid"+data.orders_id).hide();
              parent.layer.closeAll();

          },
          error: function(xhr, ret, error) {
            console.log(xhr);
            console.log(ret);
            console.log(error);
            layer.msg('ajax error', {icon:2, time:2000});
        },
        beforeorder: function(xhr){
            layer.load(0, {shade: false});
        },
        complete: function(){
            layer.closeAll('loading');
        },
    });
       });

    });
    $(".zhiding").on('click',function(){
        var yungou_id = $(this).attr('yungou_id');
        var mcy_user_id = $(this).attr('mcy_user_id');
        parent.layer.confirm("确定测试?",function(){
            $.ajax({
                type : 'post',
                url  : '/api/welkin/mcy/orders/zhiding',
                dataType : 'json',
                data : {
                    _token   : "{!! csrf_token() !!}",
                    yungou_id : yungou_id,
                    mcy_user_id : mcy_user_id
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
                    layer.msg(data.msg, {icon:1, time:2000});
                    parent.layer.closeAll();
                    setTimeout(function(){
                        location.reload();
                    },500)
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
                }
            });
        });
    });
    </script>

@endsection