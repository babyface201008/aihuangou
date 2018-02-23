/**
 * Created by babyface on 17/12/2.
 */
$(function() {


    $('#btnLogin').click(function() {

        var obj = {};
        obj.mobile = $.trim($('#txtAccount').val());
        obj.pass = $.trim($('#txtPassword').val());
        obj._token = $.trim($('#_token').val());


        if (obj.mobile == '') {
            layer.msg('请输入您的手机号码!');
            return;
        }


        if (obj.pass == '') {
            layer.msg('请输入您的密码!');
            return;
        }



        $.post(Gobal.Webpath + "/api/mcy/user/dologin", obj, function (data) {


            if (data.ret != 0) {
                layer.msg(data.msg);
                return;
            }

            //成功
            if (data.ret == '0') {
                layer.msg('登录成功!');
                setTimeout(function () {
                    window.location.href = Gobal.Webpath + "/";
                }, 2000);
                return;
            }

        }, 'json');
    });



});