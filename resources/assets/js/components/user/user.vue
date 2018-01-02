<template>
   <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="article" >
                welkin <br>
                welkin <br>
                welkin <br>

                {{ userid }} <br>

                welkin <br>
                welkin <br>

                welkin <br>
                welkin <br>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props : {
      userid : { type: String, default : 0}
    },
    data () {
        return {
            container: 'blue',
            username : 'welkin.firesky',
            userimg  : '/images/test.jpg',
            userinfo : 'userinfo'
        }
    }
}
</script>
