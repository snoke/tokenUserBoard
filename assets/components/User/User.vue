<template>
  <div class="w-100 pt" style="float:left;">
      <ul class="list-group w-100">
          <li class="list-group-item w-100" >
              <router-link :to="{ name: 'UserProfile', params: { username: $root.user.username}}" >
                    <div class="row">
                      <div class="col-lg d-flex justify-content-start ">
                          Einstellungen
                      </div>
                    </div>
              </router-link>
          </li>
    </ul>
        <div  v-if="this.loading == 1" class=" d-flex justify-content-center w-100 p-3">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only" ></span>
            </div>
        </div>
  </div> 
</template>

<script>
export default {
    name: "User",
    components: {
    },
    created () {
    },
    computed: {
    },

    mounted() {
        this.setBreadCrumb();
            this.load();
    },
    methods: {
        setBreadCrumb() {
            this.$root.$emit('setBreadCrumb', [
                {
                    title:"User",
                    target: 'User',
                    params: {},
                },
            ])
        },
    },
};
</script>
