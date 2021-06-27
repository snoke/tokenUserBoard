<template>
    <div>
        <div id="breadcrumb">
            
            <div v-for="(breadcrumb,index) in breadcrumbs" class="breadcrumb_element">

                <div v-if="index==breadcrumbs.length-1" class="text-dark">
                    <div class="breadcrumb_divider">
                        <i class="fas fa-angle-right"></i>
                    </div>
                    <span  class=" breadcrumb_item-active">{{breadcrumb.title}}</span>
                </div>

                <div v-if="index!=breadcrumbs.length-1"  class="text-primary">
                    <div class="breadcrumb_divider">
                        <i class="fas fa-angle-right"></i>
                    </div>
                   <router-link  class="breadcrumb_item" :to="{ name: breadcrumb.target,params:breadcrumb.params}">{{breadcrumb.title}}</router-link>
                </div>

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
        this.$root.$on('setBreadCrumb', (elements) => {
            this.breadcrumbs=[];
            elements.forEach(e=>  this.breadcrumbs.push(e));
        })
    },
    methods: {
    },
};
</script>
