<template>

    <b-carousel
      id="carousel-1"
      v-model="slide"
      :interval="0"
      controls
      indicators
      background="#ababab"
      @sliding-start="onSlideStart"
      @sliding-end="onSlideEnd"
      class="main_carousel h-100"
    >

      <!-- -->
      <b-carousel-slide v-bind:key="category.id" v-for="category in board_categories">
        <template #img>
            <div class="main_carousel_slide_container d-flex justify-content-center">
                <div class="jumbotron">
                    <div class="card">
                        <div class="card-body">{{category.name}}</div>
                        <div class="card-text">asd</div>
                    </div>
                </div>
            </div>
        </template>
      </b-carousel-slide>

    </b-carousel>

</template>

<script>
import Vue from 'vue'

export default {
    name: "Board",
    components: {
    },
    data () { 
        return {
            slide:0,
            page:1,
            board_categories:[],
            board_topics:[],
        }
    },
    created () {
    },
    computed: {
    },

    mounted() {
            this.loadCategories();
    },
    methods: {
      onSlideStart(slide) {
          this.board_category=null;
      },
      onSlideEnd(slide) {
        console.log(this.board_categories[slide]);
            axios
                .get('/api/board_categories/'+this.board_categories[slide].id +'.json',{
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                    }
                })
            .then(response => (this.board_category=response.data));
      },
        loadCategories() {
            axios
                .get('/api/board_categories.json',{
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                    }
                })
            .then(response => (this.board_categories=response.data));
        },
        submit(e) {
            e.preventDefault();
        }
    },
};
</script>
