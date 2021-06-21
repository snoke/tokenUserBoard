<template>
  <div class="h-100">
    <b-carousel
      id="carousel-1"
      v-model="slide"
      :interval="0"
      controls
      indicators
      background="#ababab"
      @sliding-start="onSlideStart"
      @sliding-end="onSlideEnd"
      class="main_carousel h-100"
    >

      <!-- -->
      <b-carousel-slide>
        <template #img>
            <div class="main_carousel_slide_container d-flex justify-content-center">
                <div class="jumbotron">
                    <div class="card">
                        <div class="card-body">Board</div>
                    </div>
                </div>
            </div>
        </template>
      </b-carousel-slide>
      <!-- -->
      <b-carousel-slide>
        <template #img>
            <div class="main_carousel_slide_container d-flex justify-content-center">
                <div class="jumbotron">
                    <div class="card">
                        <div class="card-body">Chat</div>
                    </div>
                </div>
            </div>
        </template>
      </b-carousel-slide>
      <!-- -->
      <b-carousel-slide>
        <template #img>
            <div class="main_carousel_slide_container d-flex justify-content-center">
                <div class="jumbotron">
                    <div class="card">
                        <div class="card-body">Settings</div>
                    </div>
                </div>
            </div>
        </template>
      </b-carousel-slide>

    </b-carousel>

      <!--
      <div v-if="unauthenticated" >
          <LoginOrRegister />
      </div>
      <div v-if="authenticated" >
          <Board />
          <a   @click="logout">Logout</a>
      </div>
      -->
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
