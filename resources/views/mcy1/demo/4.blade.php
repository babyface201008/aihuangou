

<!DOCTYPE HTML>
<html style="padding-bottom: 54px;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">

    <title>适合手机、pad等移动终端的tab响应式切换效果</title>
    <meta name="description" content="适合手机、pad等移动终端的tab响应式切换效果" /> 
    <meta name="keywords" content="响应式tab切换，tabs,jquery,jquery插件" />
    <link rel="Shortcut icon" href="http://www.jq22.com/favicon.ico" />
    <link href="css/demo.css" rel="stylesheet" media="all" />
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
        var txt = "http://www.jq22.com/demo/jquery-tabs20151019";
        window.g1 = txt.substr(0, 3);
        window.g2 = txt.substr(0, 19);
    </script>
    <script src="js/pace.min.js" charset="gbk"></script>
    <link href="css/pace-theme-barber-shop.css" rel="stylesheet" />
    <script src="http://libs.baidu.com/jquery/1.7.0/jquery.min.js"></script>
    <script src="js/jquery.qrcode.min.js"></script>
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
                <li class="top2" id="sj"><a href="#">手机二维码预览</a><div class="vm" ><div id="output"></div><p style="color:#808080">扫一扫，直接在手机上打开</p></div></li>
                <li class="logoTop" id="sj2"><a href="http://www.jq22.com/jquery-info4414">适合手机、pad等移动终端的tab响应式切换效果</a></li>
       
                <script>
                jQuery('#output').qrcode({width:150,height: 150,text: window.location.href});
                </script>
                <li class="remove_frame"><a href="http://www.jq22.com/demo/jquery-tabs20151019"  title="移除框架">
                </a></li>
               
            </ul>
        </div>
    </div>
    <div id="iframe-wrap">
        <iframe id="iframe" src="http://www.jq22.com/demo/jquery-tabs20151019" frameborder="0"  width="100%">
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
