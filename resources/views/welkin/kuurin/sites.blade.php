@extends('welkin.layout')
@section('title','站点管理')
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
                        <h5>站点管理 <small> <a class="btn btn-sm btn-success" href="/welkin/kuurin/site/create">添加站点</a>
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
                                        <th>站点名称</th>
                                        <th>站点域名</th>
                                        <th>站点地址</th>
                                        <th>站点400电话</th>
                                        <th>站点联系人</th>
                                        <th>站点联系人电话</th>
                                        <th>站点联系人QQ</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sites as $site)
                                    <tr class="siteid{{@$site->site_id}}">
                                 <!--  <td>
                                            <input type="checkbox" checked class="i-checks" name="input[]">
                                        </td> -->
                                        <td>{{@$site->site_name}}</td>
                                        <td>{{@$site->site_host}}</td>
                                        <td>{{@$site->site_mobile400}}</td>
                                        <td>{{@$site->site_contact}}</td>
                                        <td>{{@$site->site_contact_mobile}}</td>
                                        <td>{{@$site->site_contact_qq}}</td>
                                        <td>
                                        <a class="btn btn-sm btn-info updatesite" href="/welkin/kuurin/site/update?site_id={{@$site->site_id}}">修改信息</a>
                                        <button type="button" class="btn btn-sm btn-danger deletesite" uname="{{@$site->site_name}}" siteid="{{@$site->site_id}}" >删除</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$sites->appends(['searchtext'=>$searchtext,'starttime'=>@$_GET['starttime'],'endtime'=>@$_GET['endtime']])->links()}}
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
        location.href = '/welkin/kuurin/sites?searchtext='+ searchtext + '&starttime=' + starttime + '&endtime='+ endtime;
    });

    $('.deletesite').on('click',function(){
        var siteid = $(this).attr('siteid'),
            name = $(this).attr('uname');
        parent.layer.confirm('确定删除名称为' + name + '的站点?',function(){
           $.ajax({
            url : '/api/welkin/kuurin/site/delete',
              type : 'post',
              async : false,
              dataType : 'json',
              data : {
                _token : "{!! csrf_token() !!}",
                site_id : siteid
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
              $(".siteid"+data.site_id).hide();
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
    $('.linkapp').on('click',function(){
        var uname = $(this).attr('uname');
        var site_id = $(this).attr('siteid');
        parent.layer.prompt({
            title: '请输入需要添加的公众号的站内id',
                formType: 0 //prompt风格，支持0-2
              }, function(shopid){
            parent.layer.confirm('确认重置'+ uname + ' 的密码？' ,{
              btn : ['确定','取消'],
              shade : false
            },function(){
              $.ajax({
                  type : 'post',
                  url  : '/api/welkin/kuurin/site/linkapp',
                  dataType : 'json',
                  data : {
                      _token   : "{!! csrf_token() !!}",
                      site_id  : site_id,
                      shop_id  : shopid
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
    </script>

@endsection