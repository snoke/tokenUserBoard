<template>
    <div class="breadcrumb">
        <div class="breadcrumb_element">
            <router-link :to="{ name: 'Board'}">Board</router-link>
        </div>
        <div v-if="category" class="breadcrumb_seperator"> > </div>
        <div v-if="category" class="breadcrumb_element">
            <router-link :to="{ name: 'BoardCategory', params: { categoryId: category.id}}">{{category.name}}</router-link>
        </div>
        <div  v-if="topic" class="breadcrumb_seperator"> > </div>
        <div  v-if="topic" class="breadcrumb_element">
            <router-link :to="{ name: 'BoardTopic', params: { topicId: topic.id,categoryId: category.id}}">{{topic.name}}</router-link>
        </div>
    </div> 
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
export default {
    name: "BreadCrumb",
    components: {
    },
    props: {
        category: {},
        topic: {},
    },
    methods: {
    },
};
</script>
