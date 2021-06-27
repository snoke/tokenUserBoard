<template>
  <div class="w-100" style="float:left;">
    <router-view />
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
