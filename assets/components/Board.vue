<template>
  <div @scroll="scroll">
      <ul>
          <li v-for="category in board_categories">
              {{category.name}}
          </li>
        </ul>
  </div> 
</template>

<script>
import Vue from 'vue'

export default {
    name: "Board",
    components: {
    },
    data () { 
        return {
            page:1,
            board_categories:[]
        }
    },
    created () {
    },
    computed: {
    },

    mounted() {
            this.loadCategories();
            this.scroll();
    },
    methods: {
        loadNextCategories() {
            axios
                .get('/api/board_categories.json?page=' + (this.page+1),{
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                    }
                })
            .then(response => (alert("hi")));
        },
        loadCategories() {
            axios
                .get('/api/board_categories.json?page=' + this.page,{
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
