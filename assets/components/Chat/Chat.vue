<template>
  <div class="w-100" style="float:left;">
      <h1 class="text-dark">Chat</h1>
      <ul class="list-group w-100">
            <li v-for="user in filterUsers"  class="list-group-item w-100" >
                <router-link :to="{ name: 'ChatUser', params: { username: user.username}}" >
                     <div class="row">
                        <div class="col-lg d-flex justify-content-start ">
                            {{user.username}}
                        </div>
                        </div>
                </router-link>
            </li>
    </ul>
        <div  v-if="this.loading == 1" class=" d-flex justify-content-center w-100 p-3">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only" ></span>
            </div>
        </div>
  </div> 
</template>

<script>
import Vue from 'vue'
export default {
    name: "Chat",
    components: {
    },
    data () { 
        return {
            loading:1,
            users:[],
            board_categories:[],
        }
    },
    created () {
    },
    computed: {
        filterUsers: function(){
            return this.users.filter(user => user.username!=this.$root.user.username)
        }
    },
    mounted() {
        this.setBreadCrumb();
            this.load();
    },
    methods: {
        setBreadCrumb() {
            this.$root.$emit('addBreadCrumbElement', [
                {
                    title:"Chat",
                    target: 'Chat',
                    params: {},
                },
            ])
        },
        load() {
            var headers={'Content-Type': 'application/json',};
            if (Vue.$cookies.get("Bearer")!=null) {
                headers.Authorization = "Bearer " + Vue.$cookies.get("Bearer");
            }
            axios
                .get('/api/users.json',{
                    headers
                })
            .then(response => (this.users=response.data,this.loading=0)).catch(error=>(this.load()));
        },
    },
};
</script>