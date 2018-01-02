/**
 * Created by babyface on 17/12/31.
 */
$(function() {

    var c = $("#spPoints");
    var p = $("#spBalance");
    var x = parseInt($("#hidShopMoney").val());//商品价格
    var x1 = $("#hidShopScore").val();//商品福分
    var ffdk = parseInt($("#pointsbl").val());//
    var d = $("#hidBalance").val();//余额
    var t = $("#hidPoints").val();//福分

    var g = ffdk > x ? x : ffdk;
    var s = $("#btnPay");

    //余额支付

    var f = function(y) {

        w = y;


        if (y > 0) {

            p.parent().removeClass("z-pay-grayC");

            p.attr("sel", "1").attr("class", "z-pay-mentsel");

            p.next("span").html('余额支付<em class="orange">' + y + ".00</em>元（账户余额：" + d + " 元）")

            $('#useBalance').val(d);
            q(0);

        } else {

            $('#useBalance').val(0);

            p.attr("sel", "0").attr("class", "z-pay-ment").next("span").html('余额支付<em class="orange">0.00</em>元（账户余额：' + d + " 元）")

        }

       pay();


    };

    p.click(function() {

        if (p.attr("sel") == 1) {

            f(0);

        } else {

            if (parseInt(d) >= x) {
                f(x);
            }


        }

    });

    //选择福分
    var q = function(y) {

        g = y;

        if (y > 0) {

            c.parent().removeClass("z-pay-grayC");

            c.attr("sel", "1").attr("class", "z-pay-mentsel");

            fen = parseInt(y);

            $('#useFufen').val(fen);

            $('#fm').html(y + '.00');
            f(0);
        } else {

            //alert("使用福分支付2");

            c.attr("sel", "0").attr("class", "z-pay-ment");

            $('#useFufen').val(0);

            $('#fm').html('0.00');

        }

       pay();

    };



    c.click(function() {

        if (c.attr("sel") == 1) {

            q(0);

        } else {
           //console.log(t+'----'+x1);
            if (parseInt(t) >= x1) {
		//console.log('ok');
                q(x1);
            }



        }

    });

    var pay = function() {

        var fufen = $('#useFufen').val();

        var balance = $('#useBalance').val();

        var url;


        if(fufen==0 && balance==0){

             s.css('background','#ccc');
             s.css('border','1px solid #ccc');
             s.attr('href','#');

         }else{
            if(fufen>0){
                url = '/user/chaofen/pay';
            }
            if(balance>0){
                url = '/user/chaobi/pay';
            }
            s.css('background','#dc332d');
            s.css('border','1px solid #dc332d');
            s.attr('href',url);
        }


    };


    //默认积分支付

    //q(ffdk);

    //默认余额支付

    if (parseInt(d) >= x) {

        f(x);

    }else if(parseInt(t) >= x1){
        //余额不够用福分支付
        q(x1);
    }else{
        //请充值
        s.text('余额不足，请前往充值');
        s.attr('href','/mcy/user/topup');
    }

});
