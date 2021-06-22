<template>
      <form v-on:submit="submit" id="topicForm">
          <div class="row">
            <input type="text" name="name"  placeholder="Titel" />
            </div>
          <div class="row">
        <textarea name="message"  placeholder="Nachricht" />
            </div>
          <div class="row">
        <input type="submit" class="btn btn-primary" value="Topic erstellen"  />
            </div>
    </form>

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
            .then(response => (alert('done'))).catch(error=>(this.postPost(newTopic)));

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
