<template>
	<div class="wfooter">
		<div class="wfooter-nav" @click="wgo('richang')">
            <div class="wfooter-img icon-blue"><Icon type="android-apps"></Icon></div>       
            <div class="wfooter-title">苍源日常</div>
        </div>
        <div class="wfooter-nav" @click="wgo('lygg')">
            <div class="wfooter-img icon-green"><Icon type="leaf"></Icon></div>       
            <div class="wfooter-title">落叶归根</div>
        </div>
        <div class="wfooter-nav" @click="wgo('mxqf')">
        <div class="wfooter-img icon-go"><Icon type="paper-airplane"></Icon></div>       
            <div class="wfooter-title">梦想起飞</div>
        </div>
        <div class="wfooter-nav" @click="wgo('user')">
            <div class="wfooter-img"><Icon type="person"></Icon></div>       
            <div class="wfooter-title">个人中心</div>
        </div>
	</div>
</template>
<script>
    export default {
    	data () {
    		return {
    		}
    	},
    	methods: {
            wgo(name,params){
                this.$router.push({name:name, params: params});
            }
    	},
        created () {
        }
    }
</script>

