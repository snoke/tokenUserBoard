<template>
<div>
    <BreadCrumb :category="board_category" />
    <div v-if="this.loading == 1" class="spinner-border text-primary" role="status">
        <span class="sr-only" ></span>
    </div>
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
            loading:0,
            board_category:null,
            board_topics:[],
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
            .then(response => (this.board_category = response.data,this.loadTopics(),this.loading=0)).catch(error=>(this.load()));
        },
        loadTopic(item) {
            this.loading=1;
            axios
                .get(item,{
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                    }
                })
            .then(response => (this.board_topics.push(response.data),this.loading=0)).catch(error=>(this.loadTopic(item)));
        },
        loadTopics() {
            
            this.board_category.boardTopics.forEach(item => ( this.loadTopic(item) ))
        },
    },
};
</script>
