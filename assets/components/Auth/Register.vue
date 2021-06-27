<template>
  <div class="w-100" style="float:left;">
      <h1 class="text-dark">Register</h1>
      <form v-on:submit="submit" id="RegisterForm" >
        <!--<input name="email" type="text"  placeholder="email" />-->
        <input name="username" type="text"  placeholder="username" />
        <input name="password"  type="password"  placeholder="password"/>
        <input type="submit"/>
      </form>
  </div> 
</template>

<script>
export default {
    name: "Register",
    components: {
    },
    created () {
    },
    computed: {
    },
    mounted() {
        this.setBreadCrumb();
    },

    methods: {
        setBreadCrumb() {
            this.$root.$emit('setBreadCrumb', [
                {
                    title:"Auth",
                    target: 'Auth',
                    params: {},
                },
                {
                    title:"Register",
                    target: 'Register',
                    params: {},
                },
            ])
        },
        handleError(error) {
            alert(error.response);
        },
        submit(e) {
            e.preventDefault();
            var form = document.getElementById('RegisterForm');
            var data = new FormData(form);
            var username = data.get("username");
            var password = data.get("password");
            //var email = data.get("email");
            axios
                .post('/api/signup',{
                    username,
                    password,
                    //email
                    },{
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
            .then(response => (this.$router.push({ name: 'Login'}))).catch(error => (this.handleError(error)))
        }
    },
};
</script>
