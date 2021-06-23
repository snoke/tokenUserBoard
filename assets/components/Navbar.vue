<template>
<div>
  <b-navbar toggleable="lg" type="dark" class="p-3" variant="dark">

           
    <b-navbar-brand> <router-link :to="{ name: 'Board'}">tokenUserBoard</router-link></b-navbar-brand>

    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>

      <!-- Right aligned nav items -->
      <b-navbar-nav class="ml-auto">

        <b-nav-item-dropdown right>
          <!-- Using 'button-content' slot -->
          <template #button-content>
            <em>{{$root.user.username}}</em>
          </template>
          <b-dropdown-item href="#">Profile</b-dropdown-item>
          <b-dropdown-item href="#" @click="logout()">Sign Out</b-dropdown-item>
        </b-nav-item-dropdown>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
</div>
</template>


<script>
export default {
    name: "Navbar",
    components: {
    },
     data() {
      return {
      }
    },
    created () {
    },
    computed: {
    },

    methods: {
        logout() {
            this.$root.logout();
        }
    }
};
</script>
