<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>@yield('title')</title>
    <!--[if lt IE 9]>
        <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <link rel="shortcut icon" href="/favicon.ico">
    <link href="/admin/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/admin/css/animate.min.css" rel="stylesheet">
    <link href="/admin/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/admin/css/plugins/summernote/summernote.css" rel="stylesheet">
    <link href="/admin/css/plugins/summernote/summernote-bs3.css" rel="stylesheet">
    <link href="/admin/css/kuurin.css" rel="stylesheet">
    <link href="/admin/css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="/admin/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    @yield('my-css')
</head>

<body class="fixed-sidebar full-height-layout gray-bg" >
  @yield('content')

</body>
    <script src="/admin/js/jquery.min.js?v=2.1.4"></script>
    <script src="/admin/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/admin/js/plugins/layer/layer.js"></script>
    <script src="/admin/js/plugins/pace/pace.min.js"></script>
    <script src="/admin/js/hplus.min.js?v=4.1.0"></script>
    <script src="/admin/js/sha1.js"></script>
    <script src="/admin/js/plugins/chosen/chosen.jquery.js"></script>
    <script type="text/javascript" src="/admin/js/contabs.min.js"></script>
    <script src="/admin/js/jquery-ui-1.10.4.min.js"></script>
    <script src="/admin/js/plugins/beautifyhtml/beautifyhtml.js"></script>
    <script src="/admin/js/plugins/iCheck/icheck.min.js"></script>
    <script src="/admin/js/welkin.js"></script>
    @yield('my-js')
    <script type="text/javascript">
        $('.refresh').on('click',function(){
            location.reload();
        });
    </script>

</html>
