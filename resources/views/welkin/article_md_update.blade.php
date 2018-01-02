@extends('welkin.layout')
@section('title','添加文章')
@section('my-css')
    <link href="/admin/mdeditor/css/editormd.css" rel="stylesheet"> 
    <style>
        .editormd{
            width: 100% !important;
        }
    </style>
@endsection
@section('content')
 
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>添加文章(md版本) <small></small></h5>
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
                                                      <form class="form-horizontal no-margin" id="article_create">
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">文章标题</label>
                                                            <div class="col-lg-9">
                                                                <input type="text" class="form-control input-sm" value="{{@$article->title}}" placeholder="文章标题" datatype="*" name="article-title">
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->                              
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">文章分类</label>
                                                            <div class="col-lg-9">
                                                              @foreach(@$tags as $tag)
                                                                @if (isset($article->tags))
                                                                  @if (in_array($tag->tag_id,@$article->tags))
                                                                     <span class="label label-danger tag tag_select" tagid="{{$tag->tag_id}}">{{$tag->tag_name}}</span>
                                                                  @else
                                                                     <span class="label label-info tag" tagid="{{$tag->tag_id}}">{{$tag->tag_name}}</span>
                                                                  @endif
                                                                @endif
                                                              @endforeach                                                       
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->  
                                                          <div class="form-group">
                                                            <label class="control-label col-lg-3">文章歸屬</label>
                                                            <div class="col-lg-9">
                                                              @foreach(@$categorys as $category)
                                                                  @if (isset($article->categorys))
                                                                      @if (in_array($category->category_id,@$article->categorys))
                                                                         <span class="label label-danger category category_select" categoryid="{{$category->category_id}}">{{$category->name}}</span>
                                                                      @else
                                                                         <span class="label label-info category" categoryid="{{$category->category_id}}">{{$category->name}}</span>
                                                                      @endif
                                                                  @endif
                                                              @endforeach                                                         
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->  
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-3">文章內容</label>
                                                            <div class="col-lg-9">
                                                               <div id="editormd">
                                                                <textarea style="display:none;">{!! @$article->content !!}</textarea>
                                                            </div>
                                                            </div><!-- /.col -->
                                                        </div><!-- /form-group -->

                                                        <div class="text-right m-top-md">
                                                            <button type="button" class="btn btn-info " onclick="update_article()">Submit</button>
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
    <script src="/admin/mdeditor/editormd.js"></script>
    <script type="text/javascript">
        var mdEditor;
        $(function() {
            mdEditor = editormd("editormd", {
                width   : "90%",
                height  : 640,
                syncScrolling : "single",
                imageUpload       : true,
                imageFormats      : ["jpg", "jpeg", "gif", "png", "bmp","ico", "webp"],
                imageUploadURL    : "/api/welkin/markdown/upload/images",
                path    : "/admin/mdeditor/lib/"
            });
            });
        </script>

    <script>
        $(".tag").on('click',function(){
            if ($(this).hasClass('label-info')){
                $(this).removeClass('label-info');
                $(this).addClass('label-danger');
                $(this).addClass('tag_select');
            }else{
                $(this).removeClass('label-danger');
                $(this).removeClass('tag_select');
                $(this).addClass('label-info');
            }
        });
        $(".category").on('click',function(){
            if ($(this).hasClass('label-info')){
                $(this).removeClass('label-info');
                $(this).addClass('label-danger');
                $(this).addClass('category_select');
            }else{
                $(this).removeClass('label-danger');
                $(this).removeClass('category_select');
                $(this).addClass('label-info');
            }
        });
        function update_article()
        {
            var title = $("input[name=article-title]").val();
            var content = mdEditor.getMarkdown();
            if ( title == ''){
                alert('标题不能为空');
                return false;
            }else if (content == ''){
                alert('内容不能为空');
                return false;
            }else{}
            var arr = $(".tag_select"),article_tags = [],article_tags_name = [];
            for(var i = 0;i<arr.length;i++){
                article_tags.push($(arr[i]).attr("tagid"));
                article_tags_name.push($(arr[i]).text());
            }
            var arr1 = $(".category_select"),category_ids = [],category_ids_name = [];
            for(var i = 0;i<arr1.length;i++){
                category_ids.push($(arr1[i]).attr("categoryid"));
                category_ids_name.push($(arr1[i]).text());
            }

            $.ajax({
                type : 'post',
                url  : '/api/welkin/article/md/update',
                dataType : 'json',
                data : {
                    title    : title,
                    article_id : {{@$article->article_id}},
                    content  : content,
                    tag_ids : article_tags.toString(),
                    tag_names : article_tags_name.toString(),
                    category_ids : category_ids.toString(),
                    category_names : category_ids_name.toString(),
                    _token   : "{!! csrf_token() !!}",
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
                    setTimeout(function(){
                        location.href = '/welkin/article';
                    },1000);
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
        }
    </script>
@endsection