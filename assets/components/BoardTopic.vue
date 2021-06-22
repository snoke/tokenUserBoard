<template>
<div>
    <BreadCrumb :category="board_category" :topic="board_topic" />
    <ul>
        <li v-bind:key="post.id" v-for="post in board_posts">{{post.message}}
         </li>
    </ul>
</div>
</template>

<script>
import Vue from 'vue'
import BreadCrumb from './BreadCrumb.vue'

export default {
    name: "BoardTopic",
    components: {
        BreadCrumb
    },
    data () { 
        return {
            board_category:null,
            board_topic:null,
            board_posts:[],
        }
    },
    created () {
    },
    computed: {
    },

    mounted() {
        this.loadCategory(this.$route.params.categoryId)
        this.loadTopic(this.$route.params.topicId)
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
            .then(response => (this.board_category = response.data));
        },
        loadTopic(topicId) {
            axios
                .get('/api/board_topics/'+topicId+'.json',{
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                    }
                })
            .then(response => (this.loadPosts(response.data)));
        },
        loadPosts(topic) {
            this.board_topic = topic;
            this.board_topic.boardPosts.forEach(item => (
            axios
                .get(item,{
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                    }
                })
            .then(response => (this.board_posts.push(response.data)))));
        },
    },
};
</script>
