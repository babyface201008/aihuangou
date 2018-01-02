@extends('welkin.layout')
@section('title','站点配置')
@section('my-css')
    <link href="/admin/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet"> 

    <style type="text/css">
    .label {display: inline-block;margin: 5px;cursor: pointer;}
    .label:hover {background: #FD8894;}
    .area_category_select:hover {background: #ed5565;}
    </style>
@endsection
@section('content')
 
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>站点配置<small></h5>
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
                                                    <form class="form-horizontal no-margin" id="siteinfo_update">
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">站点名称</label>
                                                            <div class="col-lg-9">
                                                            <input type="text" class="form-control input-sm" placeholder="站点名称" datatype="*" value="{{@$siteinfo->site_name}}" name="site_name"  >
                                                            <input type="hidden"  value="{{@$siteinfo->site_id}}" name="site_id"  >
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">滚动公告</label>
                                                            <div class="col-lg-9">
                                                            <input type="text" class="form-control input-sm" placeholder="滚动公告" datatype="*" value="{{@$siteinfo->site_ad}}" name="site_ad"  >
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->
                                                   
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">站点域名</label>
                                                            <div class="col-lg-9">
                                                            <input type="text" class="form-control input-sm" placeholder="host" datatype="*" value="{{@$siteinfo->host}}" name="host"  >
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">站点统计码</label>
                                                            <div class="col-lg-9">
                                                            <input type="text" class="form-control input-sm" placeholder="站点统计码" datatype="*" value="{{@$siteinfo->site_header}}" name="site_header"  >
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->

                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">站点脚本码</label>
                                                            <div class="col-lg-9">
                                                            <input type="text" class="form-control input-sm" placeholder="站点脚本码" datatype="*" value="{{@$siteinfo->site_footer}}" name="site_footer"  >
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">站点备案号</label>
                                                            <div class="col-lg-9">
                                                            <input type="text" class="form-control input-sm" placeholder="站点备案号" datatype="*" value="{{@$siteinfo->site_icp}}" name="site_icp"  >
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">站点地址</label>
                                                            <div class="col-lg-9">
                                                            <input type="text" class="form-control input-sm" placeholder="站点地址" datatype="*" value="{{@$siteinfo->site_addr}}" name="site_addr"  >
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">站点联系人</label>
                                                            <div class="col-lg-9">
                                                            <input type="text" class="form-control input-sm" placeholder="站点联系人" datatype="*" value="{{@$siteinfo->site_contact}}" name="site_contact"  >
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->
                                                       <div class="form-group">
                                                            <label class="control-label col-lg-3">站点手机</label>
                                                            <div class="col-lg-9">
                                                            <input type="text" class="form-control input-sm" placeholder="站点手机" datatype="*" value="{{@$siteinfo->site_mobile}}" name="site_mobile"  >
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">站点微信</label>
                                                            <div class="col-lg-9">
                                                                <input type="text" class="form-control input-sm" placeholder="站点微信" datatype="*" value="{{@$siteinfo->site_wx}}" name="site_wx"  >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->
                                                       <div class="form-group">
                                                            <label class="control-label col-lg-3">客服电话</label>
                                                            <div class="col-lg-9">
                                                            <input type="text" class="form-control input-sm" placeholder="客服电话" datatype="*" value="{{@$siteinfo->site_400}}" name="site_400"  >
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->
                                                       <div class="form-group">
                                                            <label class="control-label col-lg-3">客服QQ</label>
                                                            <div class="col-lg-9">
                                                            <input type="text" class="form-control input-sm" placeholder="客服QQ" datatype="*" value="{{@$siteinfo->site_qq}}" name="site_qq"  >
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="col-lg-3 control-label">客服微信：</label>
                                                            <div class="col-lg-8">
                                                                <img width="50px" class="upload_pic" id="service_wexin" src="{{ !empty($siteinfo->service_wexin)?$siteinfo->service_wexin:'/images/plus.png'}}" onclick="return $('#service_wexin_img').click()">
                                                                <input type="file" id="service_wexin_img" name="welkin" style="display:none" accept="image" onchange="return uploadImageToServer('service_wexin_img','images', 'service_wexin','{{csrf_token()}}')">
                                                            </div>
                                                        </div>

                                                       {{-- <div class="form-group">
                                                            <label class="control-label col-lg-3">佣金比例(%)</label>
                                                            <div class="col-lg-9">
                                                            <input type="number" class="form-control input-sm" placeholder="佣金比例" datatype="*" value="{{@$siteinfo->rate_yongjin}}" name="rate_yongjin"  >
                                                           </div><!-- /.col -->
                                                       </div><!-- /form-group -->--}}
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">1福分等于多少(元)</label>
                                                            <div class="col-lg-9">
                                                                <input type="number" class="form-control input-sm" placeholder="1福分等于多少(元)" datatype="*" value="{{@$siteinfo->score_money}}" name="score_money"  >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">兑换回扣比例(%)</label>
                                                            <div class="col-lg-9">
                                                                <input type="number" class="form-control input-sm" placeholder="兑换回扣" datatype="*" value="{{@$siteinfo->rage_duihuan}}" name="rage_duihuan"  >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">兑换上一级佣金比例(%)</label>
                                                            <div class="col-lg-9">
                                                                <input type="number" class="form-control input-sm" placeholder="兑换上一级佣金比例" datatype="*" value="{{@$siteinfo->rage_duihuan_pid}}" name="rage_duihuan_pid"  >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">充值代理商回扣(%)</label>
                                                            <div class="col-lg-9">
                                                                <input type="number" class="form-control input-sm" placeholder="兑换回扣" datatype="*" value="{{@$siteinfo->rage_chongzhi_master}}" name="rage_chongzhi_master"  >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">购买代理商回扣(%)</label>
                                                            <div class="col-lg-9">
                                                                <input type="number" class="form-control input-sm" placeholder="兑换上一级佣金比例" datatype="*" value="{{@$siteinfo->rage_buy_master}}" name="rage_buy_master"  >
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->
                                                       <div class="form-group">
                                                            <label class="col-lg-3 control-label">站点logo：</label>
                                                            <div class="col-lg-8">
                                                            <img width="50px" class="upload_pic" id="site_pc_logo" src="{{ !empty($siteinfo->site_pc_logo)?$siteinfo->site_pc_logo:'/images/plus.png'}}" onclick="return $('#plogoimg').click()">
                                                            <input type="file" id="plogoimg" name="welkin" style="display:none" accept="image" onchange="return uploadImageToServer('plogoimg','images', 'site_pc_logo','{{csrf_token()}}')">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-lg-3 control-label">站点手机logo：</label>
                                                            <div class="col-lg-8">
                                                            <img width="50px" class="upload_pic" id="site_m_logo" src="{{ !empty($siteinfo->site_m_logo)?$siteinfo->site_m_logo:'/images/plus.png'}}" onclick="return $('#mlogoimg').click()">
                                                            <input type="file" id="mlogoimg" name="welkin" style="display:none" accept="image" onchange="return uploadImageToServer('mlogoimg','images', 'site_m_logo','{{csrf_token()}}')">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-lg-3 control-label">站点小图标:</label>
                                                            <div class="col-lg-8">
                                                            <img width="50px" class="upload_pic" id="site_favicon" src="{{ !empty($siteinfo->site_favicon)?$siteinfo->site_favicon:'/images/plus.png'}}" onclick="return $('#faviconimg').click()">
                                                            <input type="file" id="faviconimg" name="welkin" style="display:none" accept="image" onchange="return uploadImageToServer('faviconimg','images', 'site_favicon','{{csrf_token()}}')">
                                                            </div>
                                                        </div>
                                                        <div class="text-right m-top-md">
                                                            <button type="button" class="btn btn-info btn-siteinfo-update">修改</button>
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
@endsection
@section('my-js')
<script type="text/javascript">
    $(".btn-siteinfo-update").on('click',function(){
        var data = $("#siteinfo_update").serialize();
        $.ajax({
            type : 'post',
            url  : '/api/welkin/mcy/siteinfo/update',
            dataType : 'json',
            data : {
                _token   : "{!! csrf_token() !!}",
                site_favicon : ($("#site_favicon").attr('src') == '/images/plus.png')?'':$("#site_favicon").attr('src'),
                site_m_logo : ($("#site_m_logo").attr('src') == '/images/plus.png')?'':$("#site_m_logo").attr('src'),
                site_pc_logo : ($("#site_pc_logo").attr('src') == '/images/plus.png')?'':$("#site_pc_logo").attr('src'),
                service_wexin : ($("#service_wexin").attr('src') == '/images/plus.png')?'':$("#service_wexin").attr('src'),
                data : data,
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
                layer.msg(data.msg, {icon:1, time:2000});
                // location.href = '/shop/wx/shops';
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
            }
        });
    });
    $(".chosen-select").chosen({disable_search_threshold: 10});
</script>
<script src="/js/mcy/upload.js"></script>
@endsection