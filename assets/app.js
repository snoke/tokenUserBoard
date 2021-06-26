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
import Chat from './components/Chat/Chat.vue'
import ChatUser from './components/Chat/ChatUser.vue'
import App from './components/App.vue'
import Auth from './components/Auth/Auth.vue'
import Login from './components/Auth/Login.vue'
import Logout from './components/Auth/Logout.vue'
import Register from './components/Auth/Register.vue'
import Board from './components/Board/Board'
import BoardCategory from './components/Board/BoardCategory'
import BoardTopic from './components/Board/BoardTopic'
import PostForm from './components/Board/Form/PostForm'
import TopicForm from './components/Board/Form/TopicForm'
import UserProfile from './components/User/UserProfile'
import User from './components/User/User'
import Test from './components/Test'
Vue.use(VueRouter)
const router = new VueRouter({  
    mode:'history',
    routes: [
        { 
            name: "Board",
            path: '/Board', 
            component:  Board,
            props: true,
            children: [
                { 
                        name: "BoardCategory",
                        path: '/Board/:categoryId', 
                        component:  BoardCategory,
                        props: true,
                        children: [
                            { 
                                    name: "BoardTopic",
                                    path: '/Board/:categoryId/:topicId', 
                                    component:  BoardTopic,
                                    props: true,
                                    children:[
                                        { 
                                            name: "BoardTopicEdit",
                                            path: '/Board/:categoryId/:topicId/edit', 
                                            component:  TopicForm,
                                            props: true,
                                         },
                                        
                                        { 
                                            name: "BoardPostEdit",
                                            path: '/Board/:categoryId/:topicId/:postId/edit', 
                                            component:  PostForm,
                                            props: true,
                                         },
                                    ]
                            },
                        ]
                },
            ]
        },
        { 
            name: "Auth",
            path: '/Auth', 
            component:  Auth,
            props: true,
            children: [
                { 
                        name: "Register",
                        path: '/Auth/Register', 
                        component:  Register,
                        props: true,
                },
                { 
                        name: "Login",
                        path: '/Auth/Login', 
                        component:  Login,
                        props: true,
                },
                { 
                        name: "Logout",
                        path: '/Auth/Logout', 
                        component:  Logout,
                        props: true,
                },
            ]
        },
        { 
            name: "Chat",
            path: '/Chat', 
            component:  Chat,
            props: true,
        },
        { 
            name: "ChatUser",
            path: '/Chat/:username', 
            component:  ChatUser,
            props: true,
        },
        { 
            name: "User",
            path: '/User', 
            component:  User,
            props: true,
            children: [
                { 
                        name: "UserProfile",
                        path: '/User/:username', 
                        component:  UserProfile,
                        props: true,
                },
            ]
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
        user: {username:'Anonymous',roles:['ROLE_GUEST']}
    },
    render: h => h(App),
    router: router,
    created () {
        this.extractToken();
    },
    mounted() {
        axios.interceptors.response.use(response => {
                return response;
             }, error => {
               if (error.response.status === 401) {
                this.logout();
               }
               return error;
             });
        this.$on('userAuthenticated', () => {
            this.extractToken();
        })
    },
    methods: {
            getNow() {
                const today = new Date();
                const date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                const time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                const dateTime = date +' '+ time;
                return dateTime;
            },
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
                  //this.$router.push({ name: 'Board'})
              }  
              else {
               //         this.$router.go()
                  //this.$router.push({ name: 'Board'})
              }
          },
          logout() {
              Vue.$cookies.remove("User");
              Vue.$cookies.remove("Bearer");
              this.token = null;
              this.user= {username:'Anonymous',roles:['ROLE_GUEST']}
              this.setAuthenticated(false)
          }
      },
});
