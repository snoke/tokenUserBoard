<template>
<div>
        <Navbar />
        <BreadCrumb :category=board_category :topic=board_topic />
    <ul class="list-group  ">
        <li v-bind:key="post.id" v-for="(post, index) in board_posts"  class="list-group-item list-menu-item">
                <div class="row">
                    <div class="col d-flex justify-content-center ">
                        

  <b-card :title=board_topic.name :sub-title="'von ' + users[post.author].username" v-if="index==0" class="w-100">
    <b-card-text>
{{post.message}}
    </b-card-text>

  </b-card>
  <b-card  :sub-title="'von ' + users[post.author].username" v-if="index>0"  class="w-100 comment">
    <b-card-text>
{{post.message}}
    </b-card-text>

  </b-card>

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
         </li>
    </ul>
        <div  v-if="this.loading == 1" class=" d-flex justify-content-center w-100 p-3">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only" ></span>
            </div>
        </div>
    <PostForm />
</div>
</template>

<script>
import Navbar from './Navbar.vue'
import Vue from 'vue'
import BreadCrumb from './BreadCrumb.vue'
import PostForm from './Form/PostForm.vue'

export default {
    name: "BoardTopic",
    components: {
        Navbar,
        BreadCrumb,
        PostForm
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
        setReady(i) {
            console.log("set ready")
            console.log("i:" + i)
            console.log("length:" + this.board_topic.boardPosts.length)
            if (i>=this.board_topic.boardPosts.length-1) {
                this.loading=0;
                return true
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
        loadAuthor(author,i,items) {
            if (i==items.length) {
                this.setReady(i)
                return;
            }
            if (this.users[author]) {
                console.log(author)
                console.log("this.users")
                console.log(this.users)
                if (!this.setReady(i)) {
                    this.loadPost(items,i+1)
                }
                return;
            }
            axios
                .get(author + '.json',{
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                    }
                })
            .then(response => (this.users[author]=response.data,this.setReady(i),this.loadPost(items,i+1))).catch(error=>(this.loadAuthor(author,i,items)));
        },
        loadPost(items,i) {
            if (i==items.length) {
                return;
            }
            axios
                .get(items[i] + '.json',{
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                    }
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
