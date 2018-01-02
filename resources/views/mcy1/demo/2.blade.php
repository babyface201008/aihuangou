

<!DOCTYPE HTML>
<html style="padding-bottom: 54px;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">

    <title>手机端页面滑动效果</title>
    <meta name="description" content="手机端页面滑动效果，请在手机上查看效果，或在浏览器中模拟手机端查看，直接电脑端浏览器无法查看效果。" /> 
    <meta name="keywords" content="手机向上向下滑动,滑动,触摸上下滑动,移动端上下滑动,jquery插件,jquery" />
    <link rel="Shortcut icon" href="http://www.jq22.com/favicon.ico" />
    <link href="/demo/css/demo.css" rel="stylesheet" media="all" />
    <!--[if IE]>
			
			<style type="text/css">			
				li.purchase a {
					padding-top: 5px;
					background-position: 0px -4px;
				}
				
				li.remove_frame a {
					padding-top: 5px;
					background-position: 0px -3px;
				}						
			</style>
			
		<![endif]-->
    <script type="text/javascript">
        var txt = "http://www.jq22.com/demo/jquery-sj-150114225713";
        window.g1 = txt.substr(0, 3);
        window.g2 = txt.substr(0, 19);
    </script>
    <script src="/demo/js/pace.min.js" charset="gbk"></script>
    <link href="/demo/css/pace-theme-barber-shop.css" rel="stylesheet" />
    <script src="/demo/js/jquery.js"></script>
    <script type="text/javascript">

        var theme_list_open = false;

        $(document).ready(function () {
            function fixHeight() {
                var headerHeight = $("#switcher").height();
                $("#iframe").attr("height", $(window).height()-54+ "px");
            }
            $(window).resize(function () {
                fixHeight();
            }).resize();

            $('.icon-monitor').addClass('active');

            $(".icon-mobile-3").click(function () {
                $("#by").css("overflow-y", "auto");
                $('#iframe-wrap').removeClass().addClass('mobile-width-3');
                $('.icon-tablet,.icon-mobile-1,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
                $(this).addClass('active');
                return false;
            });

            $(".icon-mobile-2").click(function () {
                $("#by").css("overflow-y", "auto");
                $('#iframe-wrap').removeClass().addClass('mobile-width-2');
                $('.icon-tablet,.icon-mobile-1,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
                $(this).addClass('active');
                return false;
            });

            $(".icon-mobile-1").click(function () {
                $("#by").css("overflow-y", "auto");
                $('#iframe-wrap').removeClass().addClass('mobile-width');
                $('.icon-tablet,.icon-mobile,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
                $(this).addClass('active');
                return false;
            });

            $(".icon-tablet").click(function () {
                $("#by").css("overflow-y", "auto");
                $('#iframe-wrap').removeClass().addClass('tablet-width');
                $('.icon-tablet,.icon-mobile-1,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
                $(this).addClass('active');
                return false;
            });

            $(".icon-monitor").click(function () {
                $("#by").css("overflow-y", "hidden");
                $('#iframe-wrap').removeClass().addClass('full-width');
                $('.icon-tablet,.icon-mobile-1,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
                $(this).addClass('active');
                return false;
            });
        });
    </script>
    <script type="text/javascript">
        function Responsive($a) {
            if ($a == true) $("#Device").css("opacity", "100");
            if ($a == false) $("#Device").css("opacity", "0");
            $('#iframe-wrap').removeClass().addClass('full-width');
            $('.icon-tablet,.icon-mobile-1,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
            $(this).addClass('active');
            return false;
        };
    </script>
</head>
<body id="by" style="overflow-y: hidden" >
    <div id="switcher">
        <div class="center">
            <ul>
                <div id="Device">
                    <li class="device-monitor"><a href="javascript:">
                        <div class="icon-monitor">
                        </div>
                    </a></li>
                    <li class="device-mobile"><a href="javascript:">
                        <div class="icon-tablet">
                        </div>
                    </a></li>
                    <li class="device-mobile"><a href="javascript:">
                        <div class="icon-mobile-1">
                        </div>
                    </a></li>
                    <li class="device-mobile-2"><a href="javascript:">
                        <div class="icon-mobile-2">
                        </div>
                    </a></li>
                    <li class="device-mobile-3"><a href="javascript:">
                        <div class="icon-mobile-3">
                        </div>
                    </a></li>
                </div>
                </a></li>
               
            </ul>
        </div>
    </div>
    <div id="iframe-wrap">
        <iframe id="iframe" src="http://www.jq22.com/demo/jquery-sj-150114225713" frameborder="0"  width="100%">
        </iframe>
    </div>

    

    <script type="text/javascript">
        $(document).ready(function () {
            $(".fdr").click(function () {
                $(".fdad").hide();
            });
        });
    </script>


</body>
</html>
