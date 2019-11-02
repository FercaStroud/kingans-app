import Vue from 'vue';
import Framework7 from 'framework7/framework7.esm.bundle.js';
import Framework7Vue from 'framework7-vue/framework7-vue.esm.bundle.js';
import 'framework7/css/framework7.bundle.css';
import '../css/icons.css';
import '../css/app.scss';

import App from '../components/app.vue';
import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";
import Ripple from "vue-ripple-directive";
import vueResource from 'vue-resource'
import VueApexCharts from 'vue-apexcharts'


Framework7.use(Framework7Vue);
Vue.use(Vuex)
Vue.use(vueResource)
Vue.use(VueApexCharts)
Vue.component('apexchart', VueApexCharts)

Ripple.color = 'rgba(241, 105, 137, .35)';
Ripple.zIndex = 55;
Vue.directive('ripple', Ripple);

const store = new Vuex.Store({
    plugins: [createPersistedState()],
    modules: {
        application: {
            namespaced: true,
            state: {
                title: 'Panel - Kingans',
                drawer: {
                    left: false,
                    right: false,
                    codes: false,
                    dashboard: false,
                    login: true,
                },
                config: {
                    //api: 'http://kingans.com/api/',
                    api: 'http://localhost:8000/',
                },
                user: {
                    id: null,
                    branch_id: null,
                    username: null,
                    type: null,
                    name: null,
                },
            },
            mutations: {
                setLogin: (state, payload) => {
                    state.drawer.login = payload
                },
                resetLogin: state => {
                    state.drawer.login = true
                },
            },
            getters: {}
        },
    }
})


// Init App
new Vue({
    el: '#app',
    store,
    render: (h) => h(App),
    components: {
        app: App
    },
});