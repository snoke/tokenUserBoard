<template>
<div>
        <Navbar />
        <BreadCrumb :category=board_category />
    <ul class="list-group ">
        <li v-bind:key="topic.id" v-for="topic in board_topics" class="list-group-item list-menu-item" @click="$root.$emit('update')">
                <router-link :to="{ name: 'BoardTopic', params: { topicId: topic.id}}"  class="menu-item">
                    <div class="row">
                        <div class="col d-flex justify-content-center ">
                            {{topic.name}}
                        </div>
                        <div  v-if="$root.user.roles.includes('ROLE_MODERATOR')"  class="col d-flex justify-content-center">
    <div>
    <b-dropdown text="Aktion" class="m-md-2" variant="primary">
        <b-dropdown-item  class=" ">Bearbeiten</b-dropdown-item>
        <b-dropdown-item class="">Verschieben</b-dropdown-item>
        <b-dropdown-divider></b-dropdown-divider>
        <b-dropdown-item class=" btn-danger">Löschen</b-dropdown-item>
    </b-dropdown>
    </div>
                        </div>
                    </div>
                </router-link>
         </li>
    </ul>
        <div  v-if="this.loading == 1" class=" d-flex justify-content-center w-100 p-3">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only" ></span>
            </div>
        </div>
    <TopicForm />
</div>
</template>

<script>
import Navbar from './Navbar.vue'
import Vue from 'vue'
import BreadCrumb from './BreadCrumb.vue'
import TopicForm from './Form/TopicForm.vue'

export default {
    name: "BoardCategory",
    components: {
        Navbar,
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
            if (i==this.board_category.boardTopics.length) {
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
        loadTopic(items,i) {
            if (i==items.length) {
                this.setReady(i)
                return;
            }
            axios
                .get(items[i]+'.json',{
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                    }
                })
            .then(response => (this.board_topics[i]=response.data,this.loadTopic(items,i+1))).catch(error=>(this.loadTopic(item,i)));
        },
        loadTopics() {
            if (this.board_category.boardTopics.length==0) {
                this.loading=0
            }
            this.loadTopic(this.board_category.boardTopics,0 )
        },
    },
};
</script>
