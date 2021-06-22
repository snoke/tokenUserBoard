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
                        <div class="card-text">
                            <ul>
                                <li v-bind:key="topic.id" v-for="topic in board_topics">{{topic.name}}</li>
                            </ul>
                        </div>
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
            board_category:[],
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
        loadTopics(category) {
            category.boardTopics.forEach(element => 
                axios
                    .get(element +'.json',{
                        headers: {
                            'Content-Type': 'application/json',
                            "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                        }
                    })
                .then(response => (this.board_topics.push(response.data)))
                //.then(response => (this.board_topics[response.data.id]=response.data))
            );
        },
      onSlideStart(slide) {
          this.board_category=null;
      },
      onSlideEnd(slide) {
          this.board_topics=[];
            axios
                .get('/api/board_categories/'+this.board_categories[slide].id +'.json',{
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                    }
                })
            .then(response => (this.board_categories[slide]=response.data,this.loadTopics(this.board_categories[slide])));
      },
        loadCategories() {
            axios
                .get('/api/board_categories.json',{
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                    }
                })
            .then(response => (this.board_categories=response.data,this.loadTopics(this.board_categories[0])));
        },
        submit(e) {
            e.preventDefault();
        }
    },
};
</script>
