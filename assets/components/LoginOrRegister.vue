<template>
  <div>
  <b-tabs content-class="mt-3">
    <b-tab title="Login" active><Login /></b-tab>
    <b-tab title="Register"><Register /></b-tab>
  </b-tabs>
  </div>
</template>


<script>
import Login from './Login';
import Register from './Register';
export default {
    name: "LoginOrRegister",
    components: {
        Login,Register
    },
     data() {
      return {
      }
    },
    created () {
    },
    computed: {
    },

    methods: {
    }
};
</script>
