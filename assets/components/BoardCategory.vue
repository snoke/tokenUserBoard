<template>
<div>
        <BreadCrumb :category=board_category />
    <div v-if="this.loading == 1" class="spinner-border text-primary" role="status">
        <span class="sr-only" ></span>
    </div>
    <ul class="list-group" v-if="this.loading == 0">
        <li v-bind:key="topic.id" v-for="topic in board_topics" class="list-group-item" @click="$root.$emit('update')">
            <router-link :to="{ name: 'BoardTopic', params: { topicId: topic.id}}" >{{topic.name}}</router-link>
         </li>
    </ul>
    <TopicForm />
</div>
</template>

<script>
import Vue from 'vue'
import BreadCrumb from './BreadCrumb.vue'
import TopicForm from './Form/TopicForm.vue'

export default {
    name: "BoardCategory",
    components: {
        BreadCrumb,
        TopicForm
    },
    data () { 
        return {
            loading:1,
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
        setReady(i) {
            if (i==this.board_category.boardTopics.length-1) {
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
            .then(response => (this.board_category = response.data,this.loadTopics())).catch(error=>(this.load()));
        },
        loadTopic(item,i) {
            axios
                .get(item,{
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                    }
                })
            .then(response => (this.board_topics.push(response.data),this.setReady(i))).catch(error=>(this.loadTopic(item,i)));
        },
        loadTopics() {
            if (this.board_category.boardTopics.length==0) {
                this.loading=0
            }
            this.board_category.boardTopics.forEach((item,i) => ( this.loadTopic(item,i) ))
        },
    },
};
</script>
