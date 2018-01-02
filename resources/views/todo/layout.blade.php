<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>叶云梦天| @yield('title')</title>

    <meta name="keywords" content="任务清单,todoList,个人任务,干掉懒惰！">
    <meta name="description" content="任务清单,todoList,个人任务,干掉懒惰！">
    <link rel="shortcut icon" href="/favicon.ico">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/animate.min.css" rel="stylesheet">
    <link href="/css/style.min.css" rel="stylesheet">
    @yield('my-css')
</head>

<body class="fixed-sidebar full-height-layout gray-bg" >
  @yield('content')

</body>
    <script src="/js/libs/jquery-2.2.3.min.js"></script>
    <script src="/js/libs/jquery-ui-1.10.4.min.js"></script>
    <script src="/js/libs/jquery-ui.custom.min.js"></script>
    <script src="/js/libs/bootstrap.min.js"></script>
    <script src="/js/libs/layer/layer.js"></script>
    <script src="/js/libs/pace/pace.min.js"></script>
    

    @yield('my-js')


</html>
