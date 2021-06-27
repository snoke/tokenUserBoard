<template>
<div>
        <Navbar />
        <BreadCrumb />
    <router-view />
</div>
</template>


<script>
import Login from './Login';
import Logout from './Logout';
import Register from './Register';
export default {
    name: "Auth",
    components: {
        Login,Register,Logout
    },
     data() {
      return {
      }
    },
    mounted () {
        this.setBreadCrumb();
    },
    computed: {
    },

    methods: {
        setBreadCrumb() {
            this.$root.$emit('addBreadCrumbElement', [
                {
                    title:"Auth",
                    target: 'Auth',
                    params: {},
                },
            ])
        },
    }
};
</script>
