

// user

jQuery.validator.addMethod("isMobile", function(value, element) {
    var length = value.length;
    var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
    return this.optional(element) || (length == 11 && mobile.test(value));
}, "请正确填写您的手机号码");
jQuery.validator.addMethod("whattype", function(value, element) {  
    return (value != "请选择");  
}, "必须选择一项");  
var e = "<i class='fa fa-times-circle'></i> ";
$.validator.setDefaults({ 
    highlight: function(e) { 
        $(e).closest(".form-group").removeClass("has-success").addClass("has-error") 
    }, 
    success: function(e) { 
        // e.closest(".form-group").removeClass("has-error").addClass("has-success") 
    }, 
    errorElement: "span", 
    // errorPlacement: function(e, r) { 
    //     e.appendTo(r.is(":radio") || r.is(":checkbox") ? r.parent().parent().parent() : r.parent()) 
    // },
    errorPlacement: function (error, element) { //指定错误信息位置
	    if (element.is(':radio') || element.is(':checkbox')) { //如果是radio或checkbox
	       	var eid = element.attr('name'); //获取元素的name属性
	       	error.appendTo(element.parent()); //将错误信息添加当前元素的父结点后面
	    } else {
	       	error.insertAfter(element);
	    }
   	}, 
    errorClass: "help-block m-b-none", 
    validClass: "help-block m-b-none" 
});

// 我的个人资料
$("#userData").validate({ 
    rules: { 
    	uname: {
    		required: true
    	},
        usex: "required",
        idcard: {required:true},
        mobile: {
            required : true,
            minlength : 11,
            isMobile : true
        },
        ubirthday: {
        	required: true,
        	whattype: true
        },
        guanji: {
        	required: true,
        	whattype: true
        },
        umajor: {required:true},
        xueli: {
        	required: true,
        	whattype: true
        },
        uschool: {required: true,whattype: true},
        uschoolMsg: {required: true},
        uhighSchool: {required: true},
        indentity: {required: true,whattype: true},
        work_pos: {required:true,whattype: true},
        senhuo_pos: {required: true,whattype: true},

        email: "required",
        password: "required",
        confirm_password: {
            required : true,
            equalTo : "#password"
        }
    },
    messages: { 
    	uname: e + "请输入姓名",
    	usex: e + "请选择男女",
        idcard: e + "请输入身份证号",
        mobile: "请输入正确的手机号码",
        ubirthday: e + "请选择出生日期",
        guanji: e + "请选择贯籍",
        xueli: e + "请选择学历",
        umajor: e + "请输入所学专业",
        uschool: e + "请选择院校",
        uschoolMsg: e + "请输入详细高校信息",
        uhighSchool: e + "请输入高中母校信息",
        indentity: e + "请选择身份信息",
        work_pos: e + "学校位置不能为空",
        senhuo_pos: e + "家庭地址不能为空",

        email: e + "请输入正确的邮箱",
        password: e + "请输入密码",
        confirm_password: e + "请确认两次密码"
    },
    submitHandler: function(form) { 
    	// debug:true;
    	console.log($('#userData').serialize())
    	// return ;
        $.ajax({
            type : 'post',
            url  : '/api/signin',
            dataType : 'json',
            data : $("#form").serialize({
                _token   : "{!! csrf_token() !!}",
                data 	 : $('#userData').serialize()
            }),
            success: function(data) {
                console.log(data);
                if(data == null) {
                    layer.msg('服务端错误', {icon:2, time:2000});
                    return;
                }
                if(data.ret != 0) {
                    layer.msg(data.msg, {icon:2, time:2000});
                    return;
                }
                layer.msg(data.msg, {icon:1, time:2000});
                location.href = '/teacher/login';
                return false;

            },
            error: function(xhr, ret, error) {
                console.log(xhr);
                console.log(ret);
                console.log(error);
                layer.msg('ajax error', {icon:2, time:2000});
            },
            beforeSend: function(xhr){
                layer.load(0, {shade: false});
            },
            complete: function(){
                layer.closeAll('loading');
            }
        });
        return false;
    }
});




// 教学信息
$(".li-box .top-left li").click(function(){
	var id = $(this).attr("data-value");
	var me = $(this);
	var _val = $(this).html(),
		len = $(".li-box .top-left").siblings(".right").find("li").length;
	if (len>9) {
		alert("最多选择九项！");
	} else{
		if($(this).parent().parent().siblings(".right").find('li').length == 0) {
			var ul = $(this).parent().parent().siblings(".right").find('ul');
			var li = $("<li></li>").attr('data-id',id);
			var span = $("<span></span>");
			var em = $("<em></em>");
			// var spanVal = $(this).find("span").html();
			span.html(_val);
			// em.attr("onclick","deleteid(" + id + ")");
			li.append(span).append(em).show();
			ul.append(li);
			// console.log(li);
			addnode(me,id);
			li.on('click','em',function() {
				deleteid(id);
			})
		} else {
			var part = true;
			$(this).parent().parent().siblings(".right").find('li').each(function() {
				if($(this).attr('data-id') == id) {
					part = false;
					return false;
				}
			})
			if(part) {
				var ul = $(this).parent().parent().siblings(".right").find('ul');
				var li = $("<li></li>").attr('data-id',id);
				var span = $("<span></span>");
				var em = $("<em></em>");
				// var spanVal = $(this).find("span").html();
				span.html(_val);
				// em.attr("onclick","deleteid(" + id + ")");
				li.append(span).append(em).show();
				ul.append(li);
				// console.log(li);
				addnode(me,id);
			}
		}
	}
	$(this).parent().parent().siblings('.right').find('ul').on('click','em',function() {
		deleteid($(this).parent());
	})
})

