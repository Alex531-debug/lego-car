import Vue from 'vue';
import Vuex from 'vuex';
import VueRouter from "vue-router";
import App from './js/components/app/App.vue';
import Home from './js/components/home/Home.vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'font-awesome/css/font-awesome.css';
import routes from './js/router/index';
import vuexModules from './js/store/modules';
Vue.config.productionTip = false;

Vue.use(Vuex);
Vue.use(VueRouter);

const store = new Vuex.Store({
    modules: {
        ...vuexModules
    }
});

const router = new VueRouter({
    routes : [
        ...routes
    ]
});

const app = new Vue({
    el:'#app',
    store: store,
    router: router,
    render: h => h(App),
})

export default app;

