$(function(){var a=function(){var d=function(r){$.PageDialog.fail(r)};var f=function(s,r){$.PageDialog.ok(s,r)};var c=false;var q=new Object();var o=function(s,t,r){if(q["area_"+t]!=null&&typeof(q["area_"+t])!="undefined"){r(s,q["area_"+t])}else{$.ajax({type:"get",url:"/JPData",data:"action=getAreaChildNodes&areaID="+t,async:true,success:function(u){if(u.code==0){r(s,u.str);q["area_"+t]=u.str}else{if(u.code==1){r(null,null)}}},dataType:"json"})}};var m={oldUserName:"",userName:"",userPhone:"",userSex:"",userBirthDay:"",userLiveArea:"",liveAreaName:"",userBirthArea:"",birthAreaName:"",userSign:"",column:""};var h=function(s){var r={action:"updateUserTo",oldUserName:m.oldUserName,userName:m.userName,userPhone:m.userPhone,userSex:m.userSex,userBirthDay:m.userBirthDay,userLiveArea:m.userLiveArea,liveAreaName:m.liveAreaName,userBirthArea:m.userBirthArea,birthAreaName:m.birthAreaName,userSign:m.userSign,column:m.column};$.post(Gobal.WxDomain+"/JPData",r,function(t){var u=t.code;if(u==0){f("保存成功",function(){location.href="memberinfo.do"})}else{if(u==1){var v=t.num;if(v==-2||v==-9){d("昵称已存在")}else{if(v==-4||v==-5){d("签名不符合网站规范")}else{d("保存失败["+v+"]")}}}else{if(u==10){location.reload()}else{if(u==-4){d("昵称不符合规则")}else{if(u==-5){d("签名不符合网站规范")}else{d("保存失败,请重试["+u+"]")}}}}}c=false;s.html("保存").removeClass("grayBtn")},"json")};var i=function(s){var r=/^[\u4e00-\u9fa5]+$/;return r.test(s)};var e=parseInt($("#hidFlag").val());if(e==1){$("#btnT1").bind("click",function(){if(c){return}var s=function(v){var w=/^[a-zA-Z0-9_\u4e00-\u9fa5\-]{2,20}$/;return w.test(v)};var u=$("#txtUserName").val();if(u==""){d("昵称不能为空！");return}else{if(!s(u)){d("昵称不规范！");return}else{var t=0;for(var r=0;r<u.length;r++){if(i(u[r])){t+=2}else{t+=1}}if(t>20){d("昵称超过20个字符，删除一些吧！");return}}}m.column="userName";m.oldUserName=$("#hidOldName").val();m.userName=u;c=true;$(this).html('正在保存<span class="dotting"></span>').addClass("grayBtn");h($(this))})}else{if(e==4){$("#btnT4").bind("click",function(){if(c){return}var s=function(u){var t=/(^[0-9]{7,8}$)|(^[0-9]{3,4}\-[0-9]{7,8}$)|(^[0-9]{7,8}$)|(^\([0-9]{3,4}\)[0-9]{3,8}$)|(^0{0,1}1[0-9]{10}$)/;return t.test(u)};var r=$("#txtPhone").val();if(r!=""&&!s(r)){d("请输入正确的电话号码！");return}m.column="userPhone";m.userPhone=r;c=true;$(this).html('正在保存<span class="dotting"></span>').addClass("grayBtn");h($(this))})}else{if(e==5){var n=parseInt($("#hidLiveA").val());var k=parseInt($("#hidLiveB").val());var b=$("#selProvince5");var l=$("#selCity5");var g;var p="";var j=function(v,r){if(r!=null){var u=r.regions;var s=u.length;if(s>0){v.prev().prev().html("--请选择--");v.empty().append('<option value="0" selected="selected">--请选择--</option>');for(var t=0;t<s;t++){var w='<option value="'+u[t].id+'">'+u[t].name+"</option>";v.append(w)}if(v.attr("id")=="selProvince5"){v.bind("change",function(){n=parseInt($(this).val());k=0;g=v.find("option[value='"+n+"']");if(g.length>0){g.attr("selected","selected").siblings().removeAttr("selected");p=g.text();v.prev().prev().html(p)}if(n>0){o(l,n,j)}else{l.prev().prev().html("--请选择--");l.empty()}});if(n>0){g=v.find("option[value='"+n+"']");if(g.length>0){g.attr("selected","true").siblings().removeAttr("selected");p=g.text();v.prev().prev().html(p)}o(l,n,j)}}else{if(v.attr("id")=="selCity5"){v.bind("change",function(){k=parseInt($(this).val());g=v.find("option[value='"+k+"']");if(g.length>0){g.attr("selected","selected").siblings().removeAttr("selected");p=g.text();v.prev().prev().html(p)}});if(k>0){g=v.find("option[value='"+k+"']");if(g.length>0){g.attr("selected","selected").siblings().removeAttr("selected");p=g.text();v.prev().prev().html(p)}}}}}}};o(b,1,j);$("#btnT5").bind("click",function(){if(c){return}var u=b.find("option[selected='selected']");var t=l.find("option[selected='selected']");var s=u.text();var x=parseInt(u.attr("value"));var r=t.text();var w=parseInt(t.attr("value"));if(x>0&&w==0){d("请选择现居地所在市！");return}var y="";var v=0;if(w>0&&s!=""&&r!=""){v=w;y=s+" "+r}m.column="userLiveArea";m.userLiveArea=v;m.liveAreaName=y;c=true;$(this).html('正在保存<span class="dotting"></span>').addClass("grayBtn");h($(this))})}else{if(e==6){var n=parseInt($("#hidHomeA").val());var k=parseInt($("#hidHomeB").val());var b=$("#selProvince6");var l=$("#selCity6");var g;var p="";var j=function(v,r){if(r!=null){var u=r.regions;var s=u.length;if(s>0){v.prev().prev().html("--请选择--");v.empty().append('<option value="0" selected="selected">--请选择--</option>');for(var t=0;t<s;t++){var w='<option value="'+u[t].id+'">'+u[t].name+"</option>";v.append(w)}if(v.attr("id")=="selProvince6"){v.bind("change",function(){n=parseInt($(this).val());k=0;g=v.find("option[value='"+n+"']");if(g.length>0){g.attr("selected","selected").siblings().removeAttr("selected");p=g.text();v.prev().prev().html(p)}if(n>0){o(l,n,j)}else{l.prev().prev().html("--请选择--");l.empty()}});if(n>0){g=v.find("option[value='"+n+"']");if(g.length>0){g.attr("selected","selected").siblings().removeAttr("selected");p=g.text();v.prev().prev().html(p)}o(l,n,j)}}else{if(v.attr("id")=="selCity6"){v.bind("change",function(){k=parseInt($(this).val());g=v.find("option[value='"+k+"']");if(g.length>0){g.attr("selected","selected").siblings().removeAttr("selected");p=g.text();v.prev().prev().html(p)}});if(k>0){g=v.find("option[value='"+k+"']");if(g.length>0){g.attr("selected","selected").siblings().removeAttr("selected");p=g.text();v.prev().prev().html(p)}}}}}}};o(b,1,j);$("#btnT6").bind("click",function(){if(c){return}var u=b.find("option[selected='selected']");var t=l.find("option[selected='selected']");var s=u.text();var w=parseInt(u.attr("value"));var r=t.text();var v=parseInt(t.attr("value"));if(w>0&&v==0){d("请选择家乡所在市！");return}var y="";var x=0;if(v>0&&s!=""&&r!=""){x=v;y=s+" "+r}m.column="userBirthArea";m.userBirthArea=x;m.birthAreaName=y;c=true;$(this).html('正在保存<span class="dotting"></span>').addClass("grayBtn");h($(this))})}else{if(e==7){$("#btnT7").bind("click",function(){if(c){return}var t=$("#txtSign").val();if(t!=""){var s=0;for(var r=0;r<t.length;r++){if(i(t[r])){s+=2}else{s+=1}}if(s>200){d("签名超过200个字符，删除一些吧！");return}}m.column="userSign";m.userSign=t;c=true;$(this).html('正在保存<span class="dotting"></span>').addClass("grayBtn");h($(this))})}}}}}};Base.getScript(Gobal.Skin+"/JS/pageDialog.js?v=160304",a)});