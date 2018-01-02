<?php 
$color = array('success-element','warning-element','info-element','danger-element');
 ?>
@extends('todo.layout')
@section('title','TodoList,KillLazy!!!!!')
@section('my-css')
 <style type="text/css">   
 .btn {
    margin-left: 5px;
 }
 </style>
@endsection
@section('content')
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="col-sm-4">
                <div class="ibox">
                    <div class="ibox-content">
                        <h3 class="text-center">任务列表</h3>
                        <div class="input-group">
                            <input type="text" placeholder="添加新任务" name="content" class="input input-sm form-control content">
                            <span class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-white listadd"> <i class="fa fa-plus"></i> 添加</button>
                                </span>
                        </div>

                        <ul class="sortable-list connectList agile-list">
                            @foreach($ctodolists as $key => $todolist)
                            <li class="{{@$color[$key%4]}} lid{{@$todolist->todolist_id}}" >
                                {!! @$todolist->content !!}
                                <div class="agile-detail">
                                    <a class="pull-right btn btn-xs btn-danger listdelete "  lid="{{@$todolist->todolist_id}}" >删除</a>
                                    <a class="pull-right btn btn-xs btn-info listcompelete" status=1 lid="{{@$todolist->todolist_id}}" >完成</a>
                                    <a class="pull-right btn btn-xs btn-warning listupdate" lid="{{@$todolist->todolist_id}}" content="{{@$todolist->content}}">修改</a>
                                    <i class="fa fa-clock-o"></i> {{@$todolist->updated_at}}
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @if (count($atodolists) > 0)
            <div class="col-sm-4">
                <div class="ibox">
                    <div class="ibox-content">
                        <h3>已完成</h3>
                        <ul class="sortable-list connectList agile-list">
                         @foreach($atodolists as $todolist)
                            <li class="{{@$color[$key%4]}} lid{{@$todolist->todolist_id}} ">
                                {!! @$todolist->content !!}
                                <div class="agile-detail">
                                    <a class="pull-right btn btn-xs btn-danger listdelete "  lid="{{@$todolist->todolist_id}}" >删除</a>
                                    <a class="pull-right btn btn-xs btn-info listcompelete" status=0 lid="{{@$todolist->todolist_id}}" >复原</a>
                                    <!-- <a class="pull-right btn btn-xs btn-warning listupdate"  lid="{{@$todolist->todolist_id}}" >修改</a> -->
                                    <i class="fa fa-clock-o"></i> {{@$todolist->updated_at}}
                                </div>
                            </li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif
        </div>


    </div>

@endsection
@section('my-js')
     <script>
        $(document).ready(function(){$(".sortable-list").sortable({connectWith:".connectList"}).disableSelection()});
    </script>
    <script type="text/javascript">
        $(".listadd").on('click',function(){
            var content = $("input[name=content]").val();
            if (content == ''||undefined)
            {
                layer.msg('任务不能为空',{icon:2,time:2000});
                return false;
            }
            $.ajax({
                type : 'post',
                url  : '/api/wx/todolist/add',
                dataType : 'json',
                data : {
                    _token   : "{!! csrf_token() !!}",
                    content : $("input[name=content]").val()
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
                    window.location.href = location.href+'?time='+((new Date()).getTime());
                    //location.reload();
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

        $(".listupdate").on('click',function(){
          var content = $(this).attr('content');
          var lid = $(this).attr('lid');
          parent.layer.prompt({
                title: '修改任务',
                value : content,
                formType: 0 //prompt风格，支持0-2
            }, function(send_info){
            parent.layer.confirm('确认修改为' + send_info,{
              btn : ['确定','取消'],
              shade : false
            },function(){
              $.ajax({
                  type : 'post',
                  url  : '/api/wx/todolist/update',
                  dataType : 'json',
                  data : {
                      _token   : "{!! csrf_token() !!}",
                      content : send_info,
                      lid     : lid
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
                      window.location.href = location.href+'?time='+((new Date()).getTime());
//                      location.reload();
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
            },function(){
              parent.layer.msg('取消',{time:2000,shift: 6});
            });
          });
        });

        $('.listdelete').on('click',function(){
            var lid = $(this).attr('lid');
            parent.layer.confirm('确定删除?',function(){
            $.ajax({
                url : '/api/wx/todolist/delete',
                type : 'post',
                async : false,
                dataType : 'json',
                data : {
                    _token : "{!! csrf_token() !!}",
                    lid : lid
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
                  $(".lid"+data.lid).hide();
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

        $('.listcompelete').on('click',function(){
            var lid = $(this).attr('lid');
            var status = $(this).attr('status');
            parent.layer.confirm('确认修改任务状态?',function(){
            $.ajax({
                url : '/api/wx/todolist/updatestatus',
                type : 'post',
                async : false,
                dataType : 'json',
                data : {
                    _token : "{!! csrf_token() !!}",
                    lid : lid,
                    status : status
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
                  window.location.href = location.href+'?time='+((new Date()).getTime());
//                  location.reload();
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
