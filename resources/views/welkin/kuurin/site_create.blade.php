@extends('welkin.layout')
@section('title','新建站点信息')
@section('my-css')
<style>
.clearimg {
    position:relative;
}
</style>
@endsection
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                <h5>新增站点<small><a href="/welkin/kuurin/sites">返回上一页</a></small></h5>
                    <a href="javascript:;" class="refresh">刷新</a>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-refresh refresh"></i>
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="main-container">
                        <div class="padding-md">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="smart-widget widget-purple">
                                        <div class="smart-widget-inner">
                                            <div class="smart-widget-body">
                                                <form class="form-horizontal no-margin" id="site_create">
                                                    <div class="form-group">
                                                    <label class="col-lg-3 control-label">站点名称:</label>
                                                        <div class="col-lg-9">
                                                            <input name="site_name"  minlength="2" type="text" class="form-control input-sm" required="" value="{{@$site->site_name}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                    <label class="col-lg-3 control-label">站点头部统计代码:</label>
                                                        <div class="col-lg-9">
                                                            <textarea name="site_header" class="form-control">
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                    <label class="col-lg-3 control-label">站点脚本统计代码:</label>
                                                        <div class="col-lg-9">
                                                            <textarea name="site_footer" class="form-control">
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">站点联系电话:</label>
                                                        <div class="col-lg-9">
                                                            <input name="site_mobile"  minlength="2" type="text" class="form-control input-sm" required="" value="{{@$site->site_mobile}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">站点联系400电话:</label>
                                                        <div class="col-lg-9">
                                                            <input name="site_mobile400"  minlength="2" type="text" class="form-control input-sm" required="" value="{{@$site->site_mobile400}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">站点域名:</label>
                                                        <div class="col-lg-9">
                                                            <input name="site_host"  minlength="2" type="text" class="form-control input-sm" required="" value="{{@$site->site_host}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">站点地址:</label>
                                                        <div class="col-lg-9">
                                                            <input name="site_addr"  minlength="2" type="text" class="form-control input-sm" required="" value="{{@$site->site_addr}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">站点联系人:</label>
                                                        <div class="col-lg-9">
                                                            <input name="site_contact"  minlength="2" type="text" class="form-control input-sm" required="" value="{{@$site->site_contact}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">站点联系人电话:</label>
                                                        <div class="col-lg-9">
                                                            <input name="site_contact_mobile"  minlength="2" type="text" class="form-control input-sm" required="" value="{{@$site->site_contact_mobile}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">站点联系人QQ:</label>
                                                        <div class="col-lg-9">
                                                            <input name="site_contact_qq"  minlength="2" type="text" class="form-control input-sm" required="" value="{{@$site->site_contact_qq}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                    <label class="col-lg-3 control-label">站点联系人照片</label>
                                                        <div class="col-lg-9">
                                                            @for($i = 1 ; $i <= 1; $i++)
                                                            <img width="50px" class="site_contact_img" id="site_contact_img" src="{{ isset($site->site_bg)?$site->site_bg:'/images/plus.png'}}" onclick="return $('#usite_contact_img').click()">
                                                            <input type="file" id="usite_contact_img" name="welkin" style="display:none" accept="image" onchange="return uploadImageToServer('usite_contact_img','images', 'site_contact_img','{{csrf_token()}}')">
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">站点销售人:</label>
                                                        <div class="col-lg-9">
                                                            <input name="site_saller"  minlength="2" type="text" class="form-control input-sm" required="" value="{{@$site->site_saller}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">站点销售人电话:</label>
                                                        <div class="col-lg-9">
                                                            <input name="site_saller_mobile"  minlength="2" type="text" class="form-control input-sm" required="" value="{{@$site->site_saller_mobile}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">站点销售人QQ:</label>
                                                        <div class="col-lg-9">
                                                            <input name="site_saller_qq"  minlength="2" type="text" class="form-control input-sm" required="" value="{{@$site->site_saller_qq}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">站点销售人照片</label>
                                                        <div class="col-lg-9">
                                                            @for($i = 1 ; $i <= 1; $i++)
                                                            <img width="50px" class="site_saller_img" id="site_saller_img" src="{{ isset($site->site_bg)?$site->site_bg:'/images/plus.png'}}" onclick="return $('#usite_saller_img').click()">
                                                            <input type="file" id="usite_saller_img" name="welkin" style="display:none" accept="image" onchange="return uploadImageToServer('usite_saller_img','images', 'site_saller_img','{{csrf_token()}}')">
                                                            @endfor
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">站点logo：</label>
                                                        <div class="col-lg-9">
                                                            @for($i = 1 ; $i <= 1; $i++)
                                                            <img width="50px" class="usite_pics" id="site_logo" src="{{ isset($site->site_bg)?$site->site_bg:'/images/plus.png'}}" onclick="return $('#usite_logo').click()">
                                                            <input type="file" id="usite_logo" name="welkin" style="display:none" accept="image" onchange="return uploadImageToServer('usite_logo','images', 'site_logo','{{csrf_token()}}')">
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                    <label class="col-lg-3 control-label">站点手机logo：</label>
                                                        <div class="col-lg-9">
                                                            @for($i = 1 ; $i <= 1; $i++)
                                                            <img width="50px" class="usite_pics" id="site_m_logo" src="{{ isset($site->site_bg)?$site->site_bg:'/images/plus.png'}}" onclick="return $('#usite_m_logo').click()">
                                                            <input type="file" id="usite_m_logo" name="welkin" style="display:none" accept="image" onchange="return uploadImageToServer('usite_m_logo','images', 'site_m_logo','{{csrf_token()}}')">
                                                            @endfor
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                    <label class="col-lg-3 control-label">站点风格：</label>
                                                        <div class="col-lg-9">
                                                            <select name="site_style" id="site_style" class="site_style" width="100%">
                                                                <option @if (@$site->site_style == 0) selected="selected" @endif value="0">默认</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">站点手机风格：</label>
                                                        <div class="col-lg-9">
                                                            <select name="site_m_style" id="site_m_style" class="site_m_style" width="100%">
                                                                <option @if (@$site->site_m_style == 0) selected="selected" @endif value="0">默认</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                  
                                                    <div class="form-group">
                                                        <div class="col-sm-4 col-sm-offset-3">
                                                            <button type="button" class="btn btn-white btn-close-modal" data-dismiss="modal">取消</button>
                                                            <button type="button" class="btn btn-primary site_create" >提交</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div><!-- ./smart-widget-inner -->
                                    </div><!-- ./smart-widget -->
                                </div><!-- /.col-->
                            </div><!-- /.row -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div>
    @endsection
    @section('my-js')
    <script type="text/javascript" src="/js/upload.js"></script>
    <script src="/admin/js/plugins/layer/laydate/laydate.js"></script>
    <script src="/admin/js/plugins/peity/jquery.peity.min.js"></script>
    <script type="text/javascript">
        $(document).on('click','.clearimg',function(){
                    $(this).prev().prev('.uvote_pics').attr('src','/images/plus.png');
                });
        $(document).on('click','.site_create',function(){
            var data = $("#site_create").serialize();
            $.ajax({
                type : 'post',
                url  : '/api/welkin/kuurin/site/create',
                dataType : 'json',
                data : {
                    _token   : "{!! csrf_token() !!}",
                    data : data,
                    site_header : $(".site_header").val(),
                    site_footer : $(".site_footer").val(),
                    site_contact_img : ($("#site_contact_img").attr('src') == '/images/plus.png')?'':$("#site_contact_img").attr('src'),
                    site_saller_img : ($("#site_saller_img").attr('src') == '/images/plus.png')?'':$("#site_saller_img").attr('src'),
                    site_logo : ($("#site_logo").attr('src') == '/images/plus.png')?'':$("#site_logo").attr('src'),
                    site_m_logo : ($("#site_m_logo").attr('src') == '/images/plus.png')?'':$("#site_m_logo").attr('src'),
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
        })
    </script>
    @endsection
