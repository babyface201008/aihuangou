<style scoped>
    .layout{
        border: 1px solid #d7dde4;
        background: #f5f7f9;
        position: relative;
        border-radius: 4px;
        overflow: hidden;
    }
    .layout-breadcrumb{
        padding: 10px 15px 0;
    }
    .layout-content{
        min-height: 200px;
        margin: 15px;
        overflow: hidden;
        background: #fff;
        border-radius: 4px;
    }
    .layout-content-main{
        padding: 10px;
    }
    .layout-copy{
        text-align: center;
        padding: 10px 0 20px;
        color: #9ea7b4;
    }
    .layout-menu-left{
        background: #464c5b;
    }
    .layout-header{
        height: 60px;
        background: #fff;
        box-shadow: 0 1px 1px rgba(0,0,0,.1);
    }
    .layout-logo-left{
        width: 90%;
        height: 30px;
        background: #5b6270;
        border-radius: 3px;
        margin: 15px auto;
    }
    .layout-ceiling-main a{
        color: #9ba7b5;
    }
    .layout-hide-text .layout-text{
        display: none;
    }
    .ivu-col{
        transition: width .2s ease-in-out;
    }
</style>
<template>
    <div class="layout" :class="{'layout-hide-text': spanLeft < 5}">
        <Row type="flex">
            <i-col :span="spanLeft" class="layout-menu-left">
                <Menu :updateActiveName="setActive" theme="dark" width="auto"  @on-select="routeTo">
                    <div class="layout-logo-left"></div>
                    <Menu-item name="article">
                  		<Icon type="document-text" :size="iconSize"></Icon>
                        <span class="layout-text">文章管理</span>
                    </Menu-item>
                    <Menu-item name="user">
                    	<Icon type="person-stalker" :size="iconSize"></Icon>
                    	<span class="layout-text">会员管理</span>
                    </Menu-item>
                    <Menu-item name="shop">
                    	<Icon type="home" :size="iconSize"></Icon>
                    	<span class="layout-text">店铺管理</span>
                    </Menu-item>
                    <Menu-item name="product">
                    	<Icon type="android-cart" :size="iconSize"></Icon>
                    	<span class="layout-text">商品管理</span>
                    </Menu-item>
                    <Menu-item name="order">
                    	<Icon type="clipboard" :size="iconSize"></Icon>
                    	<span class="layout-text">订单管理</span>
                    </Menu-item>
<!--                     <Submenu name="test">
                    	<template slot="title">
                    		<Icon type="ios-keypad"></Icon>
                    		多导航
                    	</template>
                    	<Menu-item name="test1">子导航</Menu-item>
                    	<Menu-item name="test2">子导航2</Menu-item>
                    </Submenu> -->
                    <Menu-item name="website">
                        <Icon type="android-settings" :size="iconSize"></Icon>
                        <span class="layout-text">网站设置</span>
                    </Menu-item>
                </Menu>
            </i-col>
            <i-col :span="spanRight">
                <div class="layout-breadcrumb">
                    <Breadcrumb>
                        <Breadcrumb-item><a href="/">首页</a></Breadcrumb-item>
                        <Breadcrumb-item v-for="breadcrumb in this.$store.state.route">
                        	<a :href="breadcrumb.href">{{ breadcrumb.title }}</a>
                        </Breadcrumb-item>
                    </Breadcrumb>
                </div>
                <div class="layout-content">
                    <div class="layout-content-main">
                    	<transition mode="out-in">
                    		<router-view></router-view>
                    	</transition>
                    </div>
                </div>
            </i-col>
        </Row>
    </div>
</template>
<script>
    export default {
        data () {
            return {
                spanLeft: 5,
                spanRight: 19,
                breadcrumbs : [
                ]
            }
        },
        computed: {
            iconSize () {
                return this.spanLeft === 5 ? 14 : 24;
            },
            setActive() {
              return this.$route.path.replace('/','');
            },
        },
        methods: {
            toggleClick () {
                if (this.spanLeft === 5) {
                    this.spanLeft = 2;
                    this.spanRight = 22;
                } else {
                    this.spanLeft = 5;
                    this.spanRight = 19;
                }
            },
            routeTo (e) {
            	// console.log(e);
            	this.$router.push(e);
            }
        },
        created() {
            console.log(this.$store.state.isAdmin);
        	if (this.$store.state.isAdmin == 1)
        	{
        		// 获取用户信息
        		let res = this.func.getAdminInfo(this.$store.state.adminId);
        		if (res.ret == 0)
        		{
        			this.$store.adminInfo = res.data;
        		}else{
        			alert('网络异常');
        		}
        	}else{
        		this.$router.push('/mcy/mcyLogin');
        	}
        	this.$store.dispatch('updateRoute',this.breadcrumbs);
            let w = this.$store.breadcrumbs = this.breadcrumbs ;
        }
    }
</script>
