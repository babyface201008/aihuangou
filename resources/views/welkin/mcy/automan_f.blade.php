@extends('welkin.layout')
@section('title',"测试页面--$category->name")
@section('my-css')
    <link href="/admin/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet"> 
    <style type="text/css">
    .label {display: inline-block;margin: 5px;cursor: pointer;}
    .label:hover {background: #FD8894;}
    .area_category_select:hover {background: #ed5565;}
    </style>
@endsection
@section('content')
    <div class="wrapper wrapper-content animated automan_content">

    </div>
@endsection
@section('my-js')
<script src="/js/mcy/upload.js"></script>
<script type="text/javascript">
    $(".btn-automan-test").on('click',function(){
        location = '/welkin/mcy/automan/run';
    });
    var type = 1;
    function welkin (){
        console.log('test');
        var data = $("#automan_create").serialize();
        if (type == 1) {}else{ return false;}
        type = 2;
        $.ajax({
            type : 'get',
            url  : '/welkin/mcy/automan/run?type={{@$type}}&category_id={{@$category_id}}&go_type={{@$go_type}}&is_auto={{@$is_auto}}&auto_s_count={{@$auto_s_count}}&auto_e_count={{@$auto_e_count}}&test_time={{@$test_time}}&center_time={{@$center_time}}',
            dataType : 'json',
            data : {
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
                type = 1;
                // $(".automan_content").appendTo(data.data);
                // setTimeout(function(){
                //      welkin();
                // },{{@$test_time * 1000}});
                $($.parseHTML(data.data, document, true)).appendTo(".automan_content");  
                // layer.msg(data.msg, {icon:1, time:2000});
                // location.href = '/welkin/mcy/automans';
            },
            error: function(xhr, ret, error) {
                type = 1;
                // console.log(xhr);
                // console.log(ret);
                // console.log(error);
                // layer.msg('服务器出错', {icon:2, time:2000});
                //  setTimeout(function(){
                //      welkin();
                // },{{@$test_time * 1000}});
            },
            beforeSend: function(xhr){
                // layer.load(0, {shade: false});
            },
            complete: function(){
                // layer.closeAll('loading');
            }
        });
    };
    setInterval(function(){
        welkin();
    },{{@$test_time * 1000}})
    $(".chosen-select").chosen({disable_search_threshold: 10});
</script>
@endsection