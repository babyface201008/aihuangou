<template>
	<div class="mcyProduct">
	</div>
</template>

<script>
	export default {
		data () {
			return {
				breadcrumbs : [
					{ title : '产品管理',href:'/#/article'},
				]
			}
		},
		methods: {

		},
		created () {
			this.$store.dispatch('updateRoute',this.breadcrumbs);
		}
	}
</script>