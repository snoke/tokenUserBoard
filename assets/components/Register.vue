<template>
  <div>
      <h1 class="text-dark">Register</h1>
      <form v-on:submit="submit">
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
        }
    },
};
</script>
