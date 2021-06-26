<template>
  <div>
    <br />
      <h1 class="text-dark">{{user.username}}</h1>
          <div class="row">
            <div class="col">
              <div v-if="user!=null && user.username!=$root.user.username && $root.user.roles.includes('ROLE_USER')">
                <router-link :to="{ name: 'ChatUser', params: { username: user.username }}"><button class="btn btn-primary">Chat</button></router-link>
              </div>
            </div>
          </div>
        <div  v-if="this.loading == 1" class=" d-flex justify-content-center w-100 p-3">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only" ></span>
            </div>
        </div>
  </div> 
</template>

<script>

import Vue from 'vue'
import Navbar from './../Navbar.vue'
import BreadCrumb from './../BreadCrumb.vue'
export default {
    name: "UserProfile",
    components: {
    },
    created () {
    },
    data () { 
        return {
            loading:1,
            user:null,
        }
    },
    computed: {
    },
    mounted() {
            this.load();
    },
    methods: {
      click() {
        this.$root.$emit(
          'openChat',this.user
        );
      },
        isLoading() {
            return this.loading;
        },
      load() {
        var headers={'Content-Type': 'application/json',};
        if (Vue.$cookies.get("Bearer")!=null) {
            headers.Authorization = "Bearer " + Vue.$cookies.get("Bearer");
        }
        axios
            .get('/api/users/'+this.$route.params.username +'.json',{
                headers
            })
        .then(response => (this.user=response.data,this.loading=0)).catch(error=>(this.load()));
      }
    },
};
</script>
