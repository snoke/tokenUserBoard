<template>
<div>
        <BreadCrumb :category=board_category :topic=board_topic />
        <div v-if="this.loading == 1" class="spinner-border text-primary" role="status">
            <span class="sr-only" ></span>
        </div>
    <ul class="list-group" v-if="this.loading == 0">
        <li v-bind:key="post.id" v-for="post in board_posts"  class="list-group-item">{{post.message}}
         </li>
    </ul>
    <PostForm />
</div>
</template>

<script>
import Vue from 'vue'
import BreadCrumb from './BreadCrumb.vue'
import PostForm from './Form/PostForm.vue'

export default {
    name: "BoardTopic",
    components: {
        BreadCrumb,
        PostForm
    },
    data () { 
        return {
            loading:1,
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
        setReady(i) {
            if (i==this.board_topic.boardPosts.length-1) {
                this.loading=0;
            }
        },
        load() {
            axios
                .get('/api/board_categories/'+this.$route.params.categoryId+'.json',{
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                    }
                })
            .then(response => (this.board_category = response.data),this.loadTopic()).catch(error=>(this.load()));
        },
        loadTopic() {
            axios
                .get('/api/board_topics/'+this.$route.params.topicId+'.json',{
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                    }
                })
            .then(response => (this.board_topic = response.data,this.loadPosts())).catch(error=>(this.loadTopic()));
        },
        loadPost(item,i) {
            axios
                .get(item,{
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                    }
                }).then(response => (this.board_posts.push(response.data),this.setReady(i))).catch(error=>(this.loadPost(item,i)));
        },
        loadPosts() {
            if (this.board_topic.boardPosts.length==0) {
                this.loading=0
            }
            this.board_topic.boardPosts.forEach((item,i) => ( 
                this.loadPost(item,i)
           ));
        },
    },
};
</script>
