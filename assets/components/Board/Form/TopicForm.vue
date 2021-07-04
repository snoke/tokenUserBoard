<template><div>
    <div class="breadcrumb_seperator" ></div>
<div class="jumbotron p-3">
    <div class="p-4 card list-menu-item" >
      <form v-on:submit="submit" id="topicForm">
          <div class="row pb-3">
              <h5 class="card-subtitle text-muted mb-2" v-if="topic!=null">Thema bearbeiten</h5>
              <h5 class="card-subtitle text-muted mb-2" v-if="topic==null">Thema verfassen</h5>
            </div>
          <div class="row pb-1">
            <input type="text" class="form-control" name="name"  placeholder="Thema" v-if="topic==null" />
            <input type="text" class="form-control" name="name"  placeholder="Thema" v-if="topic!=null" :value="topic.name" />
            </div>
          <div class="row pb-1">
        <textarea name="message"  class="form-control" placeholder="Nachricht"  v-if="topic==null" />
            </div>
          <div class="row pb-1">
        <input type="submit" class="btn btn-primary" value="Thema erstellen" v-if="topic==null"  />
        <input type="submit" class="btn btn-primary" value="Thema bearbeiten" v-if="topic!=null"  />
            </div>
    </form>
            </div>

</div></div>
</template>


<script>
import Vue from 'vue'
export default {
    name: "TopicForm",
    components: {
    },
     data() {
      return {
          topic:null
      }
    },
    created () {
    },
    computed: {
    },

    mounted() {
        this.load();
    },
    methods: {
        load() {
            this.topic=null;
            if (this.$route.params.topicId) {
                
                var headers={'Content-Type': 'application/json',};
                if (Vue.$cookies.get("Bearer")!=null) {
                    headers.Authorization = "Bearer " + Vue.$cookies.get("Bearer");
                }
                axios
                    .get('/api/board_topics/'+this.$route.params.topicId+'.json',{
                        headers
                    })
                .then(response => (this.topic = response.data)).catch(error=>(this.load()));
            }
        },
        postPost(newTopic) {
            var headers={'Content-Type': 'application/json',};
            if (Vue.$cookies.get("Bearer")!=null) {
                headers.Authorization = "Bearer " + Vue.$cookies.get("Bearer");
            }
            var data = new FormData(document.getElementById('topicForm'));
            
            var message = data.get("message");
            
            axios
                .post('/api/board_posts',{
                    author:'/api/users/'+this.$root.user.username,
                    BoardTopic:'/api/board_topics/'+newTopic.id,
                    message,
                        created:this.$root.getNow(),
                        deleted:false
                },
                {
                    headers
                })
            .then(response => (this.$router.go(0))).catch(error=>(this.postPost(newTopic)));

        },
        postTopic() {
            var data = new FormData(document.getElementById('topicForm'));
            var name = data.get("name");
            
            axios
                .post('/api/board_topics',{
                    author:'/api/users/'+this.$root.user.username,
                    BoardCategory:'/api/board_categories/'+this.$route.params.categoryId,
                    name,
                    created:this.$root.getNow(),
                },
                {
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                    }
                })
            .then(response => (this.postPost(response.data))).catch(error=>(this.postTopic()));

        },
        submit(e) {
            e.preventDefault();
            if (this.$route.params.topicId) {
                this.updateOldTopic();
            } else {
                this.postTopic();
            }
        },
        updateOldTopic() {
            var data = new FormData(document.getElementById('topicForm'));
            var name = data.get("name");
            var headers={'Content-Type': "application/merge-patch+json"};
            if (Vue.$cookies.get("Bearer")!=null) {
                headers.Authorization = "Bearer " + Vue.$cookies.get("Bearer");
            }
                axios
                    .patch('/api/board_topics/' + this.$route.params.topicId+'.json',{
                        author:this.topic.author,
                        BoardCategory:'/api/board_categories/'+this.$route.params.categoryId,
                        name:name,
                    },
                    {
                        headers
                    })
                .then(response => (this.$router.push({ name: 'BoardCategory',params:{categoryId:this.$route.params.categoryId}}) ));
        },
    }
};
</script>
