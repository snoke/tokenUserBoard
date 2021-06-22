<template>
  <div class="h-100">

          <LoginOrRegister v-if="unauthenticated"/>
          <Board v-if="authenticated" />
  </div> 
</template>

<script>
import Vue from 'vue'
import LoginOrRegister from './LoginOrRegister';
import Board from './Board';
export default {
    name: "App",
    components: {
        LoginOrRegister,
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
