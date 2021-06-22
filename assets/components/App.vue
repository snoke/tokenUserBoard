<template>
  <div class="h-100">
        <router-view>
          <Auth v-if="this.$root.unauthenticated"/>
          <Board v-if="this.$root.authenticated" />
        </router-view>
  </div> 
</template>

<script>
import Vue from 'vue'
import Auth from './Auth';
import Board from './Board';
export default {
    name: "App",
    components: {
        Auth,
        Board
    },
    data () { 
        return {
            slide: 0,
            sliding: null
        }
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
    },
};
</script>
