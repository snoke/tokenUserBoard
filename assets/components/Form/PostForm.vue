<template>
<div class="jumbotron p-3">
    <div class="p-4 card list-menu-item" >
      <form v-on:submit="submit" id="postForm">
          <div class="row pb-3">
              <h5 class="card-subtitle text-muted mb-2">Antwort schreiben</h5>
             
            </div>
          <div class="row pb-1">
        <textarea name="message"  class="form-control" placeholder="Nachricht" />
            </div>
          <div class="row pb-1">
        <input type="submit"  class="btn btn-primary" value="Nachricht schreiben" />
            </div>
    </form>
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
      }
    },
    created () {
    },
    computed: {
    },

    methods: {
        submit(e) {
            e.preventDefault();
            var data = new FormData(document.getElementById('postForm'));
            var message = data.get("message");
            
            axios
                .post('/api/board_posts',{
                    author:'/api/users/'+this.$root.user.username,
                    BoardTopic:'/api/board_topics/'+this.$route.params.topicId,
                    message
                },
                {
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                    }
                })
            .then(response => (this.$router.go() ));
        }
    }
};
</script>
