/**
 * Created by babyface on 17/12/2.
 */
$(function() {
    var lock=true;
    var i=60;
    var times;
    var show_time=function(){
        i--;
        $('#btnCode').html(i+'s');
        if(i==0){
            i=60;
            $('#btnCode').html('获取验证码');
            lock=true;
            clearInterval(times);
        }
    }

    //获取验证码
    $('#btnCode').click(function(){


        var mobile = $.trim($('#userMobile').val());
        var _token = $.trim($('#_token').val());

        if (mobile=='') {
            layer.msg('请输入您的手机号码!');
            return ;
        }


        $.post(Gobal.Webpath+"/api/mcy/user/send/forgetpass/sms",{mobile:mobile,_token:_token},function(data){


            //成功
            if(data.ret=='0'){
                if (!lock) {return ;};
                lock=false;
                show_time();
                times=setInterval(show_time,1000);
            }else{
                layer.msg(data.msg);
                return ;
            }

        },'json');

    });

    var lock2=true;
    $('#btnNext').click(function(){



        if(!lock2){ lock2= false; return ;}

        var obj={};
        obj.mobile = $.trim($('#userMobile').val());
        obj.pass   = $.trim($('#txtPassword').val());
        obj.code   = $.trim($('#txtVerify').val());
        obj.csessionid=$.trim($('#csessionid').val());
        obj.sig=$.trim($('#sig').val());
        obj._token=$.trim($('#_token').val());
        obj.scene=$.trim($('#scene').val());

        obj.geetest_challenge=$.trim($('input[name="geetest_challenge"]').val());
        obj.geetest_validate=$.trim($('input[name="geetest_validate"]').val());
        obj.geetest_seccode=$.trim($('input[name="geetest_seccode"]').val());


        if (obj.mobile=='') {

            layer.msg("请输入您的手机号码");
            return ;
        }
        if (obj.pass=='') {
            layer.msg("请输入您的密码");
            return ;
        }

        if (obj.pass.length<6) {
            layer.msg("密码必须大于6位");
            return ;
        }

        if (obj.code=='') {
            layer.msg("请输入短信验证码");
            return ;
        };


        $.post(Gobal.Webpath+"/api/mcy/user/dopassword",obj,function(data){

            lock2=true; //解锁

            if(data.ret=='2'){
                layer.msg("短信验证码错误");
                return ;
            }


            /*if(data.stat=='4'){
             $.PageDialog.fail('没有通过滑动验证！');
             return ;
             }*/

            if(data.ret!=0){
                layer.msg(data.msg);
                return ;
            }

            //极验
            /*if(data.stat=='10'){
             $.PageDialog.fail(data.content);
             return ;
             }*/


            //成功
            if(data.ret=='0'){
                layer.msg('设置成功');
                setTimeout(function(){
                    window.location.href=Gobal.Webpath+"/login";
                },2000);
                return ;
            }

        },'json');


    });

    var base64encodechars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
    var base64decodechars = new Array(
        -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
        -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
        -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 62, -1, -1, -1, 63,
        52, 53, 54, 55, 56, 57, 58, 59, 60, 61, -1, -1, -1, -1, -1, -1,
        -1, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14,
        15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, -1, -1, -1, -1, -1,
        -1, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40,
        41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, -1, -1, -1, -1, -1);
    function base64encode(str) {
        var out, i, len;
        var c1, c2, c3;
        len = str.length;
        i = 0;
        out = "";
        while (i < len) {
            c1 = str.charCodeAt(i++) & 0xff;
            if (i == len) {
                out += base64encodechars.charAt(c1 >> 2);
                out += base64encodechars.charAt((c1 & 0x3) << 4);
                out += "==";
                break;
            }
            c2 = str.charCodeAt(i++);
            if (i == len) {
                out += base64encodechars.charAt(c1 >> 2);
                out += base64encodechars.charAt(((c1 & 0x3) << 4) | ((c2 & 0xf0) >> 4));
                out += base64encodechars.charAt((c2 & 0xf) << 2);
                out += "=";
                break;
            }
            c3 = str.charCodeAt(i++);
            out += base64encodechars.charAt(c1 >> 2);
            out += base64encodechars.charAt(((c1 & 0x3) << 4) | ((c2 & 0xf0) >> 4));
            out += base64encodechars.charAt(((c2 & 0xf) << 2) | ((c3 & 0xc0) >> 6));
            out += base64encodechars.charAt(c3 & 0x3f);
        }
        return out;
    }
    function base64decode(str) {
        var c1, c2, c3, c4;
        var i, len, out;
        len = str.length;
        i = 0;
        out = "";
        while (i < len) {

            do {
                c1 = base64decodechars[str.charCodeAt(i++) & 0xff];
            } while (i < len && c1 == -1);
            if (c1 == -1)
                break;

            do {
                c2 = base64decodechars[str.charCodeAt(i++) & 0xff];
            } while (i < len && c2 == -1);
            if (c2 == -1)
                break;
            out += String.fromCharCode((c1 << 2) | ((c2 & 0x30) >> 4));

            do {
                c3 = str.charCodeAt(i++) & 0xff;
                if (c3 == 61)
                    return out;
                c3 = base64decodechars[c3];
            } while (i < len && c3 == -1);
            if (c3 == -1)
                break;
            out += String.fromCharCode(((c2 & 0xf) << 4) | ((c3 & 0x3c) >> 2));

            do {
                c4 = str.charCodeAt(i++) & 0xff;
                if (c4 == 61)
                    return out;
                c4 = base64decodechars[c4];
            } while (i < len && c4 == -1);
            if (c4 == -1)
                break;
            out += String.fromCharCode(((c3 & 0x03) << 6) | c4);
        }
        return out;
    }
    function utf16to8(str) {
        var out, i, len, c;
        out = "";
        len = str.length;
        for (i = 0; i < len; i++) {
            c = str.charCodeAt(i);
            if ((c >= 0x0001) && (c <= 0x007f)) {
                out += str.charAt(i);
            } else if (c > 0x07ff) {
                out += String.fromCharCode(0xe0 | ((c >> 12) & 0x0f));
                out += String.fromCharCode(0x80 | ((c >> 6) & 0x3f));
                out += String.fromCharCode(0x80 | ((c >> 0) & 0x3f));
            } else {
                out += String.fromCharCode(0xc0 | ((c >> 6) & 0x1f));

                out += String.fromCharCode(0x80 | ((c >> 0) & 0x3f));
            }
        }
        return out;
    }
    function utf8to16(str) {
        var out, i, len, c;
        var char2, char3;
        out = "";
        len = str.length;
        i = 0;
        while (i < len) {
            c = str.charCodeAt(i++);
            switch (c >> 4) {
                case 0: case 1: case 2: case 3: case 4: case 5: case 6: case 7:
                // 0xxxxxxx
                out += str.charAt(i - 1);
                break;
                case 12: case 13:
                // 110x xxxx   10xx xxxx
                char2 = str.charCodeAt(i++);
                out += String.fromCharCode(((c & 0x1f) << 6) | (char2 & 0x3f));
                break;
                case 14:
                    // 1110 xxxx  10xx xxxx  10xx xxxx
                    char2 = str.charCodeAt(i++);
                    char3 = str.charCodeAt(i++);
                    out += String.fromCharCode(((c & 0x0f) << 12) |
                        ((char2 & 0x3f) << 6) |
                        ((char3 & 0x3f) << 0));
                    break;
            }
        }
        return out;
    }
    //base64 加密base64encode(utf16to8(value));
    //base64 解密utf8to16(base64decode(value));
});