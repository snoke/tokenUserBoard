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

new Vue({
    el: '#app',
    render: h => h(App),
    router: router,
});