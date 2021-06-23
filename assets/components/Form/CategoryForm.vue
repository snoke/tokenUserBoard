<template>
      <form v-on:submit="submit" id="categoryForm">
          <div class="row">
        <textarea name="name" placeholder="name" />
            </div>
          <div class="row">
        <input type="submit"  class="btn btn-primary" value="Kategorie anlegen" />
            </div>
    </form>

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
            e.preventDefault();
            var data = new FormData(document.getElementById('categoryForm'));
            var name = data.get("name");
            
            axios
                .post('/api/board_categories',{
                    name
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
