<template>
<!--
    <b-carousel
      id="carousel-auth"
      v-model="slide"
      :interval="0"
      controls
      indicators
      background="#ababab"
      @sliding-start="onSlideStart"
      @sliding-end="onSlideEnd"
      class="main_carousel h-100"
    >

      <b-carousel-slide>
        <template #img>
            <div class="main_carousel_slide_container d-flex justify-content-center">
                <div class="jumbotron">
                    <div class="card">
                        <div class="card-body">
                            -->
                            <Login />
                             <!--
                            </div>
                    </div>
                </div>
            </div>
        </template>
      </b-carousel-slide>
      <b-carousel-slide>
        <template #img>
            <div class="main_carousel_slide_container d-flex justify-content-center">
                <div class="jumbotron">
                    <div class="card">
                        <div class="card-body"><Register /></div>
                    </div>
                </div>
            </div>
        </template>
      </b-carousel-slide>

    </b-carousel>
                            -->
</template>


<script>
import Login from './Login';
import Register from './Register';
export default {
    name: "Auth",
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
