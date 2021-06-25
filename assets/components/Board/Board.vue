<template>
    <div>
    <div class="breadcrumb_element" >
        <router-link  v-if="$route.name!='Board'" :to="{ name: 'Board'}">tokenUserBoard</router-link>
        <a  v-if="$route.name=='Board'" >tokenUserBoard</a>
    </div>
    <div  v-if="$route.name=='Board'">
        <ul class="list-group w-100 pt">
            <li v-bind:key="category.id" v-for="category in board_categories" class="list-group-item list-menu-item " @click="$root.$emit('update')">
                 <router-link :to="{ name: 'BoardCategory', params: { categoryId: category.id}}" class="menu-item">
                     <div class="row">
                        <div class="col-lg d-flex justify-content-start ">
                                {{category.name}}
                        </div>
                        <div v-if="$root.user.roles.includes('ROLE_MODERATOR')" class="col-sm-1 d-flex justify-content-center">
                            <div>
                            <b-dropdown text="Aktion" class="m-md-2" variant="primary">
                                <b-dropdown-item  class=" ">Bearbeiten</b-dropdown-item>
                                <b-dropdown-divider></b-dropdown-divider>
                                <b-dropdown-item class=" btn-danger">Löschen</b-dropdown-item>
                            </b-dropdown>
                            </div>
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
        <CategoryForm v-if="$root.user.roles.includes('ROLE_MODERATOR')" />
    </div>
        <router-view />
    </div>
</template>

<script>
import Vue from 'vue'

import Navbar from './../Navbar.vue'
import BoardCategory from './BoardCategory.vue'
import BreadCrumb from './../BreadCrumb.vue'
import CategoryForm from './Form/CategoryForm.vue'
export default {
    name: "Board",
    components: {
        Navbar,
        BreadCrumb,
        CategoryForm,BoardCategory
    },
    data () { 
        return {
            loading:1,
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
            var headers={'Content-Type': 'application/json',};
            if (Vue.$cookies.get("Bearer")!=null) {
                headers.Authorization = "Bearer " + Vue.$cookies.get("Bearer");
            }
            axios
                .get('/api/board_categories.json',{
                    headers
                })
            .then(response => (this.board_categories=response.data,this.loading=0)).catch(error=>(this.load()));
        },
    },
};
</script>
