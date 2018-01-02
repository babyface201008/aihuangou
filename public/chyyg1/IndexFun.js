(function(){

    var div = $('#divLottery');
    var update = function(info, key, listLen){
        var html = '<li class="m-lott-item" id="lott-' + info.id + '">' +
            /*  '           <div class="m-lott-text">' +
            '               <a href="' + Gobal.Webpath + '/mobile/mobile/dataserver/' + info.id + '">' + 1 + '</a>' +
            '           </div>' +*/
            '           <div class="m-lott-pic">' +
            '               <a class="' + info.thumb_style + '" href="' + Gobal.Webpath + '/mobile/mobile/dataserver/' + info.id + '">' +
            '                   <img src="' + Gobal.LoadPic + '" src2="' + getOSSImage_300(info.thumb) + '" border="0" alt="' + info.title + '"/>' +
            '               </a>' +
            '           </div>' +
            '           <p>倒计时</p>' +
            '           <div class="m-lott-state">' +
            '               <span class="u-time orange">' +
            '                   <em></em>' +
            '                   <span class="minute">99</span>:<span class="second">99</span>:<span class="millisecond">99</span>' +
            '               </span>' +
            '           </div>' +
            '       </li>';

        var liWidth = div.find("li").outerWidth();
        var marginLen = -1 * (parseInt(key) + 1) * liWidth;//获取li的宽度
        var tmpWidth = (parseInt(key) + 5) * liWidth;
        div.prepend(html);//在divLottery 的头部插入新揭晓的li
        div.find("li").css("width", liWidth);
        div.css({
            "marginLeft" : marginLen,
            "width" : tmpWidth
        });

        loadImgFun();

        var mydiv = div.find('#lott-' + info.id);
        var minute = mydiv.find('span.minute');
        var second = mydiv.find('span.second');
        var millisecond = mydiv.find('span.millisecond');
        var times = (new Date().getTime()) + info.times * 1000;
        var timer = setInterval(function () {
            var time = times - (new Date().getTime());
            if (!info.times || time < 1) {
                clearInterval(timer);
                minute.parent().html('正在计算');
                var checker = setInterval(function () {
                    $.getJSON(Gobal.Webpath + "/api/getshop/lottery_huode_shop", {
                        'oid': info.id
                    }, function (user) {
                        if(!user.error) {
                            clearInterval(checker);
                            mydiv.removeClass();
                            //mydiv.find(".m-lott-text > p").remove();
                            mydiv.children("p").text("获奖者");
                            mydiv.find(".m-lott-state").html('<span class="u-user">' +
                                '<a href="' + Gobal.Webpath + '/mobile/mobile/userindex/' + user.uid + '" class="orange">' +
                                user.user + '</a></span>');
                        }
                    });
                }, 3000);
                return;
            }

            i = parseInt((time / 1000) / 60);
            s = parseInt((time / 1000) % 60);
            ms = String(Math.floor(time % 1000));
            ms = parseInt(ms.substr(0, 2));
            if (i < 10)i = '0' + i;
            if (s < 10)s = '0' + s;
            if (ms < 10)ms = '0' + ms;
            minute.html(i);
            second.html(s);
            millisecond.html(ms);
        }, 41);

        if (key == (listLen - 1)) {
            div.animate({marginLeft:"0px"},2000,function(){//动画效果 并在回调函数中将最后一个li移除
                div.css("width", liWidth * 4);
                div.children("li:gt(3)").remove();
                setTimeout(thread, 5000);
            });
        }
    };

    var oid = '';
    var thread = function() {
        $.getJSON(Gobal.Webpath+"/api/getshop/lottery_going_shoplist",{'oid':oid},function(infos){
            if(infos.error == '0') {
                var list =  infos.listItems;
                oid = list[list.length-1].id;
                var infoLen = list.length;
                for (var key in list) {
                    var info = list[key];
                    update(info, key, infoLen);
                }
            } else {
                setTimeout(thread, 5000);
            }

        });
    };
    thread();
})();