<template>
<div>
    <BreadCrumb :category="board_category" :topic="board_topic" />
        <div v-if="this.loading == 1" class="spinner-border text-primary" role="status">
            <span class="sr-only" ></span>
        </div>
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
            loading:0,
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
        this.load()
        
    },
    methods: {
        load() {
            this.loading=1;
            axios
                .get('/api/board_categories/'+this.$route.params.categoryId+'.json',{
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                    }
                })
            .then(response => (this.board_category = response.data),this.loadTopic(),this.loading=0).catch(error=>(this.load()));
        },
        loadTopic() {
            this.loading=1;
            axios
                .get('/api/board_topics/'+this.$route.params.topicId+'.json',{
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                    }
                })
            .then(response => (this.board_topic = response.data,this.loadPosts(),this.loading=0)).catch(error=>(this.loadTopic()));
        },
        loadPost(item) {
            this.loading=1;
            axios
                .get(item,{
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                    }
                }).then(response => (this.board_posts.push(response.data),this.loading=0)).catch(error=>(this.loadPost(item)));
        },
        loadPosts() {
            this.board_topic.boardPosts.forEach(item => (
                this.loadPost(item)
           ));
        },
    },
};
</script>
