<template>

  <div class="h-100">
          <Navbar />
        <router-view>
        </router-view>
        <Footer />
  </div> 
</template>

<script>
import Vue from 'vue'
import Footer from './Footer';
import Board from './Board';
import BreadCrumb from './BreadCrumb.vue'
import Navbar from './Navbar.vue'
export default {
    name: "App",
    components: {
        Navbar,
        BreadCrumb,Footer
    },
    data () { 
        return {
        }
    },
    computed: {
    },

    mounted () {
      this.$router.push({ name: 'Board'})
    },
    methods: {
    },
};
</script>
