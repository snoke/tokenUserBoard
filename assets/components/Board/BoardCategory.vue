<template>
<div>
<div class="breadcrumb_divider">></div> 
    <div class="breadcrumb_element" >
        <router-link :to="{ name: 'BoardCategory',params:{categoryId:board_category.id}}"  v-if="$route.name!='BoardCategory'">{{board_category.name}}</router-link>
        <a  v-if="$route.name=='BoardCategory'">{{board_category.name}}</a>
        </div>
    <div  v-if="$route.name=='BoardCategory'">
    <ul class="list-group w-100 pt">
        <li v-bind:key="topic.id" v-for="topic in board_topics" class="list-group-item list-menu-item" @click="$root.$emit('update')">
            <router-link :to="{ name: 'BoardTopic', params: { topicId: topic.id}}"  class="menu-item">
                <div class="row">
                    <div class="col-lg d-flex justify-content-start ">
                        {{topic.name}}
                    </div>
                    <div  v-if="$root.user.roles.includes('ROLE_MODERATOR') "  class="col-sm-1 d-flex justify-content-center">
                        <div>
                            <b-dropdown text="Aktion" class="m-md-2" variant="primary">    
                                <b-dropdown-item  class=" "><router-link :to="{ name: 'BoardTopicEdit', params: { categoryId:board_category.id,topicId:topic.id }}">Bearbeiten</router-link></b-dropdown-item>

                                <b-dropdown-item class="" >Verschieben</b-dropdown-item>
                                <b-dropdown-divider ></b-dropdown-divider>
                                <a href="#" v-on:click="remove(topic.id)" ><b-dropdown-item class=" btn-danger">Löschen</b-dropdown-item></a>
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
        <TopicForm v-if=" $root.user.roles.includes('ROLE_USER')" />
</div>
        <router-view />
</div>
</template>

<script>
import Navbar from './../Navbar.vue'
import Vue from 'vue'
import BreadCrumb from './../BreadCrumb.vue'
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
        remove(topicId) {

            var headers={'Content-Type': "application/merge-patch+json"};
            if (Vue.$cookies.get("Bearer")!=null) {
                headers.Authorization = "Bearer " + Vue.$cookies.get("Bearer");
            }
            axios
                .delete('/api/board_topics/'+topicId+'.json',
                    {
                        headers
                    })
            .then(response => (this.$router.go(0))).catch(error=>(this.remove(topicId)));
        },
        setBreadCrumb() {
            this.$root.$emit('addBreadCrumb', {
                title:this.board_category.name,
                target: 'BoardCategory',
                params: {categoryId:this.board_category.id},
            })
        },
        setReady(i) {
            if (i==this.board_category.boardTopics.length) {
                this.loading=0;
            }
        },
        load() {
            
            var headers={'Content-Type': 'application/json',};
            if (Vue.$cookies.get("Bearer")!=null) {
                headers.Authorization = "Bearer " + Vue.$cookies.get("Bearer");
            }

            axios
                .get('/api/board_categories/'+this.$route.params.categoryId+'.json',{
                     headers
                })
            .then(response => (this.board_category = response.data,this.setBreadCrumb(),this.loadTopics())).catch(error=>(this.load()));
        },
        loadTopic(items,i) {
            
            var headers={'Content-Type': 'application/json',};
            if (Vue.$cookies.get("Bearer")!=null) {
                headers.Authorization = "Bearer " + Vue.$cookies.get("Bearer");
            }

            if (i==items.length) {
                this.setReady(i)
                return;
            }
            axios
                .get(items[i]+'.json',{
                     headers
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
