<template>
	<div class="header">
		<div class="title_name" @click="">梦苍源</div>
		<transition-group 
			name="navlist"
            class="sub_nav"
			>
			<div class="sub_nav_title" v-if="!show"  v-for="nav in navs" v-bind:key="nav"> 
				<li><a :href="nav.nav_href" >{{ nav.nav_title }}</a></li>
			</div>
		</transition-group>
	</div>
</template>

<script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.min.js"></script>
<script>
    export default {
    	data () {
    		return {
    			show : 1,
    			navs : [
    				{ nav_title: '首页',nav_href: '/#/'},
    				// { nav_title: '日志',nav_href: '/log'},
    				{ nav_title: '趣闻',nav_href: '/#/news'},
    				{ nav_title: '11区',nav_href: '/#/jp'},
    				{ nav_title: '漫图',nav_href: '/#/pic'},
    				{ nav_title: '漫展',nav_href: '/#/mz'},
    			]
    		}
    	},
    	methods: {
    		shownav () {
                this.show=!this.show
                // $(".title_name").click();
    		}
    	}
    }
</script>
<style type="text/css">	
	.fade-enter-active, .fade-leave-active {
		transition: opacity .5s
	}
	.fade-enter, .fade-leave-active {
		opacity: 0
	}
</style>