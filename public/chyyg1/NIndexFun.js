$(function() {
    var a = function() {
        var c = $("#divTimerItems");
        var f = c.find("div[name=timerItem]");
        if (f.length > 0) {		 
            var b = function() {
                f.each(function() {
                    var m = $(this);
                    var n = parseInt(m.attr("time"));
                    if (n > 0) {
                        var l = function() {
                            window.location.reload()
                        };
                        m.countdowntime(n, l)
                    }
                })
            };			 
            Base.getScript(Gobal.Skin + "/js/mobile/CountdownFun.js", b)
        }
        var i = c.find("div[name=waiterItem]");
        if (i.length > 0) {
            i.each(function() {
                var m = $(this);
                var n = parseInt(m.attr("time"));
                if (n > 0) {
                    var l = function() {
                        window.location.reload()
                    };
                    setTimeout(l, n * 1000)
                }
            })
        }
        var g = ",";
        var k = false;
        var h = 0;
        /*var j = function() {
            GetJPData(Gobal.Webpath, "ajax", "show_msjxshop/" + h,
            function(m) {
			   
                if (m.errorCode == 0) {
                    l(m)
                }
                setTimeout(j, 5000)
            });
            var l = function(n) {
                h = n.maxSeconds;
                var m = function(r) {
                    var q = $("#divLottery");
                    for (var o = r.length - 1; o > -1; o--) {
                        var p = r[o];
						//alert(g.indexOf(",14,"))
                        if (g.indexOf("," + p.codeID + ",") < 0) {
                            g += p.codeID + ",";
                            var s = $('<div class="m-lott-conduct" id="' + p.codeID + '"><p class="z-lott-tt">(第' + p.period + "期)" + p.goodsSName + '<b class="z-arrow"></b><span class="z-lott-time">揭晓倒计时<span class="minute">00</span>:<span class="second">00</span>:<span class="millisecond">0</span><span class="last">0</span></span></p></div>');
                            s.click(function() {
                                location.href = Gobal.Webpath+"/mobile/mobile/item/"+ $(this).attr("id")
                            });
                            q.prepend(s);
                            s.StartTimeOut(p.codeID, parseInt(p.seconds))
                        }
                    }
                };
                if (k) {
                    m(n.listItems)
                } else {
                    Base.getScript(Gobal.Skin + "/js/mobile/indexLotteryFun.js",
                    function() {
                        k = true;
                        m(n.listItems)
                    })
                }
            }
        };
        j();*/
       var e = function() {
            GetJPData(Gobal.Webpath, "ajax", "slides",
            function(s) {
                if (s.state == 0) {
                    var r = s.listItems;
                    var n = $("<ul/>");
                    n.addClass("slides");
                    var p = "";
                    for (var o = 0; o < r.length; o++) {
                        var m = '<li style="background-color:' + r[o].alt + ';"><a href="' + r[o].url + '"><img src="' + r[o].src + '" /></a></li>';
                        n.append(m)
                    }
                    var q = $("#sliderBox");
                    q.append(n).flexslider()
                }
            });
            var l = parseInt($("#hidStartAt").val());
            $("#autoLotteryBox").flexslider({
                slideshow: false,
                animationLoop: false,
                controlType: 1,
                controlPos: 1,
                startAt: l
            });
        };
        Base.getScript(Gobal.Skin + "/chyyg1/Flexslider.js", e);
        var d = function(l) {
            if (l && l.stopPropagation) {
                l.stopPropagation()
            } else {
                window.event.cancelBubble = true
            }
        };
        $("li", c).each(function() {
            var m = $(this);
            var l = m.attr("codeid");
            m.click(function() {
                location.href = Gobal.Webpath+"/mobile/mobile/item/" + l
            });
            var n = m.attr("uweb");
            if (n != undefined) {
                m.find("uImg").click(function(o) {
                    d(o);
                    location.href = Gobal.Webpath+"/mobile/home/" + n
                });
                m.find("uName").click(function(o) {
                    d(o);
                    location.href = Gobal.Webpath+"/mobile/home/" + n
                })
            }
        });
        $("#ulRecommend > li").each(function() {
            var l = $(this);
            /*l.click(function() {
                location.href = Gobal.Webpath+"/mobile/mobile/item/" + l.attr("id")
            })*/
        });
		//添加到购物车
		/*$('.add').click(function(){
			var codeid=$(this).attr('codeid');
			$.getJSON(Gobal.Webpath+'/mobile/ajax/addShopCart/'+codeid+'/1',function(data){
				if(data.code==1){
					addsuccess('添加失败');
				}else if(data.code==0){
					addsuccess('添加成功');				
				}return false;
			});
		});*/
		function addsuccess(dat){
			$("#pageDialogBG .Prompt").text("");
			var w=($(window).width()-255)/2,
			h=($(window).height()-45)/2;
			$("#pageDialogBG").css({top:h,left:w,opacity:0.8});
			$("#pageDialogBG").stop().fadeIn(1000);
			$("#pageDialogBG .Prompt").append('<s></s>'+dat);
			$("#pageDialogBG").fadeOut(1000);
			//购物车数量
			$.getJSON(Gobal.Webpath+'/mobile/ajax/cartnum',function(data){
				$("#btnCart i").append('<b class="pig" id="pig">'+data.num+'</b>');
				$('.f_car').find('#pig').html(data.num);
			});
		}
	
    };
    a();


	(function(){
		var thread = function(){
			var ls = $('#divLottery ul');
			var gid=$('#newgid').val();
			$.getJSON(Gobal.Webpath+"/api/getshop/lottery_index_shop_get/"+new Date().getTime(),{'test':true,'gid':gid},function(info){
				if(info.error == '0'){
					n=info.listItems;
					t=n.length;
					var o='';
					for(p=0;p<t;p++){
						o='<li><div><p class="shopname">';
						o+='<a href="'+Gobal.Webpath+'/going/product?product_id='+n[p].id+'">';
						o+=n[p].title+'</a></p>';
						o+='<span id="new_'+n[p].id+'">';
						if(n[p].q_showtime=='N'){
							o+='<p class="obtain">获得者：<a href="'+Gobal.Webpath+'/userinfo/'+n[p].q_uid+'" class="blue z-user">'+n[p].username+'</a></p>';
						}
						else{
							pstr='<p class="countdown"><span class="z-lott-time">';
							pstr+='<span class="second">00</span>:<span class="millisecond">00</span></span></p>';
							//pstr='<p name="pTime"><s></s>揭晓倒计时 <strong><em>00</em> : <em>00</em></strong></p>';
							nptime=$(pstr);
							nptime.newest_lottery_show_time_init(Gobal.Webpath,n[p]);
						}
						o+='</span></div><a href="'+Gobal.Webpath+'/going/product?product_id='+n[p].id+'" class="u-lott-pic">';
						o+='<img  src="' + n[p].thumb+'" border="0" alt="" /></a>';
						o+='</li>';
						ls.find("li:last-child").remove();
						ls.prepend(o);
						ls.find('#new_'+n[p].id).html(nptime);
					}
					$('#newgid').val(info.newgid);
				}
			});
		};

		setInterval(thread, 4000);
		thread();
	})();

});