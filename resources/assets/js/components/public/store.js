import Vue from 'vue'
import Vuex from 'vuex'
import createPersist from 'vuex-localstorage'
Vue.use(Vuex)

const store = new Vuex.Store({
     plugins: [createPersist({
        namespace: 'namespace-for-state',
        initialState: {},
        expires: 7 * 24 * 60 * 60 * 1e3,
      })],
    state: {
    	isAdmin:0,
    	isUser:0,
        route: {},
        shop:{},
        member:{},
        order:{},
        setting:{},
        article:{},
        temp:{},
        userInfo:{},
        adminInfo:{},
    },
    mutations: {
    	updateRoute(state,val){ state.route = val },
    	updateShop(state,val){ state.shop = val },
    	updateMember(state,val){ state.member = val },
    	updateOrder(state,val){ state.order = val },
    	updateSetting(state,val){ state.setting = val },
    	updateArticle(state,val){ state.article = val },
    	updateTemp(state,val){ state.temp = val },
    	updateUserInfo(state,val){ state.userInfo = val },
        updateAdminInfo(state,val){ state.adminInfo = val },
        updateIsUser(state,val){ state.isUser = val },
        updateIsAdmin(state,val){ state.isAdmin = val },
    },
    actions: {
    	updateRoute(context,val){ context.commit('updateRoute',val) },
    	updateShop(context,val){ context.commit('updateShop',val) },
    	updateMember(context,val){ context.commit('updateMember',val) },
    	updateSetting(context,val){ context.commit('updateSetting',val) },
    	updateArticle(context,val){ context.commit('updateArticle',val) },
    	updateAdminInfo(context,val){ context.commit('updateAdminInfo',val) },
        updateUserInfo(context,val){ context.commit('updateUserInfo',val) },
        updateIsUser(context,val){ context.commit('updateIsUser',val) },
    	updateIsAdmin(context,val){ context.commit('updateIsAdmin',val) },
    }
})

export default store