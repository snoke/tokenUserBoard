<template>
  <div class="w-100 pt" style="float:left;">
      <ul class="list-group w-100">
          <li class="list-group-item w-100" v-if="$root.user.roles.includes('ROLE_GUEST')">
              <router-link :to="{ name: 'Login'}" >
                    <div class="row">
                      <div class="col-lg d-flex justify-content-start ">
                          Login
                      </div>
                    </div>
              </router-link>
          </li>
          <li class="list-group-item w-100" v-if="$root.user.roles.includes('ROLE_GUEST')">
              <router-link :to="{ name: 'Register'}" >
                    <div class="row">
                      <div class="col-lg d-flex justify-content-start ">
                          Register
                      </div>
                    </div>
              </router-link>
          </li>
          <li class="list-group-item w-100" v-if="!$root.user.roles.includes('ROLE_GUEST')">
              <router-link :to="{ name: 'Logout'}" >
                    <div class="row">
                      <div class="col-lg d-flex justify-content-start ">
                          Logout
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
          loading:0
      }
    },
    mounted () {
        this.setBreadCrumb();
    },
    computed: {
    },

    methods: {
        setBreadCrumb() {
            this.$root.$emit('setBreadCrumb', [
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
