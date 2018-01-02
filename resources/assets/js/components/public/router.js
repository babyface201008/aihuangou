import Vue from 'vue'
import Vuex from 'vuex'
// iviewUI
import iView from 'iview'
import 'iview/dist/styles/iview.css'

// import App from '../index/index.vue'
import Index from '../index/index.vue'
import VueRouter from 'vue-router'
import newsList from '../news/newsList.vue'
import newDetail from '../news/newDetail.vue'
// import store from '../public/store.js'
// import userLogin from '../user/userLogin.vue'
// import userSignin from '../user/userSignin.vue'
// import user from '../user/user.vue'
// import userProfile from '../user/userProfile.vue'
// import userArticleList from '../user/userArticleList.vue'
// import userArticle from '../user/userArticle.vue'
import func from '../public/func.js'
// 全局函数
Vue.prototype.func = func
// import Const from '../public/const.js'
/* 导航时间戳 */
// import timeline from '../timeline.vue'
// import jp from '../jp.vue'
// import pic from '../pic.vue'
// import mz from '../mz.vue'
// import twitter from '../twitter.vue'
// import carousel from '../shop/carousel.vue'
// 活动组件
import richang from '../activity/richang.vue'
import lygg from '../activity/lygg.vue'
import mxqf from '../activity/mxqf.vue'

/* 后台接口 */
import mcyLogin from '../mcy/mcyLogin.vue'
import mcy from '../mcy/mcy.vue'
import mcyUser from '../mcy/mcyUser.vue'
import mcyTopNav from '../mcy/mcyTopNav.vue'
import mcyArticle from '../mcy/mcyArticle.vue'
import mcyShop from '../mcy/mcyShop.vue'
import mcyProduct from '../mcy/mcyProduct.vue'
import mcyOrder from '../mcy/mcyOrder.vue'
import mcyWebsite from '../mcy/mcyWebsite.vue'
// 创建一个路由器实例
// 并且配置路由规则
const router = new VueRouter({
  // mode: 'history',
  base: __dirname,
  routes: [

    // Home page && Test Page
    { path: '/', name: 'home',component:Index,props:true},
    { path: '/news', name: 'newsList', component: newsList,props:true },
    { path: '/new/:new_id', name: 'newDetail', component: newDetail,props:true},

    // 个人中心
    // { path: '/user', name: 'user', component:user,props:true,},
    // { path: '/user/profile', name: 'userProfile', component: userProfile },
    // { path: '/user/:userid/articleList', name: 'userArticleList', component: userArticleList,props:true },
    // { path: '/user/:userid/article/:articleid', name: 'userArticle', component: userArticle,props:true },

    // 导航时间戳
    // { path: '/timeline',name:'timeline',component: timeline,props:true},
    // { path: '/jp',name:'jp',component: jp,props:true},
    // { path: '/pic',name:'pic',component: pic,props:true},
    // { path: '/mz',name:'mz',component: mz,props:true},
    // { path: '/twitter',name:'twitter',component: twitter,props:true},

    // 用户登录
    // { path: '/user/login',name:'userLogin',component: userLogin,props:true},
    // { path: '/user/signin',name:'userSignin',component: userSignin,props:true},

    { path: '/mcy/mcyLogin',name:'mcyLogin',component:mcyLogin,props:true},

    // 后台管理
    { path: '/mcy',name: 'mcy',component:mcy,porps:true,
        children : [
            { path: '/user',name: 'mcyUser',component:mcyUser,props:true}, //会员管理
            { path: '/article',name: 'mcyArticle',component:mcyArticle,props:true}, //文章管理
            { path: '/shop',name: 'mcyShop',component:mcyShop,props:true}, //店铺管理
            { path: '/product',name: 'mcyProduct',component:mcyProduct,props:true}, //商品管理
            { path: '/order',name: 'mcyOrder',component:mcyOrder,props:true}, //订单管理
            { path: '/website',name: 'mcyWebsite',component:mcyWebsite,props:true}, //站点管理
        ]
    },

    // 活动项目
    { path: '/richang',name:'richang',component:richang,props:true },
    { path: '/lygg',name:'lygg',component:lygg,props:true },
    { path: '/mxqf',name:'mxqf',component:mxqf,props:true },
  ]
})
Vue.use(VueRouter)
Vue.use(iView)

export default router