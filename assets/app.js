/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

import Vue from 'vue';
import VueRouter from 'vue-router'
import Auth from './components/Auth.vue'
import Board from './components/Board'
import BoardCategory from './components/BoardCategory'
import BoardTopic from './components/BoardTopic'
Vue.use(VueRouter)
const router = new VueRouter({  
    mode:'history',
    routes: [
        { 
                name: "Auth",
                path: '/auth', 
                component:  Auth,
                props: true,
        },
        { 
                name: "Board",
                path: '/board', 
                component:  Board,
                props: true,
        },
        { 
                name: "BoardCategory",
                path: '/board/:categoryId', 
                component:  BoardCategory,
                props: true,
        },
        { 
                name: "BoardTopic",
                path: '/board/:categoryId/:topicId', 
                component:  BoardTopic,
                props: true,
        },
    ]
});
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
import VueCookies from 'vue-cookies'
Vue.use(VueCookies)
import VueCardCarousel from "vue-card-carousel";
window.axios = require('axios');
Vue.use(VueCardCarousel)
Vue.$cookies.config('3600s')

import axios from 'axios'
import VueAxios from 'vue-axios'
Vue.use(VueAxios, axios)

import App from './components/App';
import { library } from '@fortawesome/fontawesome-svg-core'
import { faUserSecret } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faUserSecret)

Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.config.productionTip = false
new Vue({
    el: '#app',
    data: {
        unauthenticated:false,
        authenticated:false,
        token:null,
        user: null
    },
    render: h => h(App),
    router: router,
    created () {
        this.extractToken();
    },
    mounted() {
        this.$on('userAuthenticated', () => {
            this.extractToken();
        })
    },
    methods: {
          extractToken() {
              this.token = Vue.$cookies.get("Bearer");
              if (this.token==null) {
                  this.setAuthenticated(false)
                  return false;
              } 
  
              axios
                  .get('/api/me',{
                      headers: {
                          'Content-Type': 'application/json',
                          "Authorization": "Bearer " + this.token
                      }
                  })
              .then(response => (this.user=response.data,this.setAuthenticated())).catch(error=>(this.setAuthenticated(false)));
        
          },
          setAuthenticated(val=true) {
              this.authenticated=val;
              this.unauthenticated=!val;
              if (val) {
                  this.$router.push({ name: 'Board'})
              } else {
                  this.$router.push({ name: 'Auth'})
              }
          },
          logout() {
              Vue.$cookies.remove("User");
              Vue.$cookies.remove("Bearer");
              this.token = null;
              this.user = null;
              this.setAuthenticated(false)
          }
      },
});