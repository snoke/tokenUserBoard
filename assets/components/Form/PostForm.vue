<template>
<div>
    <div class="breadcrumb_seperator" ></div>
        <div class="jumbotron p-3">
            <div class="p-4 card list-menu-item" >
                <form v-on:submit="submit" id="postForm">
                    <div class="row pb-3">
                        <h5 class="card-subtitle text-muted mb-2" v-if="post==null">Antwort schreiben</h5>
                        <h5 class="card-subtitle text-muted mb-2" v-if="post!=null">Nachricht bearbeiten</h5>
                    
                    </div>
                    <div class="row pb-1">
                        <textarea name="message"  class="form-control" placeholder="Nachricht"  v-if="post==null" />
                        <textarea name="message"  class="form-control" placeholder="Nachricht"  v-if="post!=null" :value="post.message" />
                    </div>
                    <div class="row pb-1">
                        <input type="submit"  class="btn btn-primary" value="Nachricht schreiben"  v-if="post==null" />
                        <input type="submit"  class="btn btn-primary" value="Nachricht bearbeiten"  v-if="post!=null" />
                    </div>
                </form>
            </div>
        </div>

    </div>
</template>


<script>
import Vue from 'vue'
export default {
    name: "PostForm",
    components: {
    },
     data() {
      return {
          post:null
      }
    },
    mounted() {
        this.load();
    },
    created () {
    },
    computed: {
    },

    methods: {
        load() {
            this.post=null;
            if (this.$route.params.postId) {
                
                var headers={'Content-Type': 'application/json',};
                if (Vue.$cookies.get("Bearer")!=null) {
                    headers.Authorization = "Bearer " + Vue.$cookies.get("Bearer");
                }
                axios
                    .get('/api/board_posts/'+this.$route.params.postId+'.json',{
                        headers
                    })
                .then(response => (this.post = response.data)).catch(error=>(this.load()));
            }
        },
        updateOldPost() {
            var data = new FormData(document.getElementById('postForm'));
            var message = data.get("message");
            var headers={'Content-Type': "application/merge-patch+json"};
            if (Vue.$cookies.get("Bearer")!=null) {
                headers.Authorization = "Bearer " + Vue.$cookies.get("Bearer");
            }
                axios
                    .patch('/api/board_posts/' + this.$route.params.postId+'.json',{
                        author:this.post.author,
                        BoardTopic:'/api/board_topics/'+this.$route.params.topicId,
                        message:message,
                        created:this.$root.getNow(),
                        deleted:false
                    },
                    {
                        headers
                    })
                .then(response => (this.$router.push({ name: 'BoardTopic',params:{categoryId:this.$route.params.categoryId,topicId:this.$route.params.topicId}}) ));
        },
        createMemento() {
            var headers={'Content-Type': 'application/json',};
            if (Vue.$cookies.get("Bearer")!=null) {
                headers.Authorization = "Bearer " + Vue.$cookies.get("Bearer");
            }
            axios
                .post('/api/board_post_mementos',{
                    author:'/api/users/'+this.$root.user.username,
                    BoardTopic:'/api/board_topics/'+this.$route.params.topicId,
                    BoardPost:'/api/board_posts/' + this.$route.params.postId,
                    created:this.$root.getNow(),
                    message:this.post.message,
                    deleted:false
                },
                {
                    headers
                })
            .then(response => (this.updateOldPost() ));
        },
        submit(e) {
            e.preventDefault();
            var data = new FormData(document.getElementById('postForm'));
            var message = data.get("message");
            
            if (this.$route.params.postId) {
                this.createMemento();
            } else {
            var headers={'Content-Type': 'application/json',};
            if (Vue.$cookies.get("Bearer")!=null) {
                headers.Authorization = "Bearer " + Vue.$cookies.get("Bearer");
            }
                axios
                    .post('/api/board_posts',{
                        author:'/api/users/'+this.$root.user.username,
                        BoardTopic:'/api/board_topics/'+this.$route.params.topicId,
                        message:message,
                        created:this.$root.getNow(),
                        deleted:false
                    },
                    {
                        headers
                    })
                .then(response => (this.$router.push({ name: 'BoardTopic',params:{categoryId:this.$route.params.categoryId,topicId:this.$route.params.topicId}}) ));

            }
        }
    }
};
</script>
