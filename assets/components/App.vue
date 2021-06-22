<template>
  <div class="h-100">
        <router-view>
          <Auth v-if="unauthenticated"/>
          <Board v-if="authenticated" />
        </router-view>
  </div> 
</template>

<script>
import Vue from 'vue'
import Auth from './Auth';
import Board from './Board';
export default {
    name: "App",
    components: {
        Auth,
        Board
    },
    data () { 
        return {
            unauthenticated:false,
            authenticated:false,
            user:null,
            token:null,
            slide: 0,
            sliding: null
        }
    },
    created () {
        this.extractToken();
    },
    mounted() {
        this.$root.$on('userAuthenticated', () => {
            this.extractToken();
        })
    },
    computed: {
    },

    methods: {
        
      onSlideStart(slide) {
        this.sliding = true
      },
      onSlideEnd(slide) {
        this.sliding = false
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
            console.log(val);
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
};
</script>
