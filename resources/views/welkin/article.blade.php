@extends('welkin.layout')
@section('title','文章列表')
@section('my-css')
    <link href="/admin/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
@endsection
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>文章列表 
                            <small>
                            <a href="/welkin/article/create">添加文章(百度版)</a>
                            <a href="/welkin/article/md/create">添加文章(md版)</a>
                            </small>
                        </h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-refresh refresh"></i>
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content table-responsive">

                        <table class="table table-striped table-bordered table-hover article_list">
                            <thead>
                                <tr>
                                    <th>文章ID</th>
                                    <th>文章标题</th>
                                    <th>文章标签</th>
                                    <th>文章归属</th>
                                    <th>创建时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(@$articles as $article)
                                <tr class="gradeX article{{@$article->article_id}}" articleid= "{{@$article->article_id}}">
                                    <td>{{@$article->article_id}}</td>
                                    <td>{{@$article->title}}</td>
                                    <td>{{@$article->tag_names}}</td>
                                    <td>{{@$article->category_names}}</td>
                                    <td>{{@$article->created_at}}</td>
                                    <td>
                                        @if ($article->type == 0)
                                        <a  class="btn btn-primary btn-xs" onclick="return modify_article('{{$article->article_id}}','{{$article->title}}')">修改文章</a>
                                        @else
                                        <a  class="btn btn-primary btn-xs" onclick="return modify_article1('{{$article->article_id}}','{{$article->title}}')">修改文章</a>
                                        @endif
                                        <a  class="btn btn-danger btn-xs" onclick="return delete_article('{{$article->article_id}}','{{$article->title}}')">删除文章</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('my-js')
     <script src="/admin/js/plugins/jeditable/jquery.jeditable.js"></script>
    <script>
        function modify_article(article_id,title)
        {
            parent.layer.confirm("确定修改文章标题为" + title + '的文章?',function(){
                parent.layer.closeAll();
                location.href = '/welkin/article/update?article_id=' + article_id;
            });
        }
        function modify_article1(article_id,title)
        {
            parent.layer.confirm("确定修改文章标题为" + title + '的文章?',function(){
                parent.layer.closeAll();
                location.href = '/welkin/article/md/update?article_id=' + article_id;
            });
        }

        function delete_article(article_id,title)
        {
            if (article_id == '') { alert("文章ID不能为空"); return false; }
            parent.layer.confirm('确定删除标题为 '+ title + ' 的文章?',function(){
                $.ajax({
                    url      : '/api/welkin/article/delete',
                    type     : 'post',
                    dataType : 'json',
                    data     : {
                        _token : "{!! csrf_token() !!}",
                        article_id : article_id,
                        title   : title,
                    },
                    success: function(data) {
                        console.log(data);
                        if(data == null) {
                            parent.layer.msg('服务端错误', {icon:2, time:2000});
                            return;
                        }
                        if(data.ret != 0) {
                            parent.layer.msg(data.msg, {icon:2, time:2000});
                            return;
                        }
                        $(".article" + article_id).hide();
                        parent.layer.msg('删除成功',{icon:1,time:1000});
                    },
                    error: function(xhr, ret, error) {
                        console.log(xhr);
                        console.log(ret);
                        console.log(error);
                        parent.layer.msg('网络出现异常', {icon:2, time:2000});
                    },
                    beforeSend: function(xhr){
                        layer.load(0, {shade: false});
                    },
                    complete: function(){
                        layer.closeAll('loading');
                    }
                });
            });
        }        

    </script>
@endsection