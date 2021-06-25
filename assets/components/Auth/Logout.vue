<template>
  <div>
  </div> 
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
export default {
    name: "Logout",
    components: {
    },
    mounted() {
        this.$root.logout();
      this.$router.push({ name: 'Board'})
    },
    methods: {
    },
};
</script>
