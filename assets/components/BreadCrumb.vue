<template>
    <a v-on:click="back"><i class="fas fa-arrow-left text-primary" ></i></a>
</template>

<script>
export default {
    name: "BreadCrumb",
    components: {
    },
    methods: {
        back: function (e) {
            this.$router.go(-1);
        }
    },
};
</script>
