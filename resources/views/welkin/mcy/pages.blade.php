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
                        <h5>用户管理 <small> <a class="btn btn-sm btn-success" href="/welkin/mcy/page/create">添加用户</a>
                        </small> /共计 ：{{@$pages->total()}} 用户</h5>
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
                            <div class="col-sm-1 m-b-xs">
                                <button type="button" class="btn btn-sm btn-primary btnsearch"> 搜索</button> 
                            </div>
                            <div class="col-sm-2">
                                <select name="is_robot" id="is_robot" data-placeholder="选择用户类型.." class="chosen-select" style="width:120px;">
                                    <option @if(@$is_robot == 0) selected="selected" @endif value="0" hassubinfo="true">0</option>
                                    <option @if(@$is_robot == 1) selected="selected" @endif value="1" hassubinfo="true">1</option>
                                </select>
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
                                        <th>名称</th>
                                        <th>手机</th>
                                        <th>邮箱</th>
                                        <th>金币</th>
                                        <th>经验值</th>
                                        <th>0/1</th>
                                        <th>登录日期</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pages as $page)
                                    <tr class="uid{{@$page->mcy_page_id}}">
                                 <!--  <td>
                                            <input type="checkbox" checked class="i-checks" name="input[]">
                                        </td> -->
                                        <td>{{@$page->pagename}}</td>
                                        <td>{{@$page->mobile}}</td>
                                        <td>{{@$page->email}}</td>
                                        <td>{{@$page->money}}</td>
                                        <td>{{@$page->jingyan}}</td>
                                        <td>{{@$page->is_robot}}</td>
                                        <td>{{@$page->updated_at}}</td>
                                        <td>
                                        <a class="btn btn-sm btn-info updatepage" href="/welkin/mcy/page/update?page_id={{@$page->mcy_page_id}}">修改</a>
                                        <button type="button" class="btn btn-sm btn-danger deletepage" uname="{{@$page->pagename}}" uid="{{@$page->mcy_page_id}}" >删除</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$pages->appends(['searchtext'=>$searchtext,'is_robot'=>$is_robot,'starttime'=>@$starttime,'endtime'=>@$endtime])->links()}}
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
            is_robot = $("#is_robot").val(),
            endtime = $("input[name=endtime]").val();
        location.href = '/welkin/mcy/pages?searchtext='+ searchtext + '&starttime=' + starttime + '&is_robot=' + is_robot + '&endtime='+ endtime;
    });

    $('.deletepage').on('click',function(){
        var uid = $(this).attr('uid'),
            name = $(this).attr('uname');
        parent.layer.confirm('确定删除名称为' + name + '的用户?',function(){
           $.ajax({
            url : '/api/welkin/mcy/page/delete',
              type : 'post',
              async : false,
              dataType : 'json',
              data : {
                _token : "{!! csrf_token() !!}",
                page_id : uid
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
              $(".uid"+data.page_id).hide();
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