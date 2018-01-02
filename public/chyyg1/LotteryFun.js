$(function () {
    var h = null;
    var a = 0;
    var j = 0;
    var d = $("#divLotteryLoading");
    var l = $("#btnLoadMore");
    var search = $("#search").val();
    var c = function (o) {
        if (o && o.stopPropagation) {
            o.stopPropagation()
        } else {
            window.event.cancelBubble = true
        }
    };
    var b = function () {
        var pro = {"noindex":'1'};
        if(search != ""){
            pro = {'s': search,"noindex":'1'};
        }
        var p = function () {
            d.show();
            $.getJSON(Gobal.Webpath + "/api/getshop/lottery_huode_shoplist/20/" + j, pro, function (s) {
                if (s.error == 0) {
                    var r = s.listItems;
                    var t = r.length;
                    for (var q = 0; q < t; q++) {
                        $('#newgid').val(r[q].yungou_id);
                        var v = '<ul qishu="' +r[q].qishu + '" id="' + r[q].id 
                        + '"><li class="revConL ' + r[q].thumb_style 
                        + '">' 
                        + '<img src1="' + Gobal.LoadPic 
                        + '" src="' +r[q].thumb
                        + '"><span>第' + r[q].qishu 
                        + '期</span></li><li class="revConR"><dl><dd><img name="uImg" uweb="' + r[q].uid 
                        + '" src="' + r[q].uphoto
                        + '"></dd><dd><span>获得者<strong>：</strong><a name="uName" uweb="' + r[q].uid 
                        + '" class="rUserName blue">' + r[q].user 
                        + '</a></span>本期<strong>：</strong><em class="orange arial">' + r[q].gonumber 
                        + '</em>人次</dd></dl><dt>幸运码：<em class="orange arial">' + r[q].user_code 
                        + '</em><br/>揭晓时间：<em class="c9 arial">' + r[q].end_time 
                        + '</em></dt><b class="fr z-arrow"></b></li></ul>';
                        var u = $(v);
                        u.click(function () {
                            location.href = Gobal.Webpath + "/going/product?product_id=" + $(this).attr("id") + '&qishu=' + $(this).attr('qishu');
                        }).find('img[name="uImg"]').click(function (w) {
                            // location.href = Gobal.Webpath + "/mobile/mobile/userindex/" + $(this).attr("uweb");
                            // c(w)
                        });
                        u.find('a[name="uName"]').click(function (w) {
                            // location.href = Gobal.Webpath + "/mobile/mobile/userindex/" + $(this).attr("uweb");
                            // c(w)
                        });
                        d.before(u)
                    }
                    if (t >= 20) {
                        l.show()
                    }
                    $("#btnLoadMore").text("加载更多")
                    loadImgFun()
                }
                d.hide()
            })
        };
        this.getInitPage = function () {
            p()
        };
        this.getNextPage = function () {
            j++;
            p()
        }
    };
    l.click(function () {
        l.hide();
        h.getNextPage()
    });
    h = new b();
    h.getInitPage();
    var e = "";
    var e = $('#newgid').val();
    var n = false;
    var g = 0;
    var i = $("#divLottery");

    var k = function () {
        var pro = {'gid': e,"noindex":"1"};
        if(search != ""){
            pro = {'gid': e, 's': search,"noindex":'1'};
        }
        $.getJSON(Gobal.Webpath + "/api/getshop/lottery_going_shoplist", pro, function (p) {
            if (p.error == 0) {
                o(p)
                $('#newgid').val(p.newgid);
            }
            setTimeout(k, 5000)
        });
        var o = function (q) {  
            var p = function (t) {
                e = t[t.length - 1].yungou_id;
                for (var r = 0; r < t.length; r++) {
                    var s = t[r];
                    var u = $('<ul class="rNow rFirst" id="' + s.id 
                        + '"><li class="revConL ' + s.thumb_style + '"><img src2="' + Gobal.LoadPic + '" src="' + s.thumb+ '"><span>第' + s.qishu + '期</span></li><li class="revConR"><h4>' + s.title + "</h4><h5>价值：￥" + CastMoney(s.shop_money) + '</h5><p name="pTime"><s></s>揭晓倒计时 <strong><em>00</em> : <em>00</em> : <em>0</em><em>0</em></strong></p><b class="fr z-arrow"></b></li><div class="rNowTitle">正在揭晓</div></ul>');
                    u.click(function () {
                        location.href = Gobal.Webpath + "/product?product_id=" + $(this).attr("id");
                    });
                    i.prepend(u);
                    u.next().removeClass("rFirst");
                    u.StartTimeOut(s.yid, parseInt(s.times))
                }
                loadImgFun();
            };
            if (n) {
                p(q.listItems)
            } else {
                Base.getScript(Gobal.Skin + "/chyyg1/LotteryTimeFun.js?v=16120201", function () {
                    n = true;
                    p(q.listItems)
                })
            }

        }
    };
    Base.getScript(Gobal.Skin + "/chyyg1/Comm.js", k)
});