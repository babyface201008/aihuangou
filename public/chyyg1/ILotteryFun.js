function newest_lottery_show_Time_fun(times,obj,uhtml){
	time = times - (new Date().getTime());
	i =  parseInt((time/1000)/60);
	s =  parseInt((time/1000)%60);
	ms =  String(Math.floor(time%1000));
	ms = parseInt(ms.substr(0,2));
	if(i<10)i='0'+i;
	if(s<10)s='0'+s;
	if(ms<0)ms='00';
	//g=obj.find("em");
	//g.eq(0).html(s);
	//g.eq(1).html(ms);	
	obj.find('.second').html(s);
	obj.find('.millisecond').html(ms);
	if(time<=0){
		obj.removeClass('countdown');
		obj.html('<p style="color:#dc332d;font-size:12px;font-weight:bold;width:100%;text-indent:10px;">正在计算...</p>');
		setTimeout(function(){
			obj.parent().html(uhtml);						
		},1000);							 
		return;						
	}
	else{
		setTimeout(function(){										 	
			newest_lottery_show_Time_fun(times,obj,uhtml);				 
		},30); 
	}

}

$.fn.newest_lottery_show_time_init=function(path,info){
	s=$(this);
	var uhtml = '';
	uhtml+='<p class="obtain">获得者：<a href="'+path+'/userinfo/'+info.mcy_user_id+'" class="blue z-user">';
	uhtml+=info.username+'</a></p>';	
	
	info.times = (new Date().getTime())+(parseInt(info.times))*1000;
	newest_lottery_show_Time_fun(info.times,s,uhtml);	
}