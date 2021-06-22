<template>
<div>
    <BreadCrumb :category="board_category" />
    <ul>
        <li v-bind:key="topic.id" v-for="topic in board_topics">
            <router-link :to="{ name: 'BoardTopic', params: { topicId: topic.id}}">{{topic.name}}</router-link>
         </li>
    </ul>
</div>
</template>

<script>
import Vue from 'vue'
import BreadCrumb from './BreadCrumb.vue'

export default {
    name: "BoardCategory",
    components: {
        BreadCrumb
    },
    data () { 
        return {
            board_category:null,
            board_topics:[],
        }
    },
    created () {
    },
    computed: {
    },

    mounted() {
        this.loadCategory(this.$route.params.categoryId)
    },
    methods: {
        loadCategory(categoryId) {
            axios
                .get('/api/board_categories/'+categoryId+'.json',{
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                    }
                })
            .then(response => (this.loadTopics(response.data)));
        },
        loadTopics(category) {
            this.board_category = category;
            this.board_category.boardTopics.forEach(item => (
            axios
                .get(item,{
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                    }
                })
            .then(response => (this.board_topics.push(response.data)))));
        },
    },
};
</script>
