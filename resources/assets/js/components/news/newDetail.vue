<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="article" >
                  <div class="article-title" v-html="n.title">
                    {{ n.title }}
                  </div>
                  <div class="article-author" v-html="n.author">
                   {{ n.author }}
                  </div>
                    <div class="article-content" v-html="n.content">
                      {{ n.content }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
let URL_BASE = 'http://' + window.location.host + '/'
    export default {
      props : {
          new_id : { type: String, default : 0}
      },
      data () {
        return {
        	n: {
            content: "",
            title : "",
            author : ""
          }
        }
      },
      methods : {
        getNew(url,name){
          layer.msg('正在加载中………………',{time:200000,shade: [0.3, '#000']});
          return axios.get(URL_BASE + url)
          .then((res) => {
            if(res.data.ret == 0)
            {
              layer.closeAll()
              let _this = this
              _this.n = res.data.new
              return ""
            }else{
              layer.closeAll()
              layer.msg('文章被小苍吃了！！！')
              setTimeout(function(){
                history.go(-1)
              },500)
              // $(window).setTimeOut(history.go(-1),2000)
              // history.go(-1)
              return false
            }
          });
        },
        getData(name) {
          return this.$data[name];
        },
        sdstart() {
          this.getNew('api/get/new/'+this.new_id,'welkin')
        }
      },
      mounted: function() {
         this.sdstart()
      }
  
    }
</script>
