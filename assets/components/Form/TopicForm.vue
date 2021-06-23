<template>
<div class="jumbotron p-3">
    <div class="p-4 card list-menu-item" >
      <form v-on:submit="submit" id="topicForm">
          <div class="row pb-3">
              <h5 class="card-subtitle text-muted mb-2">Thema verfassen</h5>
            </div>
          <div class="row pb-1">
            <input type="text" class="form-control" name="name"  placeholder="Thema" />
            </div>
          <div class="row pb-1">
        <textarea name="message" class="form-control" placeholder="Nachricht" />
            </div>
          <div class="row pb-1">
        <input type="submit" class="btn btn-primary" value="Thema erstellen"  />
            </div>
    </form>
            </div>

</div>
</template>


<script>
import Vue from 'vue'
export default {
    name: "TopicForm",
    components: {
    },
     data() {
      return {
      }
    },
    created () {
    },
    computed: {
    },

    methods: {
        postPost(newTopic) {
            var data = new FormData(document.getElementById('topicForm'));
            
            var message = data.get("message");
            
            axios
                .post('/api/board_posts',{
                    author:'/api/users/'+this.$root.user.username,
                    BoardTopic:'/api/board_topics/'+newTopic.id,
                    message
                },
                {
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                    }
                })
            .then(response => (this.$router.push({ name: 'BoardTopic', params: { categoryId: this.$route.params.categoryId,topicId: newTopic.id, } }))).catch(error=>(this.postPost(newTopic)));

        },
        postTopic() {
            var data = new FormData(document.getElementById('topicForm'));
            var name = data.get("name");
            
            axios
                .post('/api/board_topics',{
                    BoardCategory:'/api/board_categories/'+this.$route.params.categoryId,
                    name
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
            this.postTopic();
        }
    }
};
</script>
