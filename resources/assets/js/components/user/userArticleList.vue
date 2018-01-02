<template>
 <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="article" >
                fireskyt <br>
                fireskyt <br>
                fireskyt <br>
                fireskyt <br>
                fireskyt <br>
                fireskyt <br>
                fireskyt <br>
                fireskyt <br>
                fireskyt <br>
                fireskyt {{ userid }} <br>
                fireskyt <br>
                fireskyt <br>
                fireskyt <br>
                fireskyt <br>
            </div>
        </div>
    </div>
</div>
</template>
<script type="text/javascript">
export default {
      props : {
          userid : { type: String, default : 0}
      },
      data () {
        return {
            test : "fireskyt",
        }
      },
      methods : {
      },
      created () {
        this.info(false)
        // this.func.notice('info','welkin','googld');
        console.log('test');
      },
      computed () {
        console.log('file ')
        if (this.userid == 1)
        {
            this.$Notice.info({
                title: '这是通知标题',
                desc: nodesc ? '' : '这里是通知描述这里,是通知描述这里是通知描述这里,是通知描述这里,是通知描述这里是通知描述这里是通知描述'
            });
        }
      }
}
</script>