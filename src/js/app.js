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

// Init Framework7-Vue Plugin
Framework7.use(Framework7Vue);
Vue.use(Vuex)
Vue.use(vueResource)

const store = new Vuex.Store({
  plugins: [createPersistedState()],
  modules: {
    application: {
      //namespaced: true,
      state: {
        title: 'Grupo K',
        drawer: {
          left: false,
          right: false,
          login: true,
        },
        config: {
          api: 'https://www.appcongresonorvet.com/api/',
        },
        user: {
          age: null,
          city: null,
          created_at: null,
          folio: null,
          id: null,
          name: null,
          title: null,
          type: null,
          updated_at: null,
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
  // Register App Component
  components: {
    app: App
  },
});
