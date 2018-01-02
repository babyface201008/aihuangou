/**
 * Created by wuyueqiang on 2017/3/27.
 */
$(window).ready(function(){
    $('body').show()
    var maxtime;
    var mintime;
    var uid;
    var startX = startY = endX = endY =  0;
    var status = 0,firstY = 40;
    if (!sessionStorage.jdId){
        buildUid();
    }else {
        uid = sessionStorage.jdId;
    }
    fristlist();
    //生成临时uid
    function buildUid () {
        $.ajax({
            type:"get",
            url:"http://"+ com + "/index/recommend_artlist",
            async:true,
            dataType:"json",
            data:{

            },
            success:function(json){
                //console.log(json);
                if (json.data.type == "true") {
                    sessionStorage.jdId = json.data.uid;
                    uid = json.data.uid;
                }else {
                    //console.log("生成临时uid失败");
                }
            },
            error:function(){
                //console.log("请求临时uid失败");
            }
        });
    }
    //首次加载推荐文章列表
    function fristlist(){
        $.ajax({
            type:"get",
            url:"http://"+ com + "/recommend/artlist",
            async:true,
            dataType:"json",
            data:{
                "pagesize": 12,
                "token": "",
                "uid": uid,
                "act": "",
                "mintime": 0,
                "maxtime": 0
            },
            success:function(json){
                console.log(json)
                if (json.data.list.length == 0) {
                    $('.nothing').show();
                }else if (json.data.list.length > 0) {
                    maxtime = json.data.maxtime;
                    mintime = json.data.mintime;
                    for(var i = 0; i < json.data.list.length; i++){
                        $('.main_scroll').append(htmlFn(json.data.list[i]));
                    }
                    $(".scroll_bottom").html('加载中...').show();
                    $(".article_boxs .article_imgs").bind("error", function () {
                        this.src = "../images/public/noimg.png";
                    });
                }
            },
            error:function(){

            }
        });
    }
    //刷新 加载更多推荐文章列表
    function addlist(refresh){
        if (refresh == 'flush'){
            $.ajax({
                type:"get",
                url:"http://"+ com + "/recommend/artlist",
                async:true,
                dataType:"json",
                data:{
                    "pagesize": 12,
                    "token": "",
                    "uid": uid,
                    "act":"flush",
                    "mintime":mintime,
                    "maxtime":maxtime
                },
                success:function(json){
                    console.log(json);
                    if (json.data.list.length == 0) {
                        //已是最新
                        $(".read img").removeClass('shuaxin');
                        $(".read").remove();
                        $(".scroll_top").animate({'top':  -firstY + 'px' },0);
                        $(".scroll_top").removeClass('shuaxin');
                        $('.gengxin').text('已更新到最新').stop(true,false).show().delay(2000).fadeOut(500);
                    }else if (json.data.list.length > 0) {
                        $(".read img").removeClass('shuaxin');
                        $(".read").remove();
                        $(".scroll_top").animate({'top':  -firstY + 'px' },0);
                        $(".scroll_top").removeClass('shuaxin');
                        $('.gengxin').text('又发现了'+json.data.list.length+'篇文章').stop(true,false).show().delay(2000).fadeOut(500)
                        maxtime = json.data.maxtime;
                        mintime = json.data.mintime;
                        $('.read').remove();
                        $('.main_scroll').prepend(
                            '<div class="read">刚刚阅读到这里，点击刷新 <img src="../images/public/refresh.png" alt=""></div>'
                        );
                        for(var i = json.data.list.length - 1; i >= 0; i--){
                            $('.main_scroll').prepend(htmlFn(json.data.list[i]));
                        }
                        $(".article_boxs .article_imgs").bind("error", function () {
                            this.src = "../images/public/noimg.png";
                        });
                    }
                },
                error:function(){
                    $(".read img").removeClass('shuaxin');
                    $(".read").remove();
                    $(".scroll_top").animate({'top':  -firstY + 'px' },0);
                    $(".scroll_top").removeClass('shuaxin');
                }
            });
        }else if (refresh == 'more'){
            $.ajax({
                type:"get",
                url:"http://"+ com + "/recommend/artlist",
                async:true,
                dataType:"json",
                data:{
                    "pagesize": 12,
                    "token": "",
                    "uid": uid,
                    "act":"more",
                    "mintime":mintime,
                    "maxtime":maxtime
                },
                success:function(json){
                    //console.log(json)
                    if (json.data.list.length == 0) {
                        //已无更多
                        $(".scroll_bottom").html('已无更多内容');
                    }else if (json.data.list.length > 0) {
                        maxtime = json.data.maxtime;
                        mintime = json.data.mintime;
                        for(var i = 0; i < json.data.list.length; i++){
                            $('.main_scroll').append(htmlFn(json.data.list[i]));
                            //console.log(json.data.list[i].type)
                        }
                        $(".scroll_bottom").show();
                        $(".article_boxs .article_imgs").bind("error", function () {
                            this.src = "../images/public/noimg.png";
                        });
                    }
                },
                error:function(){

                }
            });
        }
    }
    function htmlFn(data){
        var _html = ''
        if (data.pics.length == 0){
            _html =
                '<div class="article_boxs article_noimg_box" articleTime="'+ data.dtime +'" articleId="'+ data.id +'" articleType="'+ data.type +'" >'+
                '<div class="article_noimg_title">'+ data.title +'</div>'+
                '<div class="article_marker_btn">'+ data.artsource +'</div>'+
                '</div>'
        }else if (data.pics.length > 0 && data.pics.length < 3){
            _html =
                '<div class="article_boxs article_lr_box" articleTime="'+ data.dtime +'" articleId="'+ data.id +'" articleType="'+ data.type +'" >'+
                '<div class="article_left_box">'+
                '<div class="article_left_title">'+ data.title +'</div>'+
                '<div class="article_marker_btn">'+ data.artsource +'</div>'+
                '</div>'+
                '<div class="article_right_box">'+
                '<img class="article_imgs" src="'+ data.pics[0] +'">'+
                '</div>'+
                '</div>'
        }else if (data.pics.length >= 3) {
            _html =
                '<div class="article_boxs article_3img_box" articleTime="'+ data.dtime +'" articleId="'+ data.id +'" articleType="'+ data.type +'">'+
                '<div class="article_3img_title">'+ data.title +'</div>'+
                '<div class="article_3imgs">'+
                '<img class="article_imgs" src="'+ data.pics[0] +'">'+
                '<img class="article_imgs article_midImg" src="'+ data.pics[1] +'">'+
                '<img class="article_imgs" src="'+ data.pics[2] +'">'+
                '</div>'+
                '<div class="article_marker_btn">'+ data.artsource +'</div>'+
                '</div>'
        }
        return _html
    }
    var dom = document.getElementById('main_scroll');
    dom.addEventListener('touchstart',function(event){
        if (document.body.scrollTop == 0) {
            var touch = event.targetTouches[0];
            status = 1;
            startX = touch.pageX;
            startY = touch.pageY;
        }
    });
    dom.addEventListener('touchmove',function(event){
        var touch = event.targetTouches[0];
        if (!status) {
            return
        }
        endX = touch.pageX;
        endY = touch.pageY;
        length = endY - startY;
        if (length > 0) {
            $('body').css('overflow','hidden');
            event.preventDefault();
        }
        if (length > 160) {
            length = 160;
            $(".scroll_top").css('top', length/2 - firstY + 'px' );
            $(".scroll_top img").css('transform','rotate('+ (length/2 - firstY)/80*360 + 'deg)');
        }else {
            $(".scroll_top").css('top', length/2 - firstY + 'px' );
            $(".scroll_top img").css('transform','rotate('+ (length/2 - firstY)/80*360 + 'deg)');
        }
    },false);
    var timeout2 = null;
    dom.addEventListener('touchend',function(event){
        $('body').css('overflow','scroll');
        status = 0;
        $(".scroll_top img").animate({'transform':'rotate('+ 180 +'deg)'},500);
        if (length > 120){
            $(".scroll_top").addClass('shuaxin');
            $(".scroll_top").animate({'top':  20 + 'px' },200);
            clearTimeout(timeout2);
            timeout=setTimeout(function(){
                $(".xinzhi_list").remove();
                addlist('flush');
            },99)
        }else {
            $(".scroll_top").animate({'top':  -firstY + 'px' },500);
        }

    },false);
    var timeout=null;
    $(window).scroll(function(){
        var scrollTop = $(this).scrollTop();
        var scrollHeight = $(document).height();
        var windowHeight = $(this).height();
        $(".scroll_bottom").html('加载中...').show();
        if(scrollTop + windowHeight + 200 >  scrollHeight){
            clearTimeout(timeout);
            //alert("加载更多");
            timeout=setTimeout(function(){
                addlist('more');
            },99)
        }
    });
    //点击加载文章详情
    $(".main_scroll").on('click','.article_boxs',function(){
        var aid = $(this).attr('articleId');
        var atime = $(this).attr('articleTime');
        var type = $(this).attr('articletype');
        if (type == 'xinzhi') {
            window.location.href = "http://"+ murl +"/html/recommend/xinzhi.html?aid="+aid;
        }else {
            window.location.href = encodeURI("http://" + murl + "/html/recommend/article.html?thisArticleId=" + aid + "&thisArticleTime=" + atime + "&thisType="+type);
        }
    });
    $(".main_scroll").on("click",'.read',function(){
        $(".read img").addClass('shuaxin');
        addlist('flush');
    })
});