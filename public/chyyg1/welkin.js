/* 统一修改Javascript文件 */

$(function() {
	var ac = addCart = $(".addCart");
	var host = location.host;
	//其它页面点击购物车按钮
	$(document).on("click", '.addCart', function (o) {
		var pid = $(this).attr('pid');
		var n = $(this).attr('n');
		var qishu = $(this).attr('qishu');
		/* t=2 加入购物车 */
		var t = $(this).attr('t');
		$.getJSON('/api/add/cart/' + pid + '/' + n,{"qishu":qishu},function(json){
			if (json.ret == 0)
			{
				/* 添加到购物清单中 */
				if (t == 2)
				{
                    $('.f_car .i-shouye').html('<em>'+json.cart+'</em>');
					layer.msg('添加成功');
					return '';
				}else{
					location.href = '/cartlist';
					return "";
				}
			}else{
				/* 失败信息*/
                layer.msg(json.msg,{icon:2,time:2000});
			}
		});
	});
	var zhuijia1 = $(".zhuijia1");
	zhuijia1.on('click',function(){
		var qishu = $(this).attr('qishu');
		var n1 = $(this).attr('n');
		console.log(n1);
		var pid = $(this).attr('pid');
		$.getJSON('/api/zhiding/cart/' + pid + '/' + n1,{"qishu":qishu,'type':5},function(json){
			if (json.ret == 0){
                //_this.prev(".product_number").val(parseInt(_this.prev(".product_number").val()) + parseInt(n1));
				location.href = location.pathname + '?v='+GetVerNum();
				return "";
			}else{
				/* 失败信息*/
                layer.msg(json.msg,{icon:2,time:2000});
			}
		});
	});
	var product_jian = $(".product_jian");
	product_jian.on('click',function(){
		var qishu = $(this).attr('qishu');
		var n = $(this).attr('n');
		var pid = $(this).attr('pid');
		var all_price = $(".all_price"); 
		var _this = $(this);
		$.getJSON('/api/delete/cart/' + pid + '/' + n,{"qishu":qishu,'type':2},function(json){
			if (json.ret == 0){
					_this.next(".product_number").val(parseInt(_this.next(".product_number").val()) - parseInt(n));
				all_price.val(all_price.val() + parseInt(json.price));
				location.href = location.pathname + '?v='+GetVerNum();
				return "";
			}else{
				/* 失败信息*/
                layer.msg(json.msg,{icon:2,time:2000});
			}
		});
	});
	var product_jia = $(".product_jia");
	product_jia.on('click',function(){
		var qishu = $(this).attr('qishu');
		var n = $(this).attr('n');
		var pid = $(this).attr('pid');
		var all_price = $(".all_price"); 
		var _this = $(this);
		console.log(_this);
		$.getJSON('/api/add/cart/' + pid + '/' + n,{"qishu":qishu,'type':3},function(json){
			if (json.ret == 0){
				_this.prev(".product_number").val(parseInt(_this.prev(".product_number").val()) + parseInt(n));
				
				all_price.val(all_price.val() + parseInt(json.price));
				location.href = location.pathname + '?v='+GetVerNum();
				return "";
			}else{
				/* 失败信息*/
                layer.msg(json.msg,{icon:2,time:2000});
			}
		});
	});
	var product_del = $(".product_del");
	product_del.on('click',function(){
		var qishu = $(this).attr('qishu');
		var n = $(this).attr('n');
		var pid = $(this).attr('pid');
		_this = $(this);
		layer.confirm('确定删除?',function(){
			$.getJSON('/api/delete/cart/' + pid + '/' + n,{"qishu":qishu,'type':4},function(json){
				if (json.ret == 0){
					_this.parent().parent().parent().hide();
					// _this.prev(".product_number").val(parseInt(_this.prev(".product_number").val()) + parseInt(n));
					layer.closeAll('');

					location.href = location.pathname + '?v='+GetVerNum();
					return true;
				}else{
					/* 失败信息*/
                    layer.msg(json.msg,{icon:2,time:2000});
				}
			});		
		});
	});
	var z_amount = $(".z-amount");
    z_amount.on('click',function(){
        /*$(this).select();*/
    }).keyup(function(){
		var qishu = $(this).attr('qishu');
		// var n = $(this).attr('n');
		var pid = $(this).attr('pid');
		var n = $("#txtNum"+pid).val();
		_this = $(this);
		$.getJSON('/api/zhiding/cart/' + pid + '/' + n,{"qishu":qishu,'type':5},function(json){

			if (json.ret == 0){
				_this.prev(".product_number").val(parseInt(_this.prev(".product_number").val()) + parseInt(n));
				location.href = location.pathname + '?v='+GetVerNum();
				return true;
			}else{
				/* 失败信息*/
                layer.msg(json.msg,{icon:2,time:2000});
			}
		});		
	}).blur(function(){
        var qishu = $(this).attr('qishu');
        // var n = $(this).attr('n');
        var pid = $(this).attr('pid');
        var n = $("#txtNum"+pid).val();
        _this = $(this);
        $.getJSON('/api/zhiding/cart/' + pid + '/' + n,{"qishu":qishu,'type':5},function(json){
            if (json.ret == 0){
                _this.prev(".product_number").val(parseInt(_this.prev(".product_number").val()) + parseInt(n));
                location.href = location.pathname + '?v='+GetVerNum();

                return true;
            }else{
				/* 失败信息*/
                layer.msg(json.msg,{icon:2,time:2000});
            }
        });
    });
	/* 默认设置加减状态 */
	function check_number ()
	{
		var product_number = $(".product_number");
		product_number.each(function(key,value){
			var n = $(value).val();
			console.log(n);
			if (n == 1)
			{
				$(value).prev(".product_jian").addClass("z-jiandis");
				console.log('welkin');
			}else{
				$(value).prev(".product_jian").removeClass("z-jiandis");
			}
		});
	}
	$(document).on('click','#a_payment',function(){
		location.href  = "/user/cart/pay";
	});




	/* 充值页面JS效果 */
});






