<template>
    <div>
        <div id="breadcrumb">
            
            <div v-for="(breadcrumb,index) in breadcrumbs" class="breadcrumb_element">

                <div v-if="index!=0" class="breadcrumb_divider">></div> 
                <router-link  v-if="index!=breadcrumbs.length-1" class="breadcrumb_item" :to="{ name: breadcrumb.target,params:breadcrumb.params}">{{breadcrumb.title}}</router-link>
                <span  v-if="index==breadcrumbs.length-1" class="breadcrumb_item">{{breadcrumb.title}}</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "BreadCrumb",
    components: {
    },
    data() {
        return {
            breadcrumbs:[]
        }
    },
    mounted() {
        this.$root.$on('addBreadCrumbElement', (elements) => {
            this.breadcrumbs=[];
            console.log(elements);
            elements.forEach(e=>  this.breadcrumbs.push(e));
        })
    },
    methods: {
    },
};
</script>
