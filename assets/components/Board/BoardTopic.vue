<template>
<div>
    <div  v-if="$route.name=='BoardTopic'">
    <ul class="list-group  w-100 pt">
        <li v-bind:key="post.id" v-for="(post, index) in board_posts"  class="list-group-item list-menu-item">
                <div class="row">
                    <div class="col-lg d-flex justify-content-start ">
  <b-card :title=board_topic.name  v-if="post.deleted==true" class="w-100">
    <b-card-text>
        Diese Nachricht wurde entfernt.
    </b-card-text>
  </b-card>
  
  <b-card :title=board_topic.name  v-if="post.deleted==false && index==0" class="w-100 ">
    <b-card-sub-title>
       von <router-link :to="{ name: 'UserProfile', params: { username: users[post.author].username }}">{{users[post.author].username}}</router-link>
    </b-card-sub-title>
    <b-card-text>
{{post.message}}
    </b-card-text>
  </b-card>
  <b-card   v-if="post.deleted==false && index!=0" class="w-100 comment">
    <b-card-sub-title>
       von <router-link :to="{ name: 'UserProfile', params: { username: users[post.author].username }}">{{users[post.author].username}}</router-link>
    </b-card-sub-title>
    <b-card-text>
{{post.message}}
    </b-card-text>
  </b-card>
  

                    </div>
                    <div  v-if="$root.user.roles.includes('ROLE_MODERATOR') || post.author==$root.user.api"  class="col-sm-1 d-flex justify-content-center">
<div>
  <b-dropdown text="Aktion" class="m-md-2" variant="primary">
    <b-dropdown-item  class=" "><router-link :to="{ name: 'BoardPostEdit', params: { categoryId:board_category.id,topicId:board_topic.id,postId:post.id }}">Bearbeiten</router-link></b-dropdown-item>
    <b-dropdown-divider  v-if="$root.user.roles.includes('ROLE_MODERATOR')"></b-dropdown-divider>
    <a href="#" v-on:click="remove(post.id)" v-if="$root.user.roles.includes('ROLE_MODERATOR')"><b-dropdown-item class=" btn-danger">Löschen</b-dropdown-item></a>
  </b-dropdown>
</div>
                    </div>
                </div>
         </li>
    </ul>
        <div  v-if="this.loading == 1" class=" d-flex justify-content-center w-100 p-3">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only" ></span>
            </div>
        </div>
        <PostForm v-if="$root.user.roles.includes('ROLE_USER')" />
                    </div>
        <router-view />
</div>
</template>

<script>
import Vue from 'vue'
import PostForm from './Form/PostForm.vue'
import Navbar from './../Navbar.vue'
import BreadCrumb from './../BreadCrumb.vue'
import UserProfile from './../User/UserProfile.vue'

export default {
    name: "BoardTopic",
    components: {
        Navbar,
        BreadCrumb,
        PostForm,
        UserProfile
    },
    data () { 
        return {
            loading:1,
            board_category:null,
            board_topic:null,
            board_posts:[],
            users:[],
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
        setBreadCrumb() {
            this.$root.$emit('addBreadCrumbElement', [
                {
                    title:"Board",
                    target: 'Board',
                    params: {}
                },
                {
                    title:this.board_category.name,
                    target: 'BoardCategory',
                    params: {categoryId:this.board_category.id},
                },
                {
                    title:this.board_topic.name,
                    target: 'BoardTopic',
                    params: {topicId:this.board_topic.id,categoryId:this.board_category.id},
                }
            ])
        },
        remove(postId) {

            var headers={'Content-Type': "application/merge-patch+json"};
            if (Vue.$cookies.get("Bearer")!=null) {
                headers.Authorization = "Bearer " + Vue.$cookies.get("Bearer");
            }
            axios
                .delete('/api/board_posts/'+postId+'.json',
                    {
                        headers
                    })
            .then(response => (this.$router.go(0))).catch(error=>(this.remove(postId)));
        },
        setReady(i) {
            if (i>=this.board_topic.boardPosts.length-1) {
                this.loading=0;
                return true
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
            .then(response => (this.board_category = response.data),this.loadTopic()).catch(error=>(this.load()));
        },
        loadTopic() {
            var headers={'Content-Type': 'application/json',};
            if (Vue.$cookies.get("Bearer")!=null) {
                headers.Authorization = "Bearer " + Vue.$cookies.get("Bearer");
            }
            axios
                .get('/api/board_topics/'+this.$route.params.topicId+'.json',{
                    headers
                })
            .then(response => (this.board_topic = response.data,this.setBreadCrumb(),this.loadPosts())).catch(error=>(this.loadTopic()));
        },
        loadAuthor(author,i,items) {
            var headers={'Content-Type': 'application/json',};
            if (Vue.$cookies.get("Bearer")!=null) {
                headers.Authorization = "Bearer " + Vue.$cookies.get("Bearer");
            }
            if (i==items.length) {
                this.setReady(i)
                return;
            }
            if (this.users[author]) {
                if (!this.setReady(i)) {
                    this.loadPost(items,i+1)
                }
                return;
            }
            axios
                .get(author + '.json',{
                    headers
                })
            .then(response => (this.users[author]=response.data,this.setReady(i),this.loadPost(items,i+1))).catch(error=>(this.loadAuthor(author,i,items)));
        },
        loadPost(items,i) {
            var headers={'Content-Type': 'application/json',};
            if (Vue.$cookies.get("Bearer")!=null) {
                headers.Authorization = "Bearer " + Vue.$cookies.get("Bearer");
            }
            if (i==items.length) {
                return;
            }
            axios
                .get(items[i] + '.json',{
                    headers
                })
            .then(response => (this.board_posts[i]=response.data,this.loadAuthor(response.data.author,i,items))).catch(error=>(this.loadPost(item,i)));
        },
        loadPosts() {
            if (this.board_topic.boardPosts.length==0) {
                this.loading=0
            }
                this.loadPost(this.board_topic.boardPosts,0)
        },
    },
};
</script>
