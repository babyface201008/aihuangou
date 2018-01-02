<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" v-for="n in news">
                <router-link :to="{name:'newDetail', params: { new_id: n.new_id } }" >
                <div class="panel-heading">
                    <img :src="n.thumb_pic" >
                </div>

                <div class="panel-body">
                    {{ n.title }}
                    <br>
                </div>
                </router-link>
            </div>
        </div>
    </div>
</div>
</template>
<script>
let URL_BASE = 'http://' + window.location.host + '/'
let U = window.location.href 
export default {
    data () {
        return {
            page : 1,
            justify : 1,
            news :[],
            srollPos : 0
        }
    },
    methods : {
        getAllNews(url,name){
            layer.msg('正在加载中………………',{time:200000,shade: [0.3, '#000']});
            return axios.get(URL_BASE + url)
            .then((res) => {
                this.justify = !this.justify
                console.log(this.justify)
                console.log(res.data)
                if(res.data.ret == 0)
                {
                    layer.closeAll();
                    let _this = this
                    let d = res.data.news.data
                    _this.news = _this.news.concat(d)
                  //  _this.news = d
                  //  $.each(d,function(key,value){
                  //      _this.news.push(value)
                  //  })
                    return "";
                }else{
                    return false;
                }
            });
        },
        getData(name) {
            return this.$data[name];
        },
        GetUrlRelativePath() {
            var url = document.location.toString();
    　　　　var arrUrl = url.split("//");
    　　　　var start = arrUrl[1].indexOf("/");
    　　　　var relUrl = arrUrl[1].substring(start);//stop省略，截取从start开始到结尾的所有字符
    　　　　if(relUrl.indexOf("?") != -1){
    　　　　　　relUrl = relUrl.split("?")[0];
    　　　　}
    　　　　return relUrl;
        },
        wstart() {
            let _this = this
            if (this.page == 1)
            {
                this.getAllNews('api/get/news?page='+this.page,'welkin')
            }else{}
            $(window).scroll(function(){  
                var srollPos = $(window).scrollTop()
                var totalheight = parseFloat($(window).height()) + parseFloat(srollPos);  
                var url = _this.GetUrlRelativePath()
                // console.log($(document).height());
                if (url !== '/#/') { return ""}
                if(($(document).height() - 55) <= totalheight && !_this.justify && (0 !== srollPos)) {  
                    _this.srollPos = srollPos
                    _this.page++
                    _this.getAllNews('api/get/news?page='+_this.page,'welkin')
                    _this.justify = !_this.justiry
                }else{}
            });   
        }
    },
    created: function() {
       
        this.wstart()
    }
}
</script>