function deleteid(obj) {
	var id = $(this).attr("data-id");
    var old_id = obj.parent().parent().siblings('.list-input').val();
    var reg = new RegExp("," + id,"g");
    old_id = old_id.replace(reg, '');
    obj.parent().parent().siblings('.list-input').val(old_id);
    if(obj) {obj.remove();}
}
function check_chose(){
    var value = $("#FirstJob").val();
    $(".hidden_class_node").hide();
    $("#chose_"+value).show();
}
function addnode(obj,id){
	var input = obj.parent().parent().siblings('.list-input');
    var old_id = input.val();
    old_id = old_id + "," + id;
    
    input.val(old_id);
    console.log(input.val())
}
// 提交表单
function areaandnode() {
	// $('#areaandnode').submit();
	var job = $('#FirstJob').val();		// 授课科目类型
	var lis = $('.first-subject-box .tright ul li');
	if(lis.length == 0) {alert("请选择科目类型"); return;}
	var jobNumArr = [], jobMsgArr = [];
	lis.each(function() {
		jobNumArr.push($(this).attr('data-id'));		// 科目num
		jobMsgArr.push($(this).find("span").text());	// 科目类型
	});
	var quyuNumArr = [], quyuMsgArr = [];
	var quyu = $('.quyu-list-box .right ul li');
	if(quyu.length == 0) {alert("请选择授课区域"); return;}
	quyu.each(function() {
		quyuNumArr.push($(this).attr('data-id'));		// 区域num
		quyuMsgArr.push($(this).find("span").text());	// 区域类型
	})
	var message = $("#teach_place_discrib").val();
	if(message.length == 0) {alert("请输入详细描述"); return ;}
	var fdfs = [];
	$(".fdfs input").each(function() {
		if($(this).prop('checked')) {
			fdfs.push($(this).val());
		}
	})
	if(fdfs.length == 0) {alert('请选择辅导方式'); return ;}
	var money = $('.imoney').val();
	if(money.length == 0) {alert('请输入薪资要求'); return ;}
	$.ajax({
	    type : 'post',
	    url  : '/api/signin',
	    dataType : 'json',
	    data : $("#form").serialize({
	        _token   : "{!! csrf_token() !!}",
	        kemu_ids: jobNumArr.join(','),
	        kemy_names: jobMsgArr.join(','),
	        shouke_ids: quyuNumArr.join(','),
	        shouke_names: quyuMsgArr.join(','),
	        message: message,
	        fdfs: fdfs,
	        money: money
	    }),
	    success: function(data) {
	        console.log(data);
	        if(data == null) {
	            layer.msg('服务端错误', {icon:2, time:2000});
	            return;
	        }
	        if(data.ret != 0) {
	            layer.msg(data.msg, {icon:2, time:2000});
	            return;
	        }
	        layer.msg(data.msg, {icon:1, time:2000});
	        location.href = '/teacher/login';
	        return false;

	    },
	    error: function(xhr, ret, error) {
	        console.log(xhr);
	        console.log(ret);
	        console.log(error);
	        layer.msg('ajax error', {icon:2, time:2000});
	    },
	    beforeSend: function(xhr){
	        layer.load(0, {shade: false});
	    },
	    complete: function(){
	        layer.closeAll('loading');
	    }
	});
}




// 教学经验
$('.bsubmit').click(function() {
	var book = $(".othersave_book").val();
	if(book.length == 0) {alert('请输入获奖证书'); return ;}
	var appraise_self = $('.appraise_self').val();
	if(appraise_self.length == 0) {alert('请描述您的教学经历'); return ;}
	var resume = $('#othersave2 .resume').val();
	if(resume.length == 0) {alert('请描述您的教学案例'); return ;}
	$.ajax({
	    type : 'post',
	    url  : '/api/signin',
	    dataType : 'json',
	    data : $("#form").serialize({
	        _token   : "{!! csrf_token() !!}",
	        book: book,
	        self: appraise_self,
	        resume: resume
	    }),
	    success: function(data) {
	        console.log(data);
	        if(data == null) {
	            layer.msg('服务端错误', {icon:2, time:2000});
	            return;
	        }
	        if(data.ret != 0) {
	            layer.msg(data.msg, {icon:2, time:2000});
	            return;
	        }
	        layer.msg(data.msg, {icon:1, time:2000});
	        location.href = '/teacher/login';
	        return false;

	    },
	    error: function(xhr, ret, error) {
	        console.log(xhr);
	        console.log(ret);
	        console.log(error);
	        layer.msg('ajax error', {icon:2, time:2000});
	    },
	    beforeSend: function(xhr){
	        layer.load(0, {shade: false});
	    },
	    complete: function(){
	        layer.closeAll('loading');
	    }
	});
})




