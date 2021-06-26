<template>
<div>
  <b-navbar toggleable="lg" type="dark" class="p-3" variant="dark" stlye="margin-bottom:10px;">

           
    <b-navbar-brand> <router-link :to="{ name: 'Board'}">tokenUserBoard</router-link></b-navbar-brand>

    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>

      <!-- Right aligned nav items -->
      <b-navbar-nav class="ml-auto">
        <b-nav-item>
          <router-link :to="{ name: 'Board'}">Board</router-link>
          </b-nav-item>
        <b-nav-item>
          <router-link :to="{ name: 'Chat'}">Chat</router-link>
          </b-nav-item>
        <b-nav-item-dropdown right>
          <!-- Using 'button-content' slot -->
          <template #button-content>
            <em>{{$root.user.username}}</em>
          </template>
          <!--<b-dropdown-item href="#">Profile</b-dropdown-item>-->
          
          <b-dropdown-item  v-if="$root.user.roles.includes('ROLE_USER')" ><router-link :to="{ name: 'UserProfile', params: { username: $root.user.username}}">Einstellungen</router-link></b-dropdown-item>
          <b-dropdown-item   v-if="$root.user.roles.includes('ROLE_USER')" ><router-link :to="{ name: 'Logout'}">Ausloggen</router-link></b-dropdown-item>
          <b-dropdown-item   v-if="$root.user.roles.includes('ROLE_GUEST')" ><router-link :to="{ name: 'Register'}">Registrieren</router-link></b-dropdown-item>
          <b-dropdown-item  v-if="$root.user.roles.includes('ROLE_GUEST')" ><router-link :to="{ name: 'Login'}">Einloggen</router-link></b-dropdown-item>
        </b-nav-item-dropdown>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar><div class="breadcrumb_seperator"></div> 
</div>
</template>


<script>
import Login from './Auth/Login';
import Register from './Auth/Register';
import UserProfile from './User/UserProfile';
export default {
    name: "Navbar",
    components: {
        UserProfile,Register,Login
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
    }
};
</script>
