<template>
    <div>
        <BreadCrumb />
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
            board_categories:[],
        }
    },
    created () {
    },
    computed: {
    },

    mounted() {
            this.loadCategories();
    },
    methods: {
        loadCategories() {
            axios
                .get('/api/board_categories.json',{
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": "Bearer " + Vue.$cookies.get("Bearer")
                    }
                })
            .then(response => (this.board_categories=response.data));
        },
    },
};
</script>
