<template>
  <div>
        <Navbar />
        <BreadCrumb />
      <h1 class="text-dark">Register</h1>
      <form v-on:submit="submit" id="RegisterForm" >
        <input name="email" type="text"  placeholder="email" />
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

    methods: {
        submit(e) {
            e.preventDefault();
            var form = document.getElementById('RegisterForm');
            var data = new FormData(form);
            var email = data.get("email");
            var username = data.get("username");
            var password = data.get("password");
            axios
                .post('/api/users',{email,username,password},{
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
            .then(response => (this.setToken(response.data.token)))
        }
    },
};
</script>
