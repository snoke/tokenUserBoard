<template>
  <div>
      <h1 class="text-dark">Login</h1>
      <form v-on:submit="submit" id="loginForm" >
        <input name="username"  type="text" placeholder="username" value="test" />
        <input name="password"  type="password" placeholder="password" value="test" />
        <input type="submit" />
      </form>
  </div> 
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
export default {
    name: "Login",
    components: {
    },
    mounted() {
        this.setBreadCrumb();
        //this.submit(null);
    },
    methods: {
        setBreadCrumb() {
            this.$root.$emit('addBreadCrumbElement', [
                {
                    title:"Auth",
                    target: 'Auth',
                    params: {},
                },
                {
                    title:"Login",
                    target: 'Login',
                    params: {},
                },
            ])
        },
        setToken(token) {
            Vue.$cookies.set('Bearer',token);
            this.$root.$emit('userAuthenticated', 'userAuthenticated')
        },
        submit(e) {
            if (e!=null) {
                e.preventDefault();
            }
            var form = document.getElementById('loginForm');
            var data = new FormData(form);
            var username = data.get("username");
            var password = data.get("password");
            axios
                .post('/api/login_check',{username,password},{
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
            .then(response => (this.setToken(response.data.token),this.$router.push({ name: 'Board'})))
        }
    },
};
</script>
