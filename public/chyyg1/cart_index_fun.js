$(function() {
    var a = $("#cartBody"); 
    var c = $("#divNone");
    var b = function() {
        var o = "";
        var h = $("#divTopMoney");
        var g = $("#divBtmMoney");
        var e = function(t, s, r, q) {
            $.PageDialog.fail(t, s, r, q)
        };
        var n = function(s, r, q) {
            $.PageDialog.confirm(s, r, q)
        };
        if (h.length > 0) {
            h.children("a").click(function() {
                location.href = Gobal.Webpath+"/mobile/cart/pay"   //付款页面
            })
        }
        g.find("a").click(function() {
            location.href = Gobal.Webpath+"/mobile/cart/pay"      //付款页面
        });
        var m = function() {
            var q = 0;
            var r = 0;
            $("#cartBody > li input[name='cartMoney']").each(function() {
                var t = parseInt($(this).val());
                if (!isNaN(t)) {
                    r++;
                    q += t;
                }
            });
            if (r > 0) {
                g.find(".money-total em").html("<span>￥</span>"+ q + ".00");
                g.find(".pro-total em").html(r);
            } else { //购物车为空
                g.remove();
                $("#all").remove(); //一键修改购物车商品数量功能
            }
        };
        var d = function() {
            var z = $(this);
            var t = z.attr("id");
            var v = t.replace("txtNum", "");
            var q = z.next().next();
            var limit = z.parent().parent().find(".surplus").length;
            if (limit == 1) {
               var limitNum =  parseInt(z.parent().parent().find(".surplus").text());
            }
            var r = parseInt(z.next().next().next().val());
            var s, y, w = /^[1-9]{1}\d{0,6}$/;
            var u;
            o = t;
            var x = function() {
                if (o != t) {
                    return
                }
                s = q.val();
                y = z.val();
                if (y != "" && s != y) {
                    var B = $(window).width();
                    var A = (B) / 2 - z.offset().left - 127;
                    if (w.test(y)) {
                        u = parseInt(y);
                        if (u <= r) {
                            if (limit == 1) {
                                if (u <= limitNum) {
                                    q.val(y);
                                } else {
                                    u = limitNum;
                                    e("最多" + u + "人次", z, -75, A);
                                    z.val(u);
                                    q.val(u)
                                }
                            } else {
                                q.val(y);
                            }
                        } else {
                            if (limit == 1) {
                                if(limitNum < r) {
                                    r = limitNum;
                                }
                            }
                            u = r;
                            e("最多" + u + "人次", z, -75, A);
                            z.val(u);
                            q.val(u)
                        }
                        p(u, z);
                         
                        j(z, v, u);
                        i(z, u, r);
                    } else {
                        e("只能输正整数哦", z, -75, A);
                        z.val(s)
                    }
                }
                setTimeout(x, 200)
            };
            x()
        };
        var p = function(r, u) {
            var t = u.parent().parent().parent();
            var q = t.find("div.z-Cart-tips");
            if (r > 100) {
                if (q.length == 0) {
                    var s = $('<div class="z-Cart-tips">已超过100人次，请谨慎参与！</div>');
                    t.prepend(s)
                }
            } else {
                q.remove()
            }
        };
        var l = function() {
            var q = $(this);
            if (o == q.attr("id")) {
                o = ""
            }
            if (q.val() == "") {
                q.val(q.next().next().val())
            }
        };
        var j = function(q, t, r, ext) {
            var s = function(w) {
                if (w.code == 1) {
                    var v = $(window).width();
                    var u = (v) / 2 - q.offset().left - 127;
                    e("本期商品已购买光了", q, -75, u)
                } else {
                    if (w.code == 0) {
                        var y = q.attr("yunjiage");
                        q.parent().parent().find("input[name='cartMoney']").val(r * y);
                        m();
                    }
                }
            };
            GetJPData(Gobal.Webpath, "cart", "addShopCart/" + t + "/" + r+"/cart/" + ext, s)
        };
        $(".regular-radio").change(function(){
            var sid = $(this).parent().attr("data-id");
            var value = $("input[name=model_extend_"+ sid + "]:checked").val();
            if(value == 2){
                j($("#txtNum" + sid), sid, 2);
            }else {
                j($("#txtNum" + sid), sid, 1, value);
            }
        });

        $(".zhuijia > span[data-value]").click(function(){
            var sid = $(this).parent().attr("data-id");
            $("#txtNum" + sid).val($(this).attr("data-value")).focus().blur();
        });
        $(".z-promo.gray9 > em[data-value]").click(function(){
            var sid = $(this).parent().attr("data-id");
            $("#txtNum" + sid).val($(this).attr("data-value")).focus().blur();
        });
        var k = function(w, v) {
            var u = v.attr("id");
            var s = u.replace("txtNum", "");
            var r = parseInt(v.next().next().next().val());
            var q = v.next().next();
            var t = parseInt(q.val()) + w;
            var ifLimit = v.parent().parent().find(".surplus").length;
            if(ifLimit == 1) { //限购商品
                var limitNum = parseInt(v.parent().parent().find(".surplus").text());
            }
            if (t > 0 && t <= r) {
                if (ifLimit == 1) { //限购商品
                    if (t <= limitNum) {
                        i(v, t, r);
                        q.val(t);
                        v.val(t);
                        p(t, v);
                        j(v, s, t);
                    }
                } else {
                    i(v, t, r);
                    q.val(t);
                    v.val(t);
                    p(t, v);
                    j(v, s, t);
                }
            }
        };
        var i = function(r, t, s) {
            var limitLen = r.parent().parent().find(".surplus").length;
            if (limitLen == 1) { //限购商品
                var limitN = parseInt(r.parent().parent().find(".surplus").text());
            }
            var q = r.prev();
            var u = r.next();
            if (s == 1) {
                q.addClass("z-jiandis");
                u.addClass("z-jiadis")
            } else {
                if (t == 1) {
                    q.addClass("z-jiandis");
                    if (limitLen == 1) {
                        if (t == limitN) {
                            u.addClass("z-jiadis");
                        } else {
                            u.removeClass("z-jiadis")
                        }
                    } else {
                        u.removeClass("z-jiadis");
                    }
                } else {
                    if (t == s) {
                            q.removeClass("z-jiandis");
                            u.addClass("z-jiadis")
                    } else {
                        if (limitLen == 1) {
                           if (t == limitN) {
                               q.removeClass("z-jiandis");
                               u.addClass("z-jiadis")
                           } else {
                               q.removeClass("z-jiandis");
                               u.removeClass("z-jiadis")
                           }
                        } else {
                            q.removeClass("z-jiandis");
                            u.removeClass("z-jiadis")
                        }
                    }
                }
            }
        };
        $("input[name=num]", a).each(function(q) {
            var r = $(this);
            r.bind("focus", d).bind("blur", l);
            r.prev().bind("click",
            function() {
                k( - 1, r)
            });
            r.next().bind("click",
            function() {
                k(1, r)
            })
        });
        var f = function() {
            var q = $("li", "#cartBody");
            if (q.length < 1) {          
                a.parent().parent().remove();
                c.show();
            } else {
                if (q.length < 4) {
                    h.remove()
                }
            }
        };
        $("a[name=delLink]", a).each(function(q) {
            $(this).bind("click",
            function() {             
                var r = $(this);
                var t = r.attr("cid");
                var s = function() {
                    var u = function(v) {                    
                        if (v.code == 0) {
                        
                            r.parent().parent().parent().remove();
                            m();
                            f()
                        } else {
                            e("删除失败，请重试")
                        }
                    };
                    GetJPData(Gobal.Webpath, "cart", "delCartItem/" + t, u)
                };
                n("您确定要删除吗？", s)
            })
        })
    };
     
    if (a.length > 0) {
        Base.getScript(Gobal.Skin + "/js/mobile/pageDialog.js", b)
    } else {
        c.show()
    }
});