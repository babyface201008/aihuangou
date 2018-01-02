$.fn.StartTimeOut = function(t, h) {
    var s = $(this);
    var a = new Date();
    a.setSeconds(a.getSeconds() + h);
    var m = 0;
    var p = 0;
    var o = 0;
    var l = function() {
        var v = new Date();
        if (a > v) {
            var w = parseInt((a.getTime() - v.getTime()) / 1000);
            var u = w % 60;
            m = parseInt(w / 60);
            p = parseInt(u);
            if (u >= p) {
                o = parseInt((u - p) * 10)
            } else {
                o = 0
            }
            setTimeout(l, 3000)
        }
    };
    var g = s.find("em");
    var b = g.eq(0);
    var k = g.eq(1);
    var d = g.eq(2);
    var r = g.eq(3);
    var f = 9;
    var n = function() {
        f--;
        if (f < 0) {
            f = 9
        }
        r.html(f);
        setTimeout(n, 10)
    };
    var c = function() {
        r.html("0");
        s.find("p[name='pTime']").html("计算中,请稍后...");

        var checker = setInterval(function () {
            $.getJSON(Gobal.Webpath+"/api/getshop/lottery_huode_shop?oid="+t,function(info){
                if ( !info.error ) {
                    clearInterval(checker);
                    s.removeClass("rNow").removeClass("rFirst").find(".revConR").html('<dl><dd><img src="' + info.uphoto + '"></dd><dd>获得者：<em class="blue">' + info.user + '</em><br>本期：<em class="orange arial">' + info.gonumber + '</em>人次</dd></dl><dt>幸运码：<em class="orange arial">' + info.user_code + '</em><br>揭晓时间：<em class="c9 arial">' + info.end_time + '</em></dt><b class="fr z-arrow"></b>');
                    s.find(".rNowTitle").remove();
                }
            });
        }, 4000);
    };
    var j = function() {
        o--;
        if (o < 1) {
            if (p < 1) {
                if (m < 1) {
                    c();
                    return
                } else {
                    m--
                }
                p = 59
            } else {
                p--
            }
            o = 9
        }
        setTimeout(j, 100)
    };
    var e = 0,
    q = 0;
    var i = function() {
        d.html(o);
        if (e != p) {
            if (p < 10) {
                k.html("0" + p)
            } else {
                k.html(p)
            }
            e = p
        }
        if (q != m) {
            if (m < 10) {
                b.html("0" + m)
            } else {
                b.html("00")
            }
            q = m
        }
        setTimeout(i, 100)
    };
    l();
    j();
    n();
    i()
};