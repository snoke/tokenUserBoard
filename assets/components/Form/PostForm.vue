<template>
      <form v-on:submit="submit" id="postForm">
          <div class="row">
        <textarea name="message" placeholder="Nachricht" />
            </div>
          <div class="row">
        <input type="submit"  class="btn btn-primary" value="Nachricht schreiben"/>
            </div>
    </form>

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
            .then(response => (alert('done'))).catch(error=>(this.submit(e)));
        }
    }
};
</script>
