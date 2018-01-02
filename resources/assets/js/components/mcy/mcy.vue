

<template>
	<div class="mcy">
		<mcyTopNav></mcyTopNav>
		<mcyContent></mcyContent>
		<mcyFooter></mcyFooter>
	</div>
</template>

<script>
	import mcyTopNav from '../mcy/mcyTopNav.vue'
	import mcyContent from '../mcy/mcyContent.vue'
	import mcyFooter from '../mcy/mcyFooter.vue'
	export default {
		data () {
			return {

			}
		},
		components: {
            mcyTopNav: mcyTopNav,
            mcyContent: mcyContent,
            mcyFooter: mcyFooter
        }
	}
</script>