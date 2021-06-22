<template>
    <div>
        <BreadCrumb />
        <div v-if="this.loading == 1" class="spinner-border text-primary" role="status">
            <span class="sr-only" ></span>
        </div>
        <ul>
            <li v-bind:key="category.id" v-for="category in board_categories">
                <router-link :to="{ name: 'BoardCategory', params: { categoryId: category.id}}">{{category.name}}</router-link>
            </li>
        </ul>
    </div>
</template>

<script>
import Vue from 'vue'
import BreadCrumb from './BreadCrumb.vue'

export default {
    name: "Board",
    components: {
        BreadCrumb
    },
    data () { 
        return {
            loading:0,
            board_categories:[],
        }
    },
    created () {
    },
    computed: {
        isLoading() {
            return this.loading;
        }
    },

    mounted() {
            this.load();
    },
    methods: {
        load() {
            this.loading=1;
            axios
                .get('/api/board_categories.json',{
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                    }
                })
            .then(response => (this.board_categories=response.data,this.loading=0)).catch(error=>(this.load()));
        },
    },
};
</script>
