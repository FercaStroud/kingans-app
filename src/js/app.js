// Import Vue
import Vue from 'vue';

// Import Framework7
import Framework7 from 'framework7/framework7.esm.bundle.js';
import Framework7Vue from 'framework7-vue/framework7-vue.esm.bundle.js';
import 'framework7/css/framework7.bundle.css';
import '../css/icons.css';
import '../css/app.scss';

// Import App Component
import App from '../components/app.vue';
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import vueResource from 'vue-resource'
import Ripple from 'vue-ripple-directive'

// Init Framework7-Vue Plugin
Framework7.use(Framework7Vue);
Vue.use(Vuex)
Vue.use(vueResource)

Ripple.color = 'rgba(241, 105, 137, .35)';
Ripple.zIndex = 55;
Vue.directive('ripple', Ripple);

const store = new Vuex.Store({
    plugins: [createPersistedState()],
    modules: {
        application: {
            //namespaced: true,
            state: {
                title: 'Grupo Kingans',
                drawer: {
                    left: false,
                    right: false,
                    login: true,
                },
                config: {
                    api: 'http://kingans.com/api/',
                    //api: 'http://localhost:8000/',
                },
                survey: false,
                visits: null,
                user: {
                    created_at: null,
                    updated_at: null,
                    phone: '',
                    name: '',
                    email: '',
                    city: '',
                    gender: '',
                    birthday: '',
                },
            },
            mutations: {
                setLogin: (state, payload) => {
                    state.drawer.login = payload
                },
                resetLogin: state => {
                    state.drawer.login = true;
                    state.survey = false;

                    state.user = {
                        created_at: null,
                        updated_at: null,
                        phone: '',
                        name: '',
                        email: '',
                        city: '',
                        gender: '',
                        birthday: '',
                    }
                },
                setUser: (state, payload) => {
                    state.user = payload
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
    // Register App Component
    components: {
        app: App
    },
});
