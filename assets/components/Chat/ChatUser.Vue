<template>
  <div>
    <br />
      <h1 class="text-dark">{{user.username}}</h1>
      <form id="ChatMessageForm"  v-on:submit="submit" >
      <div class="row">
          <div class="col" id="chatMessagesContainer">
            <ul>
                <li v-for="message in messages" >
                    <div v-if="message.recipient!=$root.user.api">
                        <div class="alert alert-success" v-if="message.delivered!=null">
                                
                        <span class="row">{{message.message}}</span>
                        <span class="row text-muted">{{message.sent}}</span>
                        </div>
                        <div class="alert alert-info" v-if="message.delivered==null">
                        <span class="row">{{message.message}}</span>
                        <span class="row text-muted">{{message.sent}}</span>
                        </div>
                    </div>
                    <div class="alert alert-primary" v-if="message.recipient==$root.user.api">
                        <span class="row">{{message.message}}</span>
                        <span class="row text-muted">{{message.sent}}</span>
                    </div>
                </li>
            </ul>
          </div>
        </div>
      <div class="row">
          <div class="col">
              <!--
        <div  v-if="this.loading == 1" class=" d-flex justify-content-center w-100 p-3">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only" ></span>
            </div>
        </div>
        -->
          </div>
        </div>
      <div class="row">
          <div class="col">
            <textarea name="message" class="w-100" placeholder="Nachricht" id="ChatMessage" />
          </div>
        </div>
      <div class="row">
          <div class="col">
            <input type="submit"  class="w-100 btn btn-primary" value="Nachricht schreiben"/>
          </div>
        </div>
        </form>
  </div> 
</template>

<script>
import Vue from 'vue'
export default {
    name: "ChatUser",
    components: {
    },
    data () { 
        return {
            timer:5000, //milliseconds interval to refresh chat messages
            loading:1,
            user:{},
            messages:[],
        }
    },
    created () {
    },
    computed: {
    },
    methods: {
        setDelivered(i) {
            if (i==this.messages.length) {
                
                this.loading=false;
                setTimeout(() => this.loadMessages(), 5000)
                return true;
            }
            if (this.messages[i].delivered==null) {
                var headers={'Content-Type': "application/merge-patch+json"};
                    if (Vue.$cookies.get("Bearer")!=null) {
                        headers.Authorization = "Bearer " + Vue.$cookies.get("Bearer");
                    }
                    axios
                        .patch('/api/chat_messages/' + this.messages[i].id + '.json',
                            {
                                delivered:this.$root.getNow()
                            },{
                                headers
                            }
                            
                        )
                    .then(response => (this.messages[i]=response.data,this.setDelivered(i+1))).catch(error=>(this.setDelivered(i)));
            } else {
                return this.setDelivered(i+1);
            }
        },
        load() {
            var headers={'Content-Type': 'application/json',};
            if (Vue.$cookies.get("Bearer")!=null) {
                headers.Authorization = "Bearer " + Vue.$cookies.get("Bearer");
            }
            axios
                .get('/api/users/' + this.$route.params.username + '.json',{
                    headers
                })
            .then(response => (this.user=response.data,this.loadMessages())).catch(error=>(this.load()));
        },
        loadMessages() {
            this.loading=true;
            var headers={'Content-Type': 'application/json',};
            if (Vue.$cookies.get("Bearer")!=null) {
                headers.Authorization = "Bearer " + Vue.$cookies.get("Bearer");
            }
            axios
                .get('/api/getChatMessages/' + this.user.username ,{
                    headers
                })
            .then(response => (this.messages=response.data,this.setDelivered(0))).catch(error=>(this.loadMessages()));
            //.then(response => (this.messages=response.data,this.loading=false,setTimeout(() => this.loadMessages(), 5000))).catch(error=>(this.loadMessages()));
        },
        submit(e) {
            if (e!=null) {
                e.preventDefault();
            }
            var form = document.getElementById('ChatMessageForm');
            var data = new FormData(form);
            var message = data.get("message");
            axios
                .post('/api/chat_messages',{
                        "message": message,
                        "author": '/api/users/' + this.$root.user.username,
                        "recipient": '/api/users/' + this.user.username,
                        "sent": this.$root.getNow(),
                        "seen": null,
                        "delivered": null
                    },{
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
            .then(response => (document.getElementById('ChatMessage').value=null,this.loadMessages()))
        }
    },
    mounted() {
        this.load();
        //this.$root.$on('openChat', (user) => { alert("chat with " + user.username)})
    }
};
</script>