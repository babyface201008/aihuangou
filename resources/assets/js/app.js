
/**
 * First we will load all of this project's JavaScript dependencies which
,* includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


// Store
import store from './components/public/store.js'
import router from './components/public/router.js'

// 图表BD EChart V3
// import IEcharts from 'vue-echarts-v3/src/full.vue';
// Test Vue
// import test from './components/test/test.vue'



// Vue.use(ElementUI)

const app = new Vue({
    router:router,
	store:store,
}).$mount('#app');
// const app = new Vue({
// 	router:router,
// 	render:h => h(App)
// });
