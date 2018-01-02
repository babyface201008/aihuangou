<template>
	<div class="mcyUser">
		
	</div>
</template>

<script>
	export default {
		data () {
			return {
				breadcrumbs: [
					{ title : '用户管理',href: '/#/user'},
				]
			}
		},
		created() {
			this.$store.dispatch('updateRoute',this.breadcrumbs);
		}
	}
</script>