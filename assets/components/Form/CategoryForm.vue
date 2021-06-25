<template>
<div class="jumbotron p-3">
    <div class="p-4 card list-menu-item" >
      <form v-on:submit="submit" id="categoryForm">
          <div class="row pb-3">
              <h5 class="card-subtitle text-muted mb-2">Kategorie anlegen</h5>
             
            </div>
          <div class="row pb-1">
            <textarea name="name"  class="form-control" placeholder="name" />
            </div>
          <div class="row pb-1">
        <input type="submit"  class="btn btn-primary" value="Kategorie anlegen" />
            </div>
    </form>
</div>
            </div>
</template>


<script>
import Vue from 'vue'
export default {
    name: "CategoryForm",
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
            var headers={'Content-Type': 'application/json',};
            if (Vue.$cookies.get("Bearer")!=null) {
                headers.Authorization = "Bearer " + Vue.$cookies.get("Bearer");
            }
            e.preventDefault();
            var data = new FormData(document.getElementById('categoryForm'));
            var name = data.get("name");
            
            axios
                .post('/api/board_categories',{
                    name
                },
                {
                    headers
                })
            .then(response => (this.$router.go(0))).catch(error=>(this.submit(e)));
        }
    }
};
</script>
